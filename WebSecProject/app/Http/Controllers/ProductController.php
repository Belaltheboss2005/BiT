<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
