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

    <div class="admin-backdrop" id="adminBackdrop"></div>

    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-head">
                <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Quality Gadgets Hub logo">
                    <span>QGH Admin</span>
                </a>
                <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Close menu">
                    <x-icon name="close" :size="18" />
                </button>
            </div>

            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) is-active @endif">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="@if(request()->routeIs('admin.products.*')) is-active @endif">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="@if(request()->routeIs('admin.categories.*')) is-active @endif">Categories</a>
                <a href="{{ route('admin.orders.index') }}" class="@if(request()->routeIs('admin.orders.*')) is-active @endif">Orders</a>
                <a href="{{ route('admin.reviews.index') }}" class="@if(request()->routeIs('admin.reviews.*')) is-active @endif">Reviews</a>
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
            <div class="admin-mobile-bar">
                <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Open menu" aria-controls="adminSidebar" aria-expanded="false">
                    <x-icon name="menu" :size="20" />
                </button>
                <span>QGH Admin</span>
            </div>

            @if(session('status'))
                <div class="admin-flash">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('adminMenuToggle');
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminBackdrop');
            const closeBtn = document.getElementById('adminSidebarClose');

            function openSidebar() {
                sidebar.classList.add('is-open');
                backdrop.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                backdrop.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            if (toggle && sidebar && backdrop) {
                toggle.addEventListener('click', openSidebar);
                closeBtn.addEventListener('click', closeSidebar);
                backdrop.addEventListener('click', closeSidebar);
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') closeSidebar();
                });
            }
        });
    </script>

@stack('scripts')

</body>
</html>