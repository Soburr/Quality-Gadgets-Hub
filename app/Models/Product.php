<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'was_price', 'rating', 'reviews_count',
        'badge', 'image', 'colors', 'gallery', 'stock',
    ];

    protected $casts = [
        'colors' => 'array',
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeOnDeal($query)
    {
        return $query->whereNotNull('was_price');
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('badge', 'New');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratingBreakdown(): array
    {
        $counts = $this->reviews()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        $total = $counts->sum();
        $breakdown = [];

        for ($star = 5; $star >= 1; $star--) {
            $count = $counts[$star] ?? 0;
            $breakdown[$star] = [
                'count' => $count,
                'percent' => $total > 0 ? round($count / $total * 100) : 0,
            ];
        }

        return $breakdown;
    }

    public function recalculateRating(): void
    {
        $this->reviews_count = $this->reviews()->count();
        $this->rating = $this->reviews_count > 0 ? round($this->reviews()->avg('rating'), 1) : 0;
        $this->save();
    }
}