@extends('admin.layout')

@section('title', 'New Brand — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Brand</h1>
    </div>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @include('admin.brands._form', ['brand' => null])
        <button type="submit" class="btn btn-primary">Create Brand</button>
    </form>
@endsection