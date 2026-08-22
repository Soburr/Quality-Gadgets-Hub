@extends('admin.layout')

@section('title', 'Pickup Locations — Admin')

@section('content')
    <div class="admin-header">
        <h1>Delivery Areas (Lagos)</h1>
        <a href="{{ route('admin.pickup-locations.create') }}" class="btn btn-primary">+ New Area</a>
    </div>

    <p class="admin-hint" style="margin-bottom:20px;">
        These prices apply to Door Delivery when the customer's state is Lagos — they pick their area at checkout and pay the fee attached to it. Store Pickup itself is always free.
    </p>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Fee</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $location)
                    <tr>
                        <td>{{ $location->name }}</td>
                        <td class="mono">&#8358;{{ number_format($location->fee) }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.pickup-locations.edit', $location) }}">Edit</a>
                            <form action="{{ route('admin.pickup-locations.destroy', $location) }}" method="POST" onsubmit="return confirm('Delete this pickup location?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="admin-empty">No pickup locations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection