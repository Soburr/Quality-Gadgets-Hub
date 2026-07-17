<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $hasPurchased = OrderItem::whereHas('order', fn ($q) => $q->where('user_id', Auth::id())->where('status', 'delivered'))
            ->where('product_id', $product->id)
            ->exists();
        abort_unless($hasPurchased, 403, 'Only customers who purchased this product can leave a review.');

        $alreadyReviewed = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->exists();

        abort_if($alreadyReviewed, 403, 'You have already reviewed this product.');

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:2000',
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'reviewer_name' => Auth::user()->name,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_verified' => true,
        ]);

        $product->recalculateRating();

        return back()->with('status', 'Thanks — your review has been posted.');
    }
}