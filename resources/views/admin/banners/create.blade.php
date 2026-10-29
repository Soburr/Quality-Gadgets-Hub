@extends('admin.layout')

@section('title', 'New Banner — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Banner</h1>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @include('admin.banners._form', ['banner' => null])
        <button type="submit" class="btn btn-primary">Create Banner</button>
    </form>
@endsection