@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Categories</h2>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

    @if($categories->count())
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @else
    <p>No categories found.</p>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection
