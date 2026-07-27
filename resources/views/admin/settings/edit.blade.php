@extends('admin.layout')

@section('title', 'Settings — Admin')

@section('content')
    <div class="admin-header">
        <h1>Settings</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="auth-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="admin-field-row" style="max-width:500px;">
            <div class="admin-field">
                <label for="delivery_fee_door">Door delivery fee (&#8358;)</label>
                <input type="number" id="delivery_fee_door" name="delivery_fee_door" value="{{ old('delivery_fee_door', $doorFee) }}" required min="0">
            </div>
            <div class="admin-field">
                <label for="delivery_fee_pickup">Pickup station fee (&#8358;)</label>
                <input type="number" id="delivery_fee_pickup" name="delivery_fee_pickup" value="{{ old('delivery_fee_pickup', $pickupFee) }}" required min="0">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Settings</button>
    </form>
@endsection