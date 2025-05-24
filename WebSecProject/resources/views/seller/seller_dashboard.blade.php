@extends('layouts.master')
@section('title', 'Seller Dashboard')

@section('content')
<div class="container mt-5">
    <h1>My Products</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Products Added by You</h4>
        </div>
        <div class="card-body">
            @if (count($products) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Code</th>
                                <th>Model</th>
                                <th>Description</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->model }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-center">You have not added any products yet.</div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Sales Summary</h5>
        </div>
        <div class="card-body">
            @if(count($products) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $salesCounts[$product->id] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No sales data to show.</div>
            @endif
        </div>
    </div>
</div>
@endsection
