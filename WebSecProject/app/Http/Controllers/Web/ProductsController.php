<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        // if (!Auth::user()->hasPermissionTo('show-products')) {
        //     abort(403, 'Unauthorized');
        // }
        $products = Product::all();
        return view('product.product_list', compact('products'));
    }

    public function buy(Request $request, Product $product)
    {
    //     if (!Auth::user()->hasPermissionTo('buy-products')) {
    //         abort(403, 'Unauthorized');
    //     }
        $user = Auth::user();
        if ($user->credit >= $product->price) {
            $user->credit -= $product->price;
            $user->save();
            return redirect()->route('products_list')->with('success', 'Purchase successful!');
        }
        return redirect()->route('products_list')->with('error', 'Insufficient credit!');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            return back()->with('info', 'Product is already in your cart.');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return back()->with('success', 'Product added to cart!');
        }
    }

    public function viewCart()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();
        return view('product.cart', compact('cartItems'));
    }

    public function removeFromCart($id)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->first();
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
        }
        return redirect()->route('cart.view')->with('info', 'Item not found in your cart.');
    }

    public function updateCartQuantity(Request $request, $id)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->first();
        if (!$cartItem) {
            return redirect()->route('cart.view')->with('info', 'Cart item not found.');
        }
        if ($request->input('action') === 'increment') {
            $cartItem->quantity += 1;
        } elseif ($request->input('action') === 'decrement' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }
        $cartItem->save();
        return redirect()->route('cart.view');
    }
}












// <!--
// namespace App\Http\Controllers;

// use App\Models\Product;
// use Illuminate\Http\Request;

// class ProductController extends Controller -->
// <!-- // { -->
 //     // Display a listing of the products
//     public function index()
//     {
//         $products = Product::all();
//         return view('product.product_list', compact('products'));
//     } -->

//     // Other CRUD methods can be added here as needed
// } -->
