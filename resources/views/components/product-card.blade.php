@props(['product', 'seed' => 0])

@php
    $badgeClass = match(true) {
        $product->badge === 'New' => 'new',
        $product->badge === 'Verified' => 'verified',
        default => '',
    };
    $discount = $product->was_price
        ? round((1 - $product->price / $product->was_price) * 100)
        : null;
    $gap = 40 + ($seed % 5) * 10;
@endphp

<div class="card">
    @if($product->badge)
        <span class="badge {{ $badgeClass }}">{{ $product->badge }}</span>
    @endif

    <button type="button" class="fav" aria-label="Save {{ $product->name }} to wishlist">
        <x-icon name="heart" :size="14" />
    </button>

    <a href="{{ route('product.show', $product) }}" class="card-link">
        <div class="thumb">
            <svg class="ring" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="38" fill="none" stroke="#C40356" stroke-opacity="0.35" stroke-width="9"
                        stroke-dasharray="{{ 238 - $gap }} {{ $gap }}"/>
            </svg>

            @if($product->image)
                <img src="{{ str($product->image)->startsWith(['http://', 'https://']) ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="phone" style="width:90px;">
            @else
                <svg class="phone" viewBox="0 0 40 76">
                    <rect x="2" y="2" width="36" height="72" rx="7" fill="#20141A"/>
                    <rect x="5.5" y="8" width="29" height="55" rx="2" fill="#FFF8F6"/>
                    <circle cx="20" cy="70" r="2.4" fill="#5C001F"/>
                </svg>
            @endif
        </div>

        <p class="title">{{ $product->name }}</p>

        <div class="stars">
            @for($i = 1; $i <= 5; $i++)
                <span class="s">{{ $i <= round($product->rating) ? '★' : '☆' }}</span>
            @endfor
            <span>({{ number_format($product->reviews_count) }})</span>
        </div>

        <div class="price-row">
            <span class="now mono">&#8358;{{ number_format($product->price) }}</span>
            @if($product->was_price)
                <span class="was mono">&#8358;{{ number_format($product->was_price) }}</span>
                <span class="off">{{ $discount }}% off</span>
            @endif
        </div>
    </a>

    <form action="{{ route('cart.add', $product) }}" method="POST">
        @csrf
        <button type="submit" class="add">
            <x-icon name="cart" :size="14" />
            Add to cart
        </button>
    </form>
</div>