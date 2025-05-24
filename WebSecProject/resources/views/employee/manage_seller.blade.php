@extends('layouts.master')
@section('title', 'Manage Sellers')

@section('content')
<div class="container mt-5">
    <h1>Seller Management</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Sellers</h4>
        </div>
        <div class="card-body">
            @if(isset($sellers) && count($sellers) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Products</th>
                                <th>Registered At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->id }}</td>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->products->count() }}</td>
                                    <td>{{ $seller->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($seller->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($seller->is_active)
                                            <form method="POST" action="{{ route('employee.sellers.deactivate', $seller->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Deactivate</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('employee.sellers.activate', $seller->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No sellers to manage.</div>
            @endif
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Pending Products</h4>
        </div>
        <div class="card-body">
            @if(isset($pendingProducts) && count($pendingProducts) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Seller</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Model</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->seller->name ?? 'N/A' }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('employee.products.approve', $product->id) }}" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('employee.products.deny', $product->id) }}" style="display:inline-block;">
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
                <div class="alert alert-info text-center">No pending products to approve.</div>
            @endif
        </div>
    </div>
</div>
@endsection
