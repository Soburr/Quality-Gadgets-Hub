@props(['categories' => collect()])

<div class="menu-backdrop" id="menuBackdrop"></div>

<aside class="mobile-menu" id="mobileMenu" aria-hidden="true">
    <div class="mobile-menu-head">
        <button type="button" id="menuClose" aria-label="Close menu">
            <x-icon name="arrow-left" :size="22" />
        </button>
        <span>Menu</span>
    </div>

    <nav class="mobile-menu-list">
        @foreach($categories as $category)
            <x-category-branch :category="$category" />
        @endforeach

        <a class="mm-link" href="{{ route('home') }}#grid">All Products</a>
        <a class="mm-link" href="{{ route('cart.show') }}">Cart</a>
        <a class="mm-link" href="{{ route('wishlist.show') }}">Wishlist</a>

        <details class="mm-accordion">
            <summary>
                Account
                <x-icon name="chevron-down" :size="18" />
            </summary>
            <div class="mm-sublist">
                @auth
                    <a class="mm-sublist-link" href="{{ route('account.show') }}">My Account</a>
                    <a class="mm-sublist-link" href="{{ route('account.orders') }}">My Orders</a>
                    <a class="mm-sublist-link" href="#">Track Order</a>
                    @if(auth()->user()->is_admin)
                        <a class="mm-sublist-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="mm-sublist-link" style="width:100%;text-align:left;">Sign Out</button>
                    </form>
                @else
                    <a class="mm-sublist-link" href="{{ route('login') }}">Sign In</a>
                    <a class="mm-sublist-link" href="{{ route('register') }}">Create Account</a>
                @endauth
            </div>
        </details>

        <a class="mm-link" href="#">Help Center</a>
    </nav>
</aside>