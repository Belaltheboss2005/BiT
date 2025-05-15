@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center bg-light">
                        <h1 class="display-4 mb-3" style="font-weight: bold; color: #007bff;">Welcome to <span style="color: #ff5722;">BiT</span>!</h1>
                        <p class="lead mb-4">Discover, shop, and enjoy our electronics <span style="color: #ff5722; font-weight: bold;">BiT by BiT</span>.</p>
                        <a href="{{ route('products_list') }}" class="btn btn-lg btn-primary px-5 mb-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
