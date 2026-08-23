@extends('admin.layout')

@section('title', 'Delivery Fees — Admin')

@section('content')
    <div class="admin-header">
        <h1>Delivery Fees</h1>
    </div>

    <p class="admin-hint" style="margin-bottom:20px;">
        Set what customers pay for delivery to each state. Lagos shows as "Doorstep Delivery" at checkout — every other state shows as "Park Pickup" automatically, using the price you set here.
    </p>

    <form action="{{ route('admin.delivery-fees.update') }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')

        <div class="admin-panel" style="margin-bottom:20px;max-width:500px;">
            <h3>Store Pickup</h3>
            <p class="admin-hint" style="margin:0;">
                Store Pickup is always free. Doorstep Delivery within Lagos is priced per area instead of a flat state fee — manage those prices at
                <a href="{{ route('admin.pickup-locations.index') }}">Delivery Areas (Lagos)</a>.
            </p>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>State</th>
                        <th>Park Pickup fee (&#8358;)</th>
                        <th>Courier surcharge (&#8358;)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryFees as $fee)
                        <tr>
                            <td>
                                {{ $fee->state }}
                                @if($fee->state === 'Lagos')
                                    <span class="admin-badge admin-badge--delivered" style="margin-left:8px;">Doorstep Delivery (priced by area)</span>
                                @endif
                            </td>
                            <td>
                                <input type="number" name="fees[{{ $fee->id }}]" value="{{ old('fees.'.$fee->id, $fee->fee) }}" min="0" required style="max-width:160px;" @disabled($fee->state === 'Lagos')>
                            </td>
                            <td>
                                @if($fee->state === 'Lagos')
                                    <span class="admin-hint" style="margin:0;">N/A</span>
                                @else
                                    <input type="number" name="courier_fees[{{ $fee->id }}]" value="{{ old('courier_fees.'.$fee->id, $fee->courier_fee) }}" min="0" required style="max-width:160px;">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Save Delivery Fees</button>
    </form>
@endsection