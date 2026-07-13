<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'was_price', 'rating', 'reviews_count',
        'badge', 'image', 'stock',
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
}