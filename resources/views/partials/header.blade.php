<div class="header-row wrap">
    <button type="button" class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-controls="mobileMenu" aria-expanded="false">
        <x-icon name="menu" :size="22" />
    </button>

    <a class="brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.jpg') }}" alt="Quality Gadgets Hub logo">
        <span class="name">Quality Gadgets Hub</span>
    </a>

    {{-- TODO: point this at a real SearchController@index route --}}
    <form class="search" action="#" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search phones, brands, accessories...">
        <button type="submit" aria-label="Search">
            <x-icon name="search" :size="18" />
        </button>
    </form>

    {{-- TODO: swap these '#' hrefs for real account/wishlist/cart routes once those controllers exist --}}
    <div class="header-actions">
        <a class="item" href="#">
            <span class="icon"><x-icon name="user" :size="22" /></span>
            <span class="label">Account</span>
        </a>
        <a class="item" href="#">
            <span class="icon"><x-icon name="heart" :size="22" /></span>
            <span class="label">Wishlist</span>
        </a>
        <a class="item" href="{{ route('cart.show') }}">
            <span class="icon">
                <x-icon name="cart" :size="22" />
                <span class="cart-count" id="cartCount">{{ $cartCount ?? 0 }}</span>
            </span>
            <span class="label">Cart</span>
        </a>
    </div>
</div>