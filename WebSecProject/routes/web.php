<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\ProductsController;
use App\Http\Controllers\web\UsersController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('do_Register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');

Route::middleware(['auth'])->group(function () {
    // Users routes
    Route::get('/users', [UsersController::class, 'manageUsers'])->name('users.manage');
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    // Products routes
    Route::get('/products', [ProductsController::class, 'index'])->name('products_list');
    Route::post('/products/add-to-cart', [ProductsController::class, 'addToCart'])->middleware('auth')->name('products.addToCart');
    Route::get('/cart', [ProductsController::class, 'viewCart'])->name('cart.view');
    Route::delete('/cart/remove/{id}', [ProductsController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update-quantity/{id}', [ProductsController::class, 'updateCartQuantity'])->name('cart.updateQuantity');
    Route::get('/checkout', [ProductsController::class, 'viewCheckout'])->name('checkout.view');
    Route::post('/checkout', [ProductsController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/orders', [ProductsController::class, 'viewOrders'])->name('orders.view');
    //seller
    Route::get('/seller/products', [ProductsController::class, 'manage'])->name('products.seller_list');
    Route::get('/seller/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/seller/products/store', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/seller/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/seller/products/{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/seller/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
});
