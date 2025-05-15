@extends('layouts.master')

@section('title', 'Product List')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body bg-light">
                    <h1 class="display-6 mb-4 text-center" style="font-weight: bold; color: #ff5722;">BiT Products</h1>
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    @if($product->image)
                                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="Product Image" style="object-fit:cover; height:220px;">
                                    @else
                                        <img src="https://via.placeholder.com/300x220?text=No+Image" class="card-img-top" alt="No Image" style="object-fit:cover; height:220px;">
                                    @endif
                                    <div class="card-body d-flex flex-column bg-white">
                                        <h5 class="card-title" style="color:#007bff; font-weight:bold;">{{ $product->name }}</h5>
                                        <p class="card-text mb-1"><strong>Price:</strong> ${{ $product->price }}</p>
                                        <p class="card-text mb-1"><strong>Stock:</strong> {{ $product->stock }}</p>
                                        <p class="card-text mb-1"><strong>Model:</strong> {{ $product->model }}</p>
                                        <p class="card-text mb-1"><strong>Seller:</strong> {{ $product->seller }}</p>
                                        <p class="card-text small text-muted">{{ Str::limit($product->description, 80) }}</p>
                                        <div class="mt-auto">
                                            <a href="#" class="btn btn-primary w-100">Add To Cart</a>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted small bg-light">
                                        Added: {{ $product->created_at->format('Y-m-d') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
