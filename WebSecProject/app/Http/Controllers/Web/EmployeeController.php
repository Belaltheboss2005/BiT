<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    // Show all sellers for management and all pending products
    public function manageSellers()
    {
         if (!Auth::user() || !Auth::user()->can('manage_sellers')) {
            abort(403, 'Unauthorized access');
        }
        $sellers = User::role('Seller')->with('products')->get();
        $pendingProducts = Product::with('seller')->where('status', 'pending')->get();
        $approvedProducts = Product::with('seller')->where('status', 'approved')->orderByDesc('created_at')->get();
        // Only products that are on hold and not soft deleted
        $onHoldProducts = Product::with('seller')
            ->where('status', 'on hold')
            ->whereNull('deleted_at')
            ->orderByDesc('updated_at')
            ->get();
        return view('employee.manage_seller', compact('sellers', 'pendingProducts', 'approvedProducts', 'onHoldProducts'));
    }

    // Activate a seller
    public function activateSeller($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_sellers')) {
            abort(403, 'Unauthorized access');
        }
        $seller = User::findOrFail($id);
        $seller->is_active = true;
        $seller->save();
        return redirect()->route('employee.manage_seller')->with('success', 'Seller activated successfully!');
    }

    // Deactivate a seller
    public function deactivateSeller($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_sellers')) {
            abort(403, 'Unauthorized access');
        }
        $seller = User::findOrFail($id);
        $seller->is_active = false;
        $seller->save();
        return redirect()->route('employee.manage_seller')->with('success', 'Seller deactivated successfully!');
    }

    // Show all orders for management
    public function manageOrders()
    {
        if (!Auth::user() || !Auth::user()->can('manage_orders')) {
            abort(403, 'Unauthorized access');
        }
        // Show all orders (not just pending) for return requests
        $orders = Order::with(['user', 'ordered_items.product'])->orderByDesc('created_at')->get();
        // Prepare return requests for approved or on hold products
        $returnRequests = [];
        foreach ($orders as $order) {
            foreach ($order->ordered_items ?? [] as $item) {
                $productStatus = $item->product->status ?? null;
                if (($item->status ?? null) === 'pending return request' && in_array($productStatus, ['approved', 'on hold'])) {
                    $returnRequests[] = ['order' => $order, 'item' => $item];
                }
            }
        }
        return view('employee.manage_order', compact('orders', 'returnRequests'));
    }

    // Accept a pending order
    public function acceptOrder($id)
    {
        if (!Auth::user() || !Auth::user()->can(abilities: 'manage_orders')) {
            abort(403, 'Unauthorized access');
        }
        $order = Order::findOrFail($id);
        if ($order->status === 'pending') {
            $order->status = 'accepted';
            $order->save();
            return redirect()->route('employee.manage_orders')->with('success', 'Order accepted!');
        }
        return redirect()->route('employee.manage_orders')->with('error', 'Order cannot be accepted.');
    }

    // Cancel a pending order
    public function cancelOrder($id)
    {
        if (!Auth::user() || !Auth::user()->can(abilities: 'manage_orders')) {
            abort(403, 'Unauthorized access');
        }
        $order = Order::findOrFail($id);
        if ($order->status === 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('employee.manage_orders')->with('success', 'Order cancelled!');
        }
        return redirect()->route('employee.manage_orders')->with('error', 'Order cannot be cancelled.');
    }

    // Approve a pending product
    public function approveProduct($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_products')) {
            abort(403, 'Unauthorized access');
        }
        $product = Product::findOrFail($id);
        if ($product->status === 'pending') {
            $product->status = 'approved';
            $product->save();
            return redirect()->route('employee.manage_seller')->with('success', 'Product approved!');
        }
        return redirect()->route('employee.manage_seller')->with('error', 'Product cannot be approved.');
    }

    // Deny a pending product
    public function denyProduct($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_products')) {
            abort(403, 'Unauthorized access');
        }
        $product = Product::findOrFail($id);
        if ($product->status === 'pending') {
            $product->status = 'denied';
            $product->save();
            return redirect()->route('employee.manage_seller')->with('success', 'Product denied!');
        }
        return redirect()->route('employee.manage_seller')->with('error', 'Product cannot be denied.');
    }

    // Put product on hold
    public function holdProduct($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_products')) {
            abort(403, 'Unauthorized access');
        }
        $product = Product::findOrFail($id);
        if ($product->status !== 'on hold') {
            $product->status = 'on hold';
            $product->save();
            return redirect()->route('employee.manage_seller')->with('success', 'Product put on hold.');
        }
        return redirect()->route('employee.manage_seller')->with('info', 'Product is already on hold.');
    }

    // Delete product (only if on hold)
    public function deleteProduct($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_products')) {
            abort(403, 'Unauthorized access');
        }
        $product = Product::findOrFail($id);
        if ($product->status === 'on hold') {
            $product->delete();
            return redirect()->route('employee.manage_seller')->with('success', 'Product deleted.');
        }
        return redirect()->route('employee.manage_seller')->with('error', 'Product must be on hold to delete.');
    }

    // Resume (approve) a product that is on hold
    public function resumeProduct($id)
    {
        if (!Auth::user() || !Auth::user()->can('manage_products')) {
            abort(403, 'Unauthorized access');
        }
        $product = Product::findOrFail($id);
        if ($product->status === 'on hold') {
            $product->status = 'approved';
            $product->save();
            return redirect()->route('employee.manage_seller')->with('success', 'Product resumed and approved.');
        }
        return redirect()->route('employee.manage_seller')->with('error', 'Only products on hold can be resumed.');
    }
}
