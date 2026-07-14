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
        <a class="mm-link" href="#">Wishlist</a>

        <details class="mm-accordion">
            <summary>
                Account
                <x-icon name="chevron-down" :size="18" />
            </summary>
            <div class="mm-sublist">
                <a class="mm-sublist-link" href="#">Sign In</a>
                <a class="mm-sublist-link" href="#">Create Account</a>
                <a class="mm-sublist-link" href="#">My Orders</a>
                <a class="mm-sublist-link" href="#">Track Order</a>
            </div>
        </details>

        <a class="mm-link" href="#">Help Center</a>
    </nav>
</aside>