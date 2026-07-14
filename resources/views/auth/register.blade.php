@extends('layouts.app')

@section('title', 'Create Account — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="auth-card">
            <h1 class="auth-title">Create your account</h1>
            <p class="auth-sub">Faster checkout, order tracking, and saved details.</p>

            @if($errors->any())
                <div class="auth-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf
                <div class="auth-field">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="auth-field">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary auth-submit">Create Account</button>
            </form>

            <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</section>
@endsection