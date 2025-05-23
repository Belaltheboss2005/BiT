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
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
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
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
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
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
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
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
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
    public function create()
    {
        if (!Auth::user()->hasRole('Seller')) {
            abort(403, 'Unauthorized');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Seller')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'seller_id' => Auth::id(),
            'status' => 'pending', // بيبدأ كـ Pending لحد ما Employee يوافق
        ]);

        // Placeholder لإرسال طلب لـ Employee (يمكن تكمله لاحقًا)
        // مثال: إضافة سجل طلب في جدول requests
        // Request::create(['product_id' => $product->id, 'status' => 'pending']);

        return redirect()->route('products.list')->with('success', 'Product created and pending approval.');
    }

    public function edit(Product $product)
    {
        if (!Auth::user()->hasRole('Seller') || $product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if (!Auth::user()->hasRole('Seller') || $product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => 'pending', // يرجع لـ Pending بعد التعديل
        ]);

        // Placeholder لإرسال طلب تعديل لـ Employee
        // Request::where('product_id', $product->id)->update(['status' => 'pending']);

        return redirect()->route('products.list')->with('success', 'Product updated and pending approval.');
    }

    public function destroy(Product $product)
    {
        if (!Auth::user()->hasRole('Seller') || $product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $product->delete();

        // Placeholder لإشعار Employee بحذف المنتج
        // Request::where('product_id', $product->id)->delete();

        return redirect()->route('products.list')->with('success', 'Product deleted.');
    }

    public function viewCheckout()
    {
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::with('product')->where('cart_id', $cart->id)->get() : collect();
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
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
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
        $order->total_amount = $cartItems->sum(function($item) { return $item->product->price * $item->quantity; });
        $order->status = 'pending';
        $order->save();

        // Save each cart item as an order item
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->product_id;
            $orderItem->product_name = $item->product->name;
            $orderItem->product_image = $item->product->image;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->product->price;
            // $orderItem->total = $item->product->price * $item->quantity;
            $orderItem->save();
        }

        // Now clear the cart
        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('products_list')->with('success', 'Order placed successfully!');
    }

    public function viewOrders()
    {
        if (!Auth::user() || !Auth::user()->can('products_for_customers')) {
            abort(403, 'Unauthorized access');
        }
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        // For each order, get the order items from the order_items table
        foreach ($orders as $order) {
            $order->ordered_items = OrderItem::with('product')->where('order_id', $order->id)->get();
        }
        return view('product.order', compact('orders'));
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
