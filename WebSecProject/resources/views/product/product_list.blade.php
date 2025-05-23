@extends('layouts.master')

@section('title', 'Product List')
@section('content')
<div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center bg-light position-relative" style="padding-bottom: 80px;">
    <div class="w-100" style="max-width: 1200px;">
        <h1 class="display-4 text-center my-5" style="font-weight: bold; letter-spacing: 2px;">
            <span style="color: #ff5722;">BiT</span> <span style="color: #007bff;">Products</span>
        </h1>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-auto" style="max-width: 500px;" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show mx-auto" style="max-width: 500px;" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row g-4 justify-content-center">
            @forelse($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card shadow border-0 flex-fill h-100">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="Product Image" style="object-fit:cover; height:200px; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        @endif
                        <div class="card-body d-flex flex-column bg-white">
                            <h5 class="card-title text-primary fw-bold mb-2">{{ $product->name }}</h5>
                            <div class="mb-2 small text-muted">Model: {{ $product->model }}</div>
                            <div class="mb-2"><span class="fw-semibold">Price:</span> ${{ $product->price }}</div>
                            <div class="mb-2"><span class="fw-semibold">Stock:</span> {{ $product->stock }}</div>
                            <div class="mb-2"><span class="fw-semibold">Seller:</span> {{ $product->seller }}</div>
                            <p class="card-text small text-muted mb-2">{{ Str::limit($product->description, 60) }}</p>
                            <div class="mt-auto">
                                @can('products_for_customers')
                                    <form method="POST" action="{{ route('products.addToCart') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn w-100" style="background-color: #444; color: #fff;">Add To Cart</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-footer text-muted small bg-light text-end">
                            <span class="me-2">Added:</span>{{ $product->created_at->format('Y-m-d') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">No products available.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
