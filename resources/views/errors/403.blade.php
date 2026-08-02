@extends('layouts.app')

@section('title', 'Access Denied — Quality Gadgets Hub')

@section('content')

    <section class="section">
        <div class="wrap">
            <div class="error-404">
                <div class="error-404-ring">
                    <svg viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="86" fill="none" stroke="#8C0027" stroke-opacity="0.14" stroke-width="26"/>
                        <path d="M100 14 A86 86 0 1 1 40 166" fill="none" stroke="#C40356" stroke-width="26" stroke-linecap="round"/>
                    </svg>
                    <span class="error-404-code">403</span>
                </div>

                <h1>You don't have access to this page</h1>
                <p>If you think this is a mistake, try signing in with the correct account, or head back to the homepage.</p>

                <div class="error-404-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Homepage</a>
                </div>
            </div>
        </div>
    </section>

@endsection