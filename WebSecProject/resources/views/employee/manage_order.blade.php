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

    <div class="card shadow mt-4">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Return Requests</h4>
        </div>
        <div class="card-body">
            @if(isset($returnRequests) && count($returnRequests) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Reason/Description</th>
                                <th>Requested At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($returnRequests as $req)
                                <tr>
                                    <td>{{ $req['order']->id }}</td>
                                    <td>{{ $req['order']->user->name ?? 'N/A' }}</td>
                                    <td>{{ $req['item']->product_name }}</td>
                                    <td>{{ $req['item']->quantity }}</td>
                                    <td>{{ $req['item']->description ?? '-' }}</td>
                                    <td>{{ $req['item']->updated_at ? $req['item']->updated_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('order.approveReturn', $req['item']->id) }}" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('order.denyReturn', $req['item']->id) }}" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No return requests to manage.</div>
            @endif
        </div>
    </div>
</div>
@endsection
