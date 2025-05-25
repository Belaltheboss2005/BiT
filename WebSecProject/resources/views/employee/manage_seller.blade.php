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
                                        @if($product->status !== 'on hold')
                                            <form method="POST" action="{{ route('employee.products.hold', $product->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Put On Hold</button>
                                            </form>
                                        @endif
                                        @if($product->status === 'on hold')
                                            <form method="POST" action="{{ route('employee.products.delete', $product->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No pending products found.</div>
            @endif
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Approved Products</h4>
        </div>
        <div class="card-body">
            @if(isset($approvedProducts) && count($approvedProducts) > 0)
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
                            @foreach($approvedProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->seller->name ?? 'N/A' }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($product->status !== 'on hold')
                                            <form method="POST" action="{{ route('employee.products.hold', $product->id) }}" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Put On Hold</button>
                                            </form>
                                        @endif
                                        @if($product->status === 'on hold')
                                            <form method="POST" action="{{ route('employee.products.delete', $product->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No approved products found.</div>
            @endif
        </div>
    </div>
    <div class="card shadow mt-4">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Products On Hold</h4>
        </div>
        <div class="card-body">
            @if(isset($onHoldProducts) && count($onHoldProducts) > 0)
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
                                <th>Status</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onHoldProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->seller->name ?? 'N/A' }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ ucfirst($product->status) }}</td>
                                    <td>{{ $product->updated_at ? $product->updated_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('employee.products.resume', $product->id) }}" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Resume</button>
                                        </form>
                                        <form method="POST" action="{{ route('employee.products.delete', $product->id) }}" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No products on hold.</div>
            @endif
        </div>
    </div>
</div>
@endsection
