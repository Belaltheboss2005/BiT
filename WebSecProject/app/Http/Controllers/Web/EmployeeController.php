<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class EmployeeController extends Controller
{
    // Show all sellers for management and all pending products
    public function manageSellers()
    {
        $sellers = User::role('Seller')->with('products')->get();
        $pendingProducts = Product::with('seller')->where('status', 'pending')->get();
        return view('employee.manage_seller', compact('sellers', 'pendingProducts'));
    }

    // Activate a seller
    public function activateSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->is_active = true;
        $seller->save();
        return redirect()->route('employee.manage_seller')->with('success', 'Seller activated successfully!');
    }

    // Deactivate a seller
    public function deactivateSeller($id)
    {
        $seller = User::findOrFail($id);
        $seller->is_active = false;
        $seller->save();
        return redirect()->route('employee.manage_seller')->with('success', 'Seller deactivated successfully!');
    }

    // Show all orders for management
    public function manageOrders()
    {
        // Only show orders with status 'pending'
        $orders = Order::with('user')->whereRaw('LOWER(status) = ?', ['pending'])->orderByDesc('created_at')->get();
        return view('employee.manage_order', compact('orders'));
    }

    // Accept a pending order
    public function acceptOrder($id)
    {
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
        $product = Product::findOrFail($id);
        if ($product->status === 'pending') {
            $product->status = 'denied';
            $product->save();
            return redirect()->route('employee.manage_seller')->with('success', 'Product denied!');
        }
        return redirect()->route('employee.manage_seller')->with('error', 'Product cannot be denied.');
    }
}
