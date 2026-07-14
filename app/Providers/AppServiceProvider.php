<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    View::composer('layouts.app', function ($view) {
        $view->with(
            'navCategories',
            Category::topLevel()->with('children.children')->orderBy('sort_order')->get()
        );
        $view->with('cartCount', app(CartService::class)->count());
    });
}
}
