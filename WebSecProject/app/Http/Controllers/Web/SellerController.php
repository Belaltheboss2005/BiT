<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function manage(Request $request)
    {
        // Check if user has permission to view products
        if (!Auth::user()->hasPermissionTo('show-products')) {
            abort(403, 'Unauthorized');
        }

        $sellerId = Auth::id();
        $products = Product::where('seller_id', $sellerId)->get();

        // Handle POST requests (Add/Edit)
        if ($request->isMethod('post')) {
            // Validate the request
            $validated = $request->validate([
                'id' => 'nullable|exists:products,id,seller_id,' . $sellerId,
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
            ], [
                'name.required' => 'Product name is required.',
                'price.required' => 'Product price is required.',
                'price.min' => 'Price cannot be negative.',
                'id.exists' => 'The selected product does not exist or you do not have permission to edit it.',
            ]);

            try {
                if ($request->filled('id')) {
                    // Check edit permission
                    if (!Auth::user()->hasPermissionTo('edit-products')) {
                        abort(403, 'Unauthorized');
                    }
                    $product = Product::where('id', $request->id)
                                     ->where('seller_id', $sellerId)
                                     ->firstOrFail();
                    $product->update([
                        'name' => $validated['name'],
                        'price' => $validated['price'],
                        'description' => $validated['description'],
                    ]);
                    return redirect()->route('seller.manage')->with('success', 'Product updated successfully!');
                } else {
                    // Check add permission
                    if (!Auth::user()->hasPermissionTo('add-products')) {
                        abort(403, 'Unauthorized');
                    }
                    Product::create([
                        'seller_id' => $sellerId,
                        'name' => $validated['name'],
                        'price' => $validated['price'],
                        'description' => $validated['description'],
                    ]);
                    return redirect()->route('seller.manage')->with('success', 'Product added successfully!');
                }
            } catch (\Exception $e) {
                return redirect()->route('seller.manage')->with('error', 'An error occurred while saving the product.');
            }
        }

        // Handle DELETE requests
        if ($request->isMethod('delete')) {
            // Check delete permission
            if (!Auth::user()->hasPermissionTo('delete-products')) {
                abort(403, 'Unauthorized');
            }
            try {
                $product = Product::where('id', $request->id)
                                 ->where('seller_id', $sellerId)
                                 ->firstOrFail();
                $product->delete();
                return redirect()->route('seller.manage')->with('success', 'Product deleted successfully!');
            } catch (\Exception $e) {
                return redirect()->route('seller.manage')->with('error', 'An error occurred while deleting the product.');
            }
        }

        return view('seller.manage', compact('products')); // غيّرنا هنا
    }
}