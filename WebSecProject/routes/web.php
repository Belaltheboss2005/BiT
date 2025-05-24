<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Web\ProductsController; // Consistent capitalization
// use App\Http\Controllers\Web\UsersController;
// use App\Http\Controllers\Web\SellerController;


// Route::get('/', function () {
//     return view('welcome');
// });



// Route::get('register', [UsersController::class, 'register'])->name('register');
// Route::post('do_Register', [UsersController::class, 'doRegister'])->name('do_register');
// Route::get('login', [UsersController::class, 'login'])->name('login');
// Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
// Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

// Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');

// Route::middleware(['auth'])->group(function () {
//     // Users routes
//     Route::get('/users', [UsersController::class, 'manageUsers'])->name('users.manage');
//     Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
//     Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
//     Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

//     // Products routes
//     Route::get('/products', [ProductsController::class, 'index'])->name('products_list');
//     Route::post('/products/add-to-cart', [ProductsController::class, 'addToCart'])->middleware('auth')->name('products.addToCart');
//     Route::get('/cart', [ProductsController::class, 'viewCart'])->name('cart.view');
//     Route::delete('/cart/remove/{id}', [ProductsController::class, 'removeFromCart'])->name('cart.remove');
//     Route::post('/cart/update-quantity/{id}', [ProductsController::class, 'updateCartQuantity'])->name('cart.updateQuantity');
//     Route::get('/checkout', [ProductsController::class, 'viewCheckout'])->name('checkout.view');
//     Route::post('/checkout', [ProductsController::class, 'placeOrder'])->name('checkout.placeOrder');
//     Route::get('/orders', [ProductsController::class, 'viewOrders'])->name('orders.view');


// });



// Route::group(['middleware' => 'auth'], function () {
//     Route::get('seller/manage', [SellerController::class, 'manage'])->name('seller.manage');
//     Route::post('seller/manage', [SellerController::class, 'store'])->name('seller.manage');
//     Route::put('seller/manage', [SellerController::class, 'update'])->name('seller.manage');
//     Route::delete('seller/manage', [SellerController::class, 'destroy'])->name('seller.manage');
//     Route::get('products', [ProductsController::class, 'index'])->name('products.index');
// });

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\SellerController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\SpatieController;

Route::get('/', [UsersController::class, 'welcomePage'])->name('welcome');

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('do_Register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('web/login', [UsersController::class, 'doLogin'])->name('do_login');Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
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

    // Seller routes
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::match(['get', 'post', 'put', 'delete'], '/seller/manage', [SellerController::class, 'manage'])->name('seller.manage');


    // Employee management routes (NO role middleware)
    Route::get('/employee/manage-seller', [EmployeeController::class, 'manageSellers'])->name('employee.manage_seller');
    Route::post('/employee/seller/{id}/activate', [EmployeeController::class, 'activateSeller'])->name('employee.sellers.activate');
    Route::post('/employee/seller/{id}/deactivate', [EmployeeController::class, 'deactivateSeller'])->name('employee.sellers.deactivate');

    Route::get('/employee/manage-orders', [EmployeeController::class, 'manageOrders'])->name('employee.manage_orders');
    Route::post('/employee/orders/{id}/accept', [EmployeeController::class, 'acceptOrder'])->name('employee.orders.accept');
    Route::post('/employee/orders/{id}/cancel', [EmployeeController::class, 'cancelOrder'])->name('employee.orders.cancel');

    // Product approval routes
    Route::post('/employee/products/{id}/approve', [EmployeeController::class, 'approveProduct'])->name('employee.products.approve');
    Route::post('/employee/products/{id}/deny', [EmployeeController::class, 'denyProduct'])->name('employee.products.deny');

    // Manager routes
    Route::get('/manager/dashboard', [UsersController::class, 'dashboard'])->name('manager.dashboard');

    // Admin routes

    Route::get('/admin/roles-permissions', [SpatieController::class, 'manage'])->name('spatie.manage');
    Route::post('/admin/roles/add', [SpatieController::class, 'addRole'])->name('spatie.addrole');
    Route::post('/admin/roles/edit', [SpatieController::class, 'editRole'])->name('spatie.editrole');
    Route::post('/admin/permissions/add', [SpatieController::class, 'addPermission'])->name('spatie.addpermission');
    Route::post('/admin/permissions/edit', [SpatieController::class, 'editPermission'])->name('spatie.editpermission');
    Route::post('/admin/assign-permission', [SpatieController::class, 'assignPermission'])->name('spatie.assignpermission');
    Route::post('/admin/assign-role', [SpatieController::class, 'assignRole'])->name('spatie.assignrole');
    Route::post('/admin/roles/delete', [SpatieController::class, 'deleteRole'])->name('spatie.deleterole');
    Route::post('/admin/permissions/delete', [SpatieController::class, 'deletePermission'])->name('spatie.deletepermission');

});
