@extends('layouts.master')
@section('title', 'Manage Orders')

@section('content')
<div class="container mt-5">
    <h1>Order Management</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Pending Orders</h4>
        </div>
        <div class="card-body">
            @if(count($orders) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Placed At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>EGP {{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($order->status === 'pending')
                                            <form method="POST" action="{{ route('employee.orders.accept', $order->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('employee.orders.cancel', $order->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                            </form>
                                        @else
                                            <span class="text-muted">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No orders to manage.</div>
            @endif
        </div>
    </div>
</div>
@endsection
