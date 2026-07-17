@extends('admin.layout')

@section('title', 'Edit Brand — Admin')

@section('content')
    <div class="admin-header">
        <h1>Edit Brand</h1>
    </div>

    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.brands._form')
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection