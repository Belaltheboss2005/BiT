<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->name('products_list');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('do_Register', [UserController::class, 'doRegister'])->name('do_register');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UserController::class, 'doLogout'])->name('do_logout');

Route::get('profile/{user?}', [UserController::class, 'profile'])->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'manageUsers'])->name('users.manage');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // ... (other routes)
});