@extends('layouts.app')

@section('title', 'Quality Gadgets Hub — Utmost Quality At All Times')

@section('content')

    {{-- ==== ==== HERO ==== ==== --}}
    <section class="hero">
        <div class="wrap">
            <div class="hero-copy">
                <div class="eyebrow"><span class="dot"></span>New stock just landed</div>
                <h1>Utmost Quality <em>At All Times...</em></h1>
                <p class="lede">Welcome to your ultimate destination for original tech gadgets and other smart accessories designed to elevate your lifestyle.</p>
                <div class="hero-ctas">
                    <a class="btn btn-primary" href="#deals">Shop flash deals</a>
                    <a class="btn btn-ghost" href="#grid">Browse all phones</a>
                </div>
            </div>

            <div class="hero-visual ring-frame">
                <svg class="glow-ring" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="86" fill="none" stroke="#8C0027" stroke-opacity="0.14" stroke-width="26"/>
                    <path d="M100 14 A86 86 0 1 1 40 166" fill="none" stroke="#C40356" stroke-width="26" stroke-linecap="round"/>
                </svg>

                @if($heroProduct)
                    <a href="{{ route('product.show', $heroProduct) }}" class="hero-visual-link">
                        <img src="{{ str($heroProduct->image)->startsWith(['http://','https://']) ? $heroProduct->image : asset($heroProduct->image) }}" alt="{{ $heroProduct->name }}" class="hero-product-image">
                    </a>
                    <div class="price-bubble">
                        @if($heroProduct->was_price)
                            <div class="cut mono">&#8358;{{ number_format($heroProduct->was_price) }}</div>
                        @endif
                        <div class="now mono">&#8358;{{ number_format($heroProduct->price) }}</div>
                    </div>
                    <div class="rating-bubble">&#9733; {{ number_format($heroProduct->rating, 1) }} <span style="color:var(--ink-soft);font-weight:600;">({{ number_format($heroProduct->reviews_count) }})</span></div>
                @else
                    <svg width="150" viewBox="0 0 100 200">
                        <rect x="6" y="6" width="88" height="188" rx="16" fill="#20141A"/>
                        <rect x="12" y="18" width="76" height="150" rx="4" fill="#FFF8F6"/>
                        <circle cx="50" cy="188" r="6" fill="#3A2830"/>
                    </svg>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ GREAT FINDS (admin-curated) ============ --}}
    @if($featuredPicks->isNotEmpty())
        <section class="section">
            <div class="wrap">
                <div class="finds">
                    <div class="section-head">
                        <div>
                            <h2>&#128176; Great Finds</h2>
                            <div class="sub">Handpicked essentials, big value</div>
                        </div>
                        <a class="see-all finds-see-all" href="{{ route('featured.index') }}">See all &rarr;</a>
                    </div>
                    <div class="h-scroll">
                        @foreach($featuredPicks as $i => $product)
                            <x-product-card :product="$product" :seed="$i + 40" />
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ VALUE PROPS ============ --}}
    <section class="values">
        <div class="wrap">
            <div class="value">
                <span class="icon"><x-icon name="box" :size="20" /></span>
                <div><h3>Pickup Option</h3><p>You can arrange a pickup or visit our physical store to collect your order. We'll be happy to assist you!</p></div>
            </div>
            <div class="value">
                <span class="icon"><x-icon name="check" :size="20" /></span>
                <div><h3>Fast Delivery</h3><p>Same day delivery is guaranteed within Lagos. Orders made from outside Lagos may take up to 24–48 hours.</p></div>
            </div>
        </div>
    </section>

    {{-- ============ SHOP BY CATEGORY ============ --}}
    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Shop by category</h2><div class="sub">Find exactly what you came for</div></div>
            </div>
            <div class="cat-grid">
                @foreach($categories as $category)
                    <x-category-tile :category="$category" />
                @endforeach
            </div>
        </div>
    </section>
    
    {{-- ============ SHOP BY BRAND ============ --}}
    @if($brands->isNotEmpty())
        <section class="section">
            <div class="wrap">
                <div class="section-head">
                    <div><h2>Shop by brand</h2><div class="sub">Your favourite names, all in one place</div></div>
                </div>
                <div class="cat-grid">
                    @foreach($brands as $brand)
                        <a href="{{ route('brand.show', $brand) }}" class="cat-tile">
                            <div class="ring-frame">
                                @if($brand->logo)
                                    <img src="{{ str($brand->logo)->startsWith(['http://','https://']) ? $brand->logo : asset($brand->logo) }}" alt="{{ $brand->name }}" class="cat-tile-image" loading="lazy">
                                @else
                                    <svg class="ring" viewBox="0 0 100 100"><circle cx="50" cy="50" r="42" fill="none" stroke="#8C0027" stroke-opacity="0.25" stroke-width="8" stroke-dasharray="230 34"/></svg>
                                    <div class="icon"><x-icon name="box" :size="24" /></div>
                                @endif
                            </div>
                            <span>{{ $brand->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ NEW ARRIVALS ============ --}}
    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow magenta"><span class="dot"></span>New this week</div>
                    <h2>New arrivals</h2>
                    <div class="sub">Just landed this week</div>
                </div>
                <a class="see-all" href="#grid">See all &rarr;</a>
            </div>
            <div class="h-scroll">
                @foreach($newArrivals as $i => $product)
                    <x-product-card :product="$product" :seed="$i + 10" />
                @endforeach
            </div>
        </div>
    </section>

        {{-- ============ PROMO BANNERS (admin-managed) ============ --}}
    @if($banners->isNotEmpty())
        <section class="promo-section">
            <div class="wrap">
                <div class="promo" id="promo">
                    <div class="promo-track" id="promoTrack">
                        @foreach($banners as $banner)
                            @php
                                $imageUrl = str($banner->image)->startsWith(['http://','https://']) ? $banner->image : asset($banner->image);
                                $hasText = $banner->title || $banner->subtitle || $banner->button_text;
                            @endphp

                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" class="promo-slide">
                            @else
                                <div class="promo-slide">
                            @endif

                                <img src="{{ $imageUrl }}" alt="{{ $banner->title ?: 'Promotion' }}" class="promo-image" loading="{{ $loop->first ? 'eager' : 'lazy' }}">

                                @if($hasText)
                                    <div class="promo-overlay">
                                        @if($banner->title)<h2>{{ $banner->title }}</h2>@endif
                                        @if($banner->subtitle)<p>{{ $banner->subtitle }}</p>@endif
                                        @if($banner->button_text)<span class="promo-button">{{ $banner->button_text }} &rarr;</span>@endif
                                    </div>
                                @endif

                            @if($banner->link_url)
                                </a>
                            @else
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($banners->count() > 1)
                        <div class="promo-dots" id="promoDots">
                            @foreach($banners as $i => $banner)
                                <button type="button" class="promo-dot @if($i === 0) is-active @endif" data-index="{{ $i }}" aria-label="Show banner {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ======== FLASH SALE ======== --}}
    <section class="section" id="deals">
        <div class="wrap">
            <div class="flash">
                <div class="section-head">
                    <div>
                        <h2>&#9889; Flash Sale</h2>
                        <div class="sub">Prices this good disappear fast — restock not guaranteed</div>
                    </div>
                    <x-ring-timer :ends-at="$flashEndsAt" />
                </div>

                <div class="h-scroll">
                    @foreach($flashProducts as $i => $product)
                        <x-product-card :product="$product" :seed="$i" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ BEST SELLERS ============ --}}
    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow gold"><span class="dot"></span>Top rated</div>
                    <h2>Best sellers</h2>
                    <div class="sub">Highest rated by real buyers</div>
                </div>
                <a class="see-all" href="#grid">See all &rarr;</a>
            </div>
            <div class="grid">
                @foreach($bestSellers as $i => $product)
                    <x-product-card :product="$product" :seed="$i + 20" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ MAIN PRODUCT GRID ============ --}}
    <section class="section" id="grid">
        <div class="wrap">
            <div class="section-head section-head--banner">
                <div><h2>All phones &amp; gadgets</h2><div class="sub">Everything in stock, no filters needed</div></div>
                <span class="count-badge">{{ $products->total() }} in stock</span>
            </div>
            <div class="grid">
                @foreach($products as $i => $product)
                    <x-product-card :product="$product" :seed="$i + 30" />
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="pager">
                    @if($products->previousPageUrl())
                        <a href="{{ $products->previousPageUrl() }}#grid" class="pager-btn">&larr; Prev</a>
                    @endif
                    <span class="pager-info">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
                    @if($products->nextPageUrl())
                        <a href="{{ $products->nextPageUrl() }}#grid" class="pager-btn">Next &rarr;</a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- ============ TRUST / ASSURANCE ============ --}}
    <section class="section">
        <div class="wrap">
            <div class="assurance">

                <div class="assurance-grid">
                    <div class="assurance-item">
                        <span class="assurance-icon"><x-icon name="support" :size="26" /></span>
                        <h3>Post-Purchase Support</h3>
                        <p>Beyond just being your gadgets provider, we're committed to after-sales service aimed at optimizing your device's performance and ensuring longevity.</p>
                    </div>

                    <div class="assurance-divider"></div>

                    <div class="assurance-item">
                        <span class="assurance-icon"><x-icon name="shield" :size="26" /></span>
                        <h3>Ethical Assurance</h3>
                        <p>Fully armed by our values and professional ethics, we ensure that our customers' tech and digital needs are met while never reneging on our pledge of utmost quality.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var track = document.getElementById('promoTrack');
    var dots = document.querySelectorAll('#promoDots .promo-dot');
    if (!track || dots.length < 2) return;

    var current = 0;
    var timer;

    function goTo(i) {
        current = (i + dots.length) % dots.length;
        track.scrollTo({ left: track.clientWidth * current, behavior: 'smooth' });
    }

    function start() { timer = setInterval(function () { goTo(current + 1); }, 5000); }
    function stop() { clearInterval(timer); }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () { stop(); goTo(parseInt(dot.dataset.index, 10)); start(); });
    });

    // Keep the dots in sync when someone swipes manually.
    track.addEventListener('scroll', function () {
        var i = Math.round(track.scrollLeft / track.clientWidth);
        current = i;
        dots.forEach(function (d, idx) { d.classList.toggle('is-active', idx === i); });
    });

    track.addEventListener('mouseenter', stop);
    track.addEventListener('mouseleave', start);
    track.addEventListener('touchstart', stop, { passive: true });

    start();
});
</script>
@endpush
@endsection