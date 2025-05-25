<?php
namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $products = Product::all();
        return view('product.product_list', compact('products'));
    }

    public function addToCart(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->save();
        }
        $productId = $request->input('product_id');

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            return back()->with('info', 'Product is already in your cart.');
        } else {
            $newCartItem = new CartItem();
            $newCartItem->cart_id = $cart->id;
            $newCartItem->product_id = $productId;
            $newCartItem->quantity = 1;
            $newCartItem->save();
            return back()->with('success', 'Product added to cart!');
        }
    }

    public function viewCart()
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get() : collect();
        return view('product.cart', compact('cartItems'));
    }

    public function removeFromCart($id)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItem = $cart ? CartItem::where('id', $id)->where('cart_id', $cart->id)->first() : null;
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
        }
        return redirect()->route('cart.view')->with('info', 'Item not found in your cart.');
    }

    public function updateCartQuantity(Request $request, $id)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItem = $cart ? CartItem::where('id', $id)->where('cart_id', $cart->id)->first() : null;
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

    public function viewCheckout()
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get() : collect();
        // Calculate subtotal and totalQty
        $subtotal = 0;
        $totalQty = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
            $totalQty += $item->quantity;
        }
        return view('product.checkout', compact('cartItems', 'subtotal', 'totalQty'));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with('product')->where('cart_id', $cart->id)->get() : collect();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('info', 'Your cart is empty.');
        }

        $order = new Order();
        $order->user_id = $userId;
        $order->cart_id = $cart->id;
        $order->city = $request->city ?? null;
        $order->shipping_address = $request->shipping_address;
        $order->payment_method = $request->payment_method ?? null;
        $order->total_amount = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        $order->status = 'pending';
        $order->save();

        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->product_id;
            $orderItem->product_name = $item->product->name;
            $orderItem->product_image = $item->product->image;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->product->price;
            $orderItem->save();

            // Decrease product stock
            $product = $item->product;
            if ($product && $product->stock >= $item->quantity) {
                $product->stock -= $item->quantity;
                $product->save();
            }
        }

        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('products_list')->with('success', 'Order placed successfully!');
    }

    public function viewOrders()
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        foreach ($orders as $order) {
            $order->ordered_items = OrderItem::with('product')->where('order_id', $order->id)->get();
        }
        return view('product.order', compact('orders'));
    }

    public function requestReturn($orderItemId)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $orderItem = OrderItem::findOrFail($orderItemId);
        $order = $orderItem->order;
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }
        if (!in_array($order->status, ['accepted', 'approved'])) {
            return back()->with('error', 'Return not allowed for this order status.');
        }
        if ($orderItem->status === 'pending return request') {
            return back()->with('info', 'Return already requested.');
        }
        $orderItem->status = 'pending return request';
        $orderItem->save();
        return back()->with('success', 'Return request submitted.');
    }

    public function cancelOrder($orderId)
    {
        if (!Auth::user() && !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $order = Order::findOrFail($orderId);
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order cannot be cancelled.');
        }
        $order->status = 'cancelled';
        $order->save();
        return back()->with('success', 'Order cancelled successfully.');
    }

    public function approveReturnRequest($orderItemId)
    {


        $orderItem = OrderItem::findOrFail($orderItemId);
        $order = $orderItem->order;
        // Only employees can approve/deny
        if (!auth()->user() && !auth()->user()->hasPermissionTo('edit_return_requests')) {
            abort(403, 'Unauthorized');
        }
        if ($orderItem->status !== 'pending return request') {
            return back()->with('error', 'No pending return request for this item.');
        }
        $orderItem->status = 'returned';
        $orderItem->save();
        // Optionally, update order status if all items are returned
        $allReturned = $order->ordered_items->every(function($item) {
            return $item->status === 'returned';
        });
        if ($allReturned) {
            $order->status = 'refunded';
            $order->save();
        }
        return back()->with('success', 'Return request approved.');
    }

    public function denyReturnRequest($orderItemId)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);
        // Only employees can approve/deny
        if (!auth()->user() && !auth()->user()->hasPermissionTo('edit_return_requests')) {
            abort(403, 'Unauthorized');
        }
        if ($orderItem->status !== 'pending return request') {
            return back()->with('error', 'No pending return request for this item.');
        }
        $orderItem->status = 'return denied';
        $orderItem->save();
        return back()->with('success', 'Return request denied.');
    }
}
