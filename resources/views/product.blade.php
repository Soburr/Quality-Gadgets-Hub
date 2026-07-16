@extends('layouts.app')

@section('title', $product->name . ' — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                @foreach($breadcrumbChain as $crumb)
                    <span class="sep">/</span>
                    <a href="{{ route('category.show', $crumb) }}">{{ $crumb->label }}</a>
                @endforeach
                <span class="sep">/</span>
                <span class="current">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="pdp">
                {{-- GALLERY --}}
                <div class="pdp-gallery">
                    <div class="pdp-main-image ring-frame">
                        <svg class="ring" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="38" fill="none" stroke="#C40356" stroke-opacity="0.25" stroke-width="9" stroke-dasharray="190 48"/>
                        </svg>
                        <img id="pdpMainImage" src="{{ $product->gallery[0] ?? $product->image }}" alt="{{ $product->name }}">
                    </div>

                    @if(!empty($product->gallery) && count($product->gallery) > 1)
                        <div class="pdp-thumbs">
                            @foreach($product->gallery as $i => $img)
                                <button type="button" class="pdp-thumb @if($i === 0) is-active @endif" data-img="{{ $img }}">
                                    <img src="{{ $img }}" alt="{{ $product->name }} view {{ $i + 1 }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- INFO --}}
                <div class="pdp-info">
                    @if($product->badge)
                        <span class="badge pdp-badge @if($product->badge === 'New') new @elseif($product->badge === 'Verified') verified @endif">{{ $product->badge }}</span>
                    @endif

                    <h1 class="pdp-title">{{ $product->name }}</h1>

                    <div class="pdp-rating">
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="s">{{ $i <= round($product->rating) ? '★' : '☆' }}</span>
                            @endfor
                        </span>
                        <span class="pdp-reviews">{{ number_format($product->reviews_count) }} reviews</span>
                        <span class="sep">&middot;</span>
                        <span class="pdp-stock @if($product->stock < 5) low @endif">
                            {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                        </span>
                    </div>

                    <div class="pdp-price-row">
                        <span class="pdp-now mono">&#8358;{{ number_format($product->price) }}</span>
                        @if($product->was_price)
                            <span class="pdp-was mono">&#8358;{{ number_format($product->was_price) }}</span>
                            <span class="off">{{ round((1 - $product->price / $product->was_price) * 100) }}% off</span>
                        @endif
                    </div>

                    <form action="{{ route('cart.add', $product) }}" method="POST" class="pdp-form">
                        @csrf

                        @if(!empty($product->colors))
                            <div class="pdp-field">
                                <span class="pdp-field-label">Color: <strong id="selectedColorName">{{ $product->colors[0]['name'] }}</strong></span>
                                <div class="color-swatches">
                                    @foreach($product->colors as $i => $color)
                                        <label class="swatch" style="background:{{ $color['hex'] }}">
                                            <input type="radio" name="color" value="{{ $color['name'] }}" data-name="{{ $color['name'] }}" @checked($i === 0)>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="pdp-field">
                            <span class="pdp-field-label">Quantity</span>
                            <div class="qty-stepper">
                                <button type="button" class="qty-btn" id="qtyMinus" aria-label="Decrease quantity"><x-icon name="minus" :size="16" /></button>
                                <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ max($product->stock, 1) }}" inputmode="numeric">
                                <button type="button" class="qty-btn" id="qtyPlus" aria-label="Increase quantity"><x-icon name="plus" :size="16" /></button>
                            </div>
                        </div>

                        <div class="pdp-actions">
                            <button type="submit" formaction="{{ route('checkout.buyNow', $product) }}" class="btn btn-primary pdp-buy" @disabled($product->stock === 0)>
                                {{ $product->stock > 0 ? 'Buy Now' : 'Out of stock' }}
                            </button>
                            <button type="submit" class="btn btn-ghost pdp-add" @disabled($product->stock === 0)>
                                <x-icon name="cart" :size="18" />
                                Add to cart
                            </button>
                            <button type="submit" formaction="{{ route('wishlist.toggle', $product) }}" class="pdp-fav @if($inWishlist) is-active @endif" aria-label="{{ $inWishlist ? 'Remove from' : 'Save to' }} wishlist">
                                <x-icon name="heart" :size="20" />
                            </button>
                        </div>
                    </form>

                    <div class="pdp-trust">
                        <div class="t"><x-icon name="check" :size="16" /> Verified seller</div>
                        <div class="t"><x-icon name="check" :size="16" /> 7-day return window</div>
                        <div class="t"><x-icon name="truck" :size="16" /> Pay on delivery (Lagos)</div>
                    </div>
                </div>
            </div>

            @if($product->description)
                <div class="pdp-description">
                    <h2>Product details</h2>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            {{-- ============ RATINGS & REVIEWS ============ --}}
            <div class="section-head" style="margin-top:36px;">
                <div><h2>Ratings &amp; Reviews</h2><div class="sub">{{ $reviews->count() }} verified reviews</div></div>
            </div>

            <div class="reviews-summary">
                <div class="reviews-score">
                    <div class="reviews-score-number">{{ number_format($product->rating, 1) }}</div>
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="s">{{ $i <= round($product->rating) ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <div class="reviews-score-count">{{ number_format($product->reviews_count) }} ratings</div>
                </div>

                <div class="reviews-bars">
                    @foreach($ratingBreakdown as $star => $data)
                        <div class="reviews-bar-row">
                            <span class="reviews-bar-label">{{ $star }} star</span>
                            <div class="reviews-bar-track">
                                <div class="reviews-bar-fill" style="width: {{ $data['percent'] }}%"></div>
                            </div>
                            <span class="reviews-bar-count">{{ $data['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($reviews->isEmpty())
                <div class="empty-state">
                    <p>No reviews yet for this product.</p>
                </div>
            @else
                <div class="review-list">
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="review-card-head">
                                <span class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="s">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </span>
                                @if($review->is_verified)
                                    <span class="review-verified">Verified Purchase</span>
                                @endif
                            </div>
                            @if($review->title)
                                <h4 class="review-title">{{ $review->title }}</h4>
                            @endif
                            <p class="review-comment">{{ $review->comment }}</p>
                            <div class="review-meta">{{ $review->reviewer_name }} &middot; {{ $review->created_at->format('d M Y') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if($related->isNotEmpty())
        <section class="section">
            <div class="wrap">
                <div class="section-head">
                    <div><h2>You may also like</h2><div class="sub">More from {{ $product->category->label }}</div></div>
                </div>
                <div class="grid">
                    @foreach($related as $i => $item)
                        <x-product-card :product="$item" :seed="$i" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.getElementById('pdpMainImage');
    document.querySelectorAll('.pdp-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            document.querySelectorAll('.pdp-thumb').forEach(t => t.classList.remove('is-active'));
            thumb.classList.add('is-active');
            mainImage.src = thumb.dataset.img;
        });
    });

    const colorName = document.getElementById('selectedColorName');
    document.querySelectorAll('input[name="color"]').forEach(input => {
        input.addEventListener('change', () => {
            if (colorName) colorName.textContent = input.dataset.name;
        });
    });

    const qtyInput = document.getElementById('qtyInput');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    if (qtyInput && qtyMinus && qtyPlus) {
        qtyMinus.addEventListener('click', () => {
            qtyInput.value = Math.max(parseInt(qtyInput.value || 1, 10) - 1, parseInt(qtyInput.min || 1, 10));
        });
        qtyPlus.addEventListener('click', () => {
            qtyInput.value = Math.min(parseInt(qtyInput.value || 1, 10) + 1, parseInt(qtyInput.max || 99, 10));
        });
    }
});
</script>
@endpush