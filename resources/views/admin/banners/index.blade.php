@extends('admin.layout')

@section('title', 'Banners — Admin')

@section('content')
    <div class="admin-header">
        <h1>Banners</h1>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ New Banner</a>
    </div>

    <p class="admin-hint" style="margin-bottom:20px;">
        Active banners appear at the top of the homepage. With more than one active, they rotate automatically in the order set here.
    </p>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Banner</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr>
                        <td>
                            <div class="admin-table-product">
                                <img class="admin-banner-thumb" src="{{ str($banner->image)->startsWith(['http://','https://']) ? $banner->image : asset($banner->image) }}" alt="" loading="lazy">
                                <span>{{ $banner->title ?: 'Image-only banner' }}</span>
                            </div>
                        </td>
                        <td>{{ $banner->link_url ?: '—' }}</td>
                        <td>
                            <span class="admin-badge @if($banner->is_active) admin-badge--delivered @endif">
                                {{ $banner->is_active ? 'Live' : 'Hidden' }}
                            </span>
                        </td>
                        <td>{{ $banner->sort_order }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.banners.edit', $banner) }}">Edit</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">No banners yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection