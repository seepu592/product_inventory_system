@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header Buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Products</h2>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Manage Categories</a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </div>

    {{-- Dashboard Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-4">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text fs-4">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Stock Value (₹)</h5>
                    <p class="card-text fs-4">{{ number_format($totalStockValue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="category_id" class="form-label">Filter by Category:</label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="search" class="form-label">Search Product Name:</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Product List --}}
    @if($products->count())
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Total Value (₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price * $product->quantity, 2) }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="alert alert-info">No products found.</div>
    @endif
</div>
@endsection
