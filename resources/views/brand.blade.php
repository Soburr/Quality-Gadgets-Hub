@extends('layouts.app')

@section('title', $brand->name . ' — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">{{ $brand->name }}</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head section-head--banner">
                <div>
                    <h2>{{ $brand->name }}</h2>
                    <div class="sub">Everything we have from {{ $brand->name }}</div>
                </div>
                <span class="count-badge">{{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}</span>
            </div>

            @if($products->isEmpty())
                <div class="empty-state">
                    <p>No products from {{ $brand->name }} yet — check back soon.</p>
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