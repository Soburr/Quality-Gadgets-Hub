@extends('admin.layout')

@section('title', 'Products — Admin')

@section('content')
    <div class="admin-header">
        <h1>Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ New Product</a>
    </div>

    <form method="GET" class="admin-search-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="admin-table-product">
                                <img src="{{ str($product->image)->startsWith(['http://','https://']) ? $product->image : asset($product->image) }}" alt="">
                                <span>{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->category->label }}</td>
                        <td class="mono">&#8358;{{ number_format($product->price) }}</td>
                        <td>
                            <span class="admin-badge @if($product->stock < 5) admin-badge--low @endif">{{ $product->stock }}</span>
                        </td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="pager">
            @if($products->previousPageUrl())
                <a href="{{ $products->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
            @if($products->nextPageUrl())
                <a href="{{ $products->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection