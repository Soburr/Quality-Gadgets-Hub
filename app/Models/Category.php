<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'label', 'slug', 'icon', 'image', 'sort_order'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function allDescendantIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->allDescendantIds());
        }

        return $ids;
    }

    public function ancestors(): array
    {
        $chain = [];
        $node = $this->parent;

        while ($node) {
            array_unshift($chain, $node);
            $node = $node->parent;
        }

        return $chain;
    }

    /**
     * Every category flattened into one list with a `depth` property, for
     * building an indented <select> in an admin "create product" form —
     * e.g. "Phone", "— iPhone", "—— New".
     */
    public static function flattenedForSelect()
    {
        $flatten = function ($categories, $depth = 0) use (&$flatten) {
            return $categories->flatMap(function ($category) use ($depth, $flatten) {
                $category->depth = $depth;
                return collect([$category])->merge($flatten($category->children, $depth + 1));
            });
        };

        return $flatten(self::topLevel()->orderBy('sort_order')->get());
    }
}