@extends('admin.layout')

@section('title', 'Edit Banner — Admin')

@section('content')
    <div class="admin-header">
        <h1>Edit Banner</h1>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.banners._form')
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection