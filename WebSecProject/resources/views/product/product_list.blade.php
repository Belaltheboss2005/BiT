@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Product List</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="Product Image" style="object-fit:cover; height:220px;">
                    @else
                        <img src="https://via.placeholder.com/300x220?text=No+Image" class="card-img-top" alt="No Image" style="object-fit:cover; height:220px;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text mb-1"><strong>Price:</strong> ${{ $product->price }}</p>
                        <p class="card-text mb-1"><strong>Stock:</strong> {{ $product->stock }}</p>
                        <p class="card-text mb-1"><strong>Model:</strong> {{ $product->model }}</p>
                        <p class="card-text mb-1"><strong>Seller:</strong> {{ $product->seller }}</p>
                        <p class="card-text small text-muted">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                    <div class="card-footer text-muted small">
                        Added: {{ $product->created_at->format('Y-m-d') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
