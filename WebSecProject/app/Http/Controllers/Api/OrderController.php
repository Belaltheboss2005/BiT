<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'data' => $order
        ], 201);
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }
}