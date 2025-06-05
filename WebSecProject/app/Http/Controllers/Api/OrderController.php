<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
class OrderController extends Controller
{
public function store(Request $request)
{
    $user = auth()->user();
    $cart = Cart::where('user_id', $user->id)->with('cartItems.product')->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cart is empty'
        ], 400);
    }

    $totalAmount = 0;

    foreach ($cart->cartItems as $item) {
        $totalAmount += $item->product->price * $item->quantity;
    }

    $order = Order::create([
        'user_id' => $user->id,
        'cart_id' => $cart->id,
        'city' => $request->input('city'),
        'shipping_address' => $request->input('shipping_address'),
        'payment_method' => $request->input('payment_method'),
        'total_amount' => $totalAmount,
        'status' => 'pending',
    ]);

    foreach ($cart->cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'product_name' => $item->product->name,
            'product_image' => $item->product->image,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
            'total' => $item->product->price * $item->quantity,
            'status' => 'pending',
        ]);
    }

    $cart->cartItems()->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Order placed successfully',
        'data' => $order->load('ordered_items')
    ], 201);
}



    public function index()
    {
        return response()->json(Order::all());
    }

    public function cancel($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    if ($order->status === 'cancelled') {
        return response()->json(['message' => 'Order already cancelled'], 400);
    }

    $order->status = 'cancelled';
    $order->save();

    return response()->json(['message' => 'Order cancelled successfully']);
}
}
