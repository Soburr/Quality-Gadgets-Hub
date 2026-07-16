@extends('admin.layout')

@section('title', 'New Product — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Product</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @include('admin.products._form')

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
@endsection