<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSubscriber extends Model
{
    protected $fillable = ['email', 'name', 'unsubscribed_at'];

    protected $casts = ['unsubscribed_at' => 'datetime'];

    public function scopeActive($query)
    {
        return $query->whereNull('unsubscribed_at');
    }
}