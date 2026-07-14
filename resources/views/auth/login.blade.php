@extends('layouts.app')

@section('title', 'Sign In — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="auth-card">
            <h1 class="auth-title">Welcome back</h1>
            <p class="auth-sub">Sign in to track orders and check out faster.</p>

            @if($errors->any())
                <div class="auth-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf
                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <label class="auth-checkbox">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button type="submit" class="btn btn-primary auth-submit">Sign In</button>
            </form>

            <p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
        </div>
    </div>
</section>
@endsection