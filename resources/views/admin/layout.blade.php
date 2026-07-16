<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Quality Gadgets Hub')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;700;800&family=Manrope:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="admin-body">

    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="Quality Gadgets Hub logo">
                <span>QGH Admin</span>
            </a>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) is-active @endif">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="@if(request()->routeIs('admin.products.*')) is-active @endif">Products</a>
                <a href="{{ route('admin.orders.index') }}" class="@if(request()->routeIs('admin.orders.*')) is-active @endif">Orders</a>
            </nav>

            <div class="admin-sidebar-footer">
                <a href="{{ route('home') }}" class="admin-view-site">&larr; View site</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Sign Out</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            @if(session('status'))
                <div class="admin-flash">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>