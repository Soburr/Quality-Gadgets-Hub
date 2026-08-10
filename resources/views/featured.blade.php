@extends('layouts.app')

@section('title', 'Great Finds — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Great Finds</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="finds">
                <div class="section-head">
                    <div>
                        <h2>&#128176; Great Finds</h2>
                        <div class="sub">Handpicked essentials, big value</div>
                    </div>
                    <span class="count-badge">{{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}</span>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="empty-state" style="margin-top:20px;">
                    <p>Nothing featured right now — check back soon.</p>
                </div>
            @else
                <div class="grid" style="margin-top:20px;">
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