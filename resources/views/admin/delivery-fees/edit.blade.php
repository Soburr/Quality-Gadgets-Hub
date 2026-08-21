@extends('admin.layout')

@section('title', 'Delivery Fees — Admin')

@section('content')
    <div class="admin-header">
        <h1>Delivery Fees</h1>
    </div>

    <p class="admin-hint" style="margin-bottom:20px;">
        Set what customers pay for delivery to each state. Lagos shows as "Door Delivery" at checkout — every other state shows as "Park Pickup" automatically, using the price you set here.
    </p>

    <form action="{{ route('admin.delivery-fees.update') }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')

        <div class="admin-panel" style="margin-bottom:20px;max-width:400px;">
            <h3>Store Pickup</h3>
            <div class="admin-field">
                <label for="store_pickup_fee">Fee for collecting from your physical store (&#8358;)</label>
                <input type="number" id="store_pickup_fee" name="store_pickup_fee" value="{{ old('store_pickup_fee', $storePickupFee) }}" required min="0">
            </div>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>State</th>
                        <th>Fee (&#8358;)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryFees as $fee)
                        <tr>
                            <td>
                                {{ $fee->state }}
                                @if($fee->state === 'Lagos')
                                    <span class="admin-badge admin-badge--delivered" style="margin-left:8px;">Door Delivery</span>
                                @endif
                            </td>
                            <td>
                                <input type="number" name="fees[{{ $fee->id }}]" value="{{ old('fees.'.$fee->id, $fee->fee) }}" min="0" required style="max-width:160px;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Delivery Fees</button>
    </form>
@endsection