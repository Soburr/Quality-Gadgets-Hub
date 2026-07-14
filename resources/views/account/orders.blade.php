@extends('layouts.app')

@section('title', 'My Orders — Quality Gadgets Hub')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="section-head">
            <div><h2>My Orders</h2><div class="sub">Track and review your past purchases</div></div>
        </div>
        <div class="empty-state">
            <p>You haven't placed any orders yet — once checkout is built, they'll show up here.</p>
        </div>
    </div>
</section>
@endsection