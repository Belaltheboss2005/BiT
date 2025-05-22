@extends('layouts.master')

@section('title', 'Your Cart')
@section('content')
<div class="container py-5">
    <h1 class="mb-4" style="font-weight: bold; color: #ff5722;">Your Cart</h1>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(isset($cartItems) && count($cartItems) > 0)
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="mb-4" style="font-weight: bold; color: #222;">Shopping Cart</h2>
            <a href="#" class="text-primary small mb-3 d-inline-block">Deselect all items</a>
            <hr>
            @php $subtotal = 0; $totalQty = 0; @endphp
            @foreach($cartItems as $item)
                @php
                    $subtotal += $item->product->price * $item->quantity;
                    $totalQty += $item->quantity;
                @endphp
                <div class="row align-items-center mb-4 pb-4 border-bottom">
                    <div class="col-2 text-center">
                        <input type="checkbox" checked>
                        <img src="{{ $item->product->image ? asset('images/' . $item->product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" alt="Product Image" class="img-fluid rounded" style="max-width: 120px;">
                    </div>
                    <div class="col-7">
                        <div class="fw-bold fs-5 mb-1">{{ $item->product->name }}</div>
                        <div class="text-primary">{{ $item->product->stock }} left in stock</div>
                        <div class="mb-1 small">sold by: <span class="text-primary">{{ $item->product->seller }}</span></div>
                        <div class="mb-1 small"><b>Color:</b> {{ $item->product->model }}</div>
                        <div class="mb-1 small text-success">15 days Returnable</div>
                        <div class="d-flex align-items-center mt-2">
                            <form method="POST" action="{{ route('cart.updateQuantity', $item->id) }}" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="hidden" name="action" value="decrement">
                                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-circle px-2">-</button>
                            </form>
                            <span class="border rounded px-3 py-1 bg-light mx-1" style="font-size:1.1rem;">{{ $item->quantity ?? 1 }}</span>
                            <form method="POST" action="{{ route('cart.updateQuantity', $item->id) }}" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="hidden" name="action" value="increment">
                                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-circle px-2">+</button>
                            </form>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="ms-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <div class="fw-bold fs-5">EGP{{ number_format($item->product->price, 2) }}</div>
                    </div>
                </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-end align-items-center">
                <div class="fs-5">Subtotal ({{ $totalQty }} item{{ $totalQty > 1 ? 's' : '' }}): <span class="fw-bold">EGP {{ number_format($subtotal, 2) }}</span></div>
            </div>
        </div>
        <a href="{{ route('products_list') }}" class="btn btn-secondary mt-3">Continue Shopping</a>
    @else
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="{{ route('products_list') }}" class="btn btn-primary">Browse Products</a>
    @endif
</div>
@endsection
