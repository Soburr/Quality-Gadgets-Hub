@extends('admin.layout')

@section('title', 'New Category — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Category</h1>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @include('admin.categories._form', ['category' => null, 'selectedParentId' => old('parent_id', request('parent_id'))])
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
@endsection