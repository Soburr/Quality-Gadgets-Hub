@extends('layouts.app')

@section('title', 'My Wishlist — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Wishlist</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>My Wishlist</h2><div class="sub">{{ $items->count() }} {{ \Illuminate\Support\Str::plural('item', $items->count()) }} saved</div></div>
            </div>

            @if($items->isEmpty())
                <div class="empty-state">
                    <p>Nothing saved yet — tap the heart on any product to add it here.</p>
                    <a href="{{ route('home') }}#grid" class="btn btn-primary" style="margin-top:16px;display:inline-flex;">Start browsing</a>
                </div>
            @else
                <div class="grid">
                    @foreach($items as $i => $item)
                        <x-product-card :product="$item->product" :seed="$i" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection