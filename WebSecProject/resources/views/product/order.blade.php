@extends('layouts.master')

@section('title', 'My Orders')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body bg-light">
                    <h2 class="mb-4" style="color:#ff5722; font-weight:bold;">My Orders</h2>
                    @if($orders->isEmpty())
                        <div class="alert alert-info">You have not placed any orders yet.</div>
                    @else
                        @foreach($orders as $order)
                            <div class="card mb-4 shadow-sm border-0" style="border-radius: 16px;">
                                <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                    <div class="small text-muted">
                                        <strong>ORDER PLACED</strong><br>
                                        {{ $order->created_at->format('d F Y') }}
                                    </div>
                                    <div class="small text-muted">
                                        <strong>TOTAL</strong><br>
                                        EGP {{ number_format($order->total_amount, 2) }}
                                    </div>
                                    <div class="small text-muted">
                                        <strong>SHIP TO</strong><br>
                                        {{ $order->shipping_address }}
                                    </div>
                                    <div class="small text-muted">
                                        <strong>ORDER ID</strong><br>
                                        {{ $order->id }}
                                    </div>
                                </div>
                                <div class="card-body pb-3 pt-4">
                                    <div class="mb-2">
                                        <span class="fw-bold fs-5" style="color:#ff9800;">{{ ucfirst($order->status) }}</span>
                                    </div>
                                    <div class="mb-3 text-muted">
                                        @if($order->status === 'pending')
                                            Your order is being processed.
                                        @elseif($order->status === 'refunded')
                                            Your refund has been issued.
                                        @elseif($order->status === 'completed')
                                            Your order has been delivered.
                                        @else
                                            Status update available soon.
                                        @endif
                                    </div>
                                    <div class="d-flex flex-row align-items-center gap-4 mb-2">
                                        @foreach($order->ordered_items as $item)
                                            <div class="d-flex flex-row align-items-center border rounded p-2 bg-white shadow-sm" style="min-width: 320px;">
                                                <div class="me-3">
                                                    @if($item->product_image)
                                                        <img src="{{ asset('images/' . $item->product_image) }}" class="card-img-top" alt="Product Image" style="object-fit:cover; height:100px; width:100px; border-radius: .5rem;">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <div class="fw-semibold" style="font-size: 1.05em;">{{ $item->product_name }}</div>
                                                    <div class="text-muted small">Price: EGP {{ number_format($item->price, 2) }}</div>

                                                    <div class="text-muted small">Quantity: x{{ $item->quantity }}</div>
                                                    @if(!empty($item->description))
                                                        <div class="small text-secondary mt-1">{{ $item->description }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
