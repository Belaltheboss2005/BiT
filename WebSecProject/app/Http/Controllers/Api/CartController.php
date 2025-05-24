<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = auth()->user();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $existingItem = CartItem::where('cart_id', $cart->id)
                                ->where('product_id', $request->product_id)
                                ->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully'
        ], 200);
    }

    public function viewCart()
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();

        $cart = Cart::where('user_id', $user->id)->with('cartItems.product')->first();

        return response()->json([
            'status' => 'success',
            'data' => $cart
        ], 200);
    }

    public function updateItem(Request $request, $product_id)
{
    if (!auth()->check()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 401);
    }

    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $user = auth()->user();

    $cart = Cart::where('user_id', $user->id)->first();

    if (!$cart) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cart not found'
        ], 404);
    }

    $item = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $product_id)
                    ->first();

    if (!$item) {
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found in cart'
        ], 404);
    }

    $item->quantity = $request->quantity;
    $item->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Product quantity updated successfully',
        'data' => $item
    ], 200);
}


    public function removeItem($product_id)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ], 404);
        }

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product_id)
                        ->first();

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in cart'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from cart successfully'
        ], 200);
    }
}
