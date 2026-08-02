@extends('layouts.app')

@section('title', 'Page Not Found — Quality Gadgets Hub')

@section('content')

    <section class="section">
        <div class="wrap">
            <div class="error-404">
                <div class="error-404-ring">
                    <svg viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="86" fill="none" stroke="#8C0027" stroke-opacity="0.14" stroke-width="26"/>
                        <path d="M100 14 A86 86 0 1 1 40 166" fill="none" stroke="#C40356" stroke-width="26" stroke-linecap="round"/>
                    </svg>
                    <span class="error-404-code">404</span>
                </div>

                <h1>This page went off the grid</h1>
                <p>The page you're looking for might have been moved, renamed, or never existed. Let's get you back to shopping.</p>

                <div class="error-404-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Homepage</a>
                    <a href="{{ route('home') }}#grid" class="btn btn-ghost">Browse Products</a>
                </div>

                <form action="{{ route('search') }}" method="GET" class="error-404-search">
                    <input type="text" name="q" placeholder="Or search for what you need...">
                    <button type="submit" aria-label="Search">
                        <x-icon name="search" :size="18" />
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection