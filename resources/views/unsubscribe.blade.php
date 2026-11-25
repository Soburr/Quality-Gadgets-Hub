@extends('layouts.app')

@section('title', 'Unsubscribe — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="auth-card" style="text-align:center;">
            @if($done)
                <h1 class="auth-title">You've been unsubscribed</h1>
                <p class="auth-sub">{{ $subscriber->email }} won't get marketing emails from us anymore. Updates about orders you place will still reach you.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Back to the shop</a>
            @else
                <h1 class="auth-title">Unsubscribe?</h1>
                <p class="auth-sub">Stop sending marketing emails to <strong>{{ $subscriber->email }}</strong>?</p>
                <form method="POST" action="{{ request()->fullUrl() }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Yes, unsubscribe me</button>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection