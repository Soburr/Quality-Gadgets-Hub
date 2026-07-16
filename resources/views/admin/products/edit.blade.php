@extends('admin.layout')

@section('title', 'Edit Product — Admin')

@section('content')
    <div class="admin-header">
        <h1>Edit Product</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.products._form')

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection