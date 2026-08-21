@extends('admin.layout')

@section('title', 'New Pickup Location — Admin')

@section('content')
    <div class="admin-header">
        <h1>New Pickup Location</h1>
    </div>

    <form action="{{ route('admin.pickup-locations.store') }}" method="POST" class="admin-form">
        @csrf
        @include('admin.pickup-locations._form', ['location' => null])
        <button type="submit" class="btn btn-primary">Create Location</button>
    </form>
@endsection