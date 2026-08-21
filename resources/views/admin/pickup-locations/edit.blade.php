@extends('admin.layout')

@section('title', 'Edit Pickup Location — Admin')

@section('content')
    <div class="admin-header">
        <h1>Edit Pickup Location</h1>
    </div>

    <form action="{{ route('admin.pickup-locations.update', $location) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.pickup-locations._form')
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection