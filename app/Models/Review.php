<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['product_id', 'reviewer_name', 'rating', 'title', 'comment', 'is_verified'];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}