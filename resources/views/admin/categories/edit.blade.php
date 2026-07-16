@extends('admin.layout')

@section('title', 'Edit Category — Admin')

@section('content')
    <div class="admin-header">
        <h1>Edit Category</h1>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['selectedParentId' => old('parent_id', $category->parent_id)])
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection