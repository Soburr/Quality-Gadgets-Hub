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
                    <div class="auth-password-wrap">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="auth-password-toggle" data-target="password" aria-label="Show password">
                            <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a20.3 20.3 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 7 11 7a20.29 20.29 0 01-3.22 4.31M14.12 14.12a3 3 0 11-4.24-4.24" stroke-linecap="round" stroke-linejoin="round"/><path d="M1 1l22 22" stroke-linecap="round"/></svg>
                        </button>
                    </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.auth-password-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const eyeIcon = btn.querySelector('.icon-eye');
            const eyeOffIcon = btn.querySelector('.icon-eye-off');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            eyeIcon.style.display = isHidden ? 'none' : 'block';
            eyeOffIcon.style.display = isHidden ? 'block' : 'none';
            btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    });
});
</script>
@endpush
@endsection