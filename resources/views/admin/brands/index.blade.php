@extends('admin.layout')

@section('title', 'Brands — Admin')

@section('content')
    <div class="admin-header">
        <h1>Brands</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">+ New Brand</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Products</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                    <tr>
                        <td>
                            <div class="admin-table-product">
                                @if($brand->logo)
                                    <img src="{{ str($brand->logo)->startsWith(['http://','https://']) ? $brand->logo : asset($brand->logo) }}" alt="">
                                @endif
                                <span>{{ $brand->name }}</span>
                            </div>
                        </td>
                        <td>{{ $brand->products_count }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.brands.edit', $brand) }}">Edit</a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Delete this brand?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="admin-empty">No brands yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection