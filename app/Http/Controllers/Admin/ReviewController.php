<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $product = $review->product;

        $review->delete();

        $product?->recalculateRating();

        return back()->with('status', 'Review deleted.');
    }
}