@extends('layouts.master')

@section('title', 'Seller Products')

@section('content')
<div class="container mt-5">
    <h1>Manage Products</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form for Add/Edit -->
    <form method="POST" action="{{ route('seller.manage') }}" id="productForm">
        @csrf
        <input type="hidden" name="id" id="productId">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" id="productName" required>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" id="productPrice" required>
        </div>
        <div class="form-group">
            <label>Stock</label>
            <input type="text" name="stock" class="form-control" id="productStock" required>
        </div>
        <div class="form-group">
            <label>Code</label>
            <input type="text" name="code" class="form-control" id="productCode" required>
        </div>
        <div class="form-group">
            <label>Model</label>
            <input type="text" name="model" class="form-control" id="productModel" required>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="text" name="image" class="form-control" id="productImage" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" id="productDescription"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3" id="submitBtn">{{ isset($editing) ? 'Update Product' : 'Add Product' }}</button>
        <button type="button" class="btn btn-secondary mt-3" id="cancelBtn" style="display: none;">Cancel</button>
    </form>

    <!-- Products Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Code</th>
                <th>Model</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="Image" style="max-width:60px; max-height:60px;">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->model }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn"
                                data-id="{{ $product->id }}"
                                data-image="{{ $product->image }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}"
                                data-code="{{ $product->code }}"
                                data-model="{{ $product->model }}"
                                data-description="{{ $product->description ?? '' }}">Edit</button>
                        <form action="{{ route('seller.manage') }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');
        const productId = document.getElementById('productId');
        const productName = document.getElementById('productName');
        const productPrice = document.getElementById('productPrice');
        const productDescription = document.getElementById('productDescription');
        const submitBtn = document.getElementById('submitBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                productId.value = this.getAttribute('data-id');
                productName.value = this.getAttribute('data-name');
                productPrice.value = this.getAttribute('data-price');
                productStock.value = this.getAttribute('data-stock');
                productCode.value = this.getAttribute('data-code');
                productModel.value = this.getAttribute('data-model');
                productImage.value = this.getAttribute('data-image');
                productDescription.value = this.getAttribute('data-description');
                submitBtn.textContent = 'Update Product';
                cancelBtn.style.display = 'inline';
                form.scrollIntoView();
            });
        });

        cancelBtn.addEventListener('click', function () {
            productId.value = '';
            productName.value = '';
            productPrice.value = '';
            productDescription.value = '';
            submitBtn.textContent = 'Add Product';
            cancelBtn.style.display = 'none';
        });
    });
</script>
@endsection
