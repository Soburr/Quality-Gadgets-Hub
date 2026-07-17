@extends('admin.layout')

@section('title', 'Reviews — Admin')

@section('content')
    <div class="admin-header">
        <h1>Reviews</h1>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Reviewer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>
                            @if($review->product)
                                <a href="{{ route('product.show', $review->product) }}" target="_blank">{{ $review->product->name }}</a>
                            @else
                                <span class="admin-empty">Deleted product</span>
                            @endif
                        </td>
                        <td>{{ $review->reviewer_name }}</td>
                        <td>{{ $review->rating }} &#9733;</td>
                        <td class="admin-table-comment">{{ $review->comment }}</td>
                        <td>{{ $review->created_at->format('d M Y') }}</td>
                        <td class="admin-table-actions">
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="admin-empty">No reviews yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div class="pager">
            @if($reviews->previousPageUrl())
                <a href="{{ $reviews->previousPageUrl() }}" class="pager-btn">&larr; Prev</a>
            @endif
            <span class="pager-info">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
            @if($reviews->nextPageUrl())
                <a href="{{ $reviews->nextPageUrl() }}" class="pager-btn">Next &rarr;</a>
            @endif
        </div>
    @endif
@endsection