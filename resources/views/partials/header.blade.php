<div class="header-row wrap">
    <button type="button" class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-controls="mobileMenu" aria-expanded="false">
        <x-icon name="menu" :size="22" />
    </button>

    <a class="brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.jpg') }}" alt="Quality Gadgets Hub logo">
        <span class="name">Quality Gadgets Hub</span>
    </a>

    <form class="search" action="{{ route('search') }}" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search phones, brands, accessories...">
        <button type="submit" aria-label="Search">
            <x-icon name="search" :size="18" />
        </button>
    </form>

    <div class="header-actions">
        <a class="item" href="{{ auth()->check() ? route('account.show') : route('login') }}">
            <span class="icon"><x-icon name="user" :size="22" /></span>
            <span class="label">{{ auth()->check() ? \Illuminate\Support\Str::before(auth()->user()->name, ' ') : 'Account' }}</span>
        </a>
        <a class="item" href="{{ route('wishlist.show') }}">
            <span class="icon">
                <x-icon name="heart" :size="22" />
                @if(($wishlistCount ?? 0) > 0)
                    <span class="cart-count">{{ $wishlistCount }}</span>
                @endif
            </span>
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