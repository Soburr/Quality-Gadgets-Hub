@extends('layouts.app')

@section('title', $category->label . ' — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                @foreach($ancestors as $ancestor)
                    <span class="sep">/</span>
                    <a href="{{ route('category.show', $ancestor) }}">{{ $ancestor->label }}</a>
                @endforeach
                <span class="sep">/</span>
                <span class="current">{{ $category->label }}</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head section-head--banner">
                <div>
                    <h2>{{ $category->label }}</h2>
                    <div class="sub">
                        @if($subcategories->isNotEmpty())
                            Browse {{ $subcategories->count() }} {{ \Illuminate\Support\Str::plural('subcategory', $subcategories->count()) }} or see everything below
                        @else
                            Everything we have in {{ $category->label }} right now
                        @endif
                    </div>
                </div>
                <span class="count-badge">{{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}</span>
            </div>

            @if($subcategories->isNotEmpty())
                <div class="subcat-chips">
                    @foreach($subcategories as $sub)
                        <a href="{{ route('category.show', $sub) }}" class="subcat-chip">{{ $sub->label }}</a>
                    @endforeach
                </div>
            @endif

            @if($products->isEmpty())
                <div class="empty-state">
                    <p>No products in {{ $category->label }} yet — check back soon.</p>
                </div>
            @else
                <div class="grid">
                    @foreach($products as $i => $product)
                        <x-product-card :product="$product" :seed="$i" />
                    @endforeach
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
            @endif
        </div>
    </section>

@endsection