@extends('layouts.master')

@section('title', 'Checkout')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0" style="color:#ff5722; font-weight:bold;">Checkout</h2>
                        <span class="fs-5">{{ $totalQty }} item{{ $totalQty > 1 ? 's' : '' }}</span>
                    </div>
                    <ul class="list-group mb-4">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $item->product->name }}</span>
                                <span>x{{ $item->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mb-4 text-end fs-5">
                        <span class="fw-bold">Total: </span>EGP {{ number_format($subtotal, 2) }}
                    </div>
                    <form method="POST" action="{{ route('checkout.placeOrder') }}">
                        @csrf
                        <h5 class="mb-3">Shipping Information</h5>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #ff5722; color: #fff; font-weight:bold;">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
