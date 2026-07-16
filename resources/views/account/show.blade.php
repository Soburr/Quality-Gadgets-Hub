@extends('layouts.app')

@section('title', 'My Account — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="section-head">
            <div><h2>My Account</h2><div class="sub">Manage your details and orders</div></div>
        </div>

        <div class="account-grid">
            <div class="account-card">
                <h3>Account details</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>

            <div class="account-card">
                <h3>Quick links</h3>
                <a href="{{ route('account.orders') }}" class="account-link">My Orders</a>
                <a href="#" class="account-link">Track Order</a>
                <a href="{{ route('cart.show') }}" class="account-link">My Cart</a>
                @if($user->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="account-link">Admin Dashboard</a>
                @endif
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" style="margin-top:24px;">
            @csrf
            <button type="submit" class="btn btn-ghost">Sign Out</button>
        </form>
    </div>
</section>
@endsection