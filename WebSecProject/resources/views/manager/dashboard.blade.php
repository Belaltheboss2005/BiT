@extends('layouts.master')
@section('title', 'Manager Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Manager Dashboard</h1>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Website Sales Summary</h4>
        </div>
        <div class="card-body">
            <h5>Total Sales: <span class="text-success" style="font-weight:bold;">{{ $totalSales }} EGP</span></h5>
            <h5>Total Orders: <span class="text-info" style="font-weight:bold;">{{ $totalOrders }}</span></h5>
            <h5>Total Products Sold: <span class="text-warning" style="font-weight:bold;">{{ $totalProductsSold }}</span></h5>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Recent Orders</h4>
        </div>
        <div class="card-body">
            @if(count($recentOrders) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->total_amount }} EGP</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No recent orders found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
