@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Product</h2>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (₹):</label>
            <input type="number" step="0.01"  name="price" id="price" class="form-control" required value="{{ old('price') }}">
            @error('price')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity:</label>
          <input type="number" name="quantity" id="quantity" class="form-control" required value="{{ old('quantity') }}">
          @error('quantity')
              <div class="text-danger small">{{ $message }}</div>
          @enderror
      </div>


        <button type="submit" class="btn btn-success">Create Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
