@extends('layouts.app')

@section('title', 'Quality Gadgets Hub — Original Phones, Real Prices')

@section('content')

    {{-- ==== ==== HERO ==== ==== --}}
    <section class="hero">
        <div class="wrap">
            <div class="hero-copy">
                <div class="eyebrow"><span class="dot"></span>New stock just landed</div>
                <h1>Real phones.<br>Real prices. <em>No wahala.</em></h1>
                <p class="lede">Every device on Quality Gadgets Hub is inspected and verified before it ships — from flagship Android to budget-friendly workhorses.</p>
                <div class="hero-ctas">
                    <a class="btn btn-primary" href="#deals">Shop flash deals</a>
                    <a class="btn btn-ghost" href="#grid">Browse all phones</a>
                </div>
                <div class="trust-row">
                    <div class="t"><x-icon name="check" :size="16" /> Verified sellers only</div>
                    <div class="t"><x-icon name="check" :size="16" /> 7-day return window</div>
                    <div class="t"><x-icon name="check" :size="16" /> Pay on delivery (Lagos)</div>
                </div>
            </div>

            <div class="hero-visual ring-frame">
                <svg class="glow-ring" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="86" fill="none" stroke="#8C0027" stroke-opacity="0.14" stroke-width="26"/>
                    <path d="M100 14 A86 86 0 1 1 40 166" fill="none" stroke="#C40356" stroke-width="26" stroke-linecap="round"/>
                </svg>
                <svg width="150" viewBox="0 0 100 200">
                    <rect x="6" y="6" width="88" height="188" rx="16" fill="#20141A"/>
                    <rect x="12" y="18" width="76" height="150" rx="4" fill="#FFF8F6"/>
                    <circle cx="50" cy="188" r="6" fill="#3A2830"/>
                </svg>
                <div class="price-bubble">
                    <div class="cut mono">&#8358;398,000</div>
                    <div class="now mono">&#8358;329,000</div>
                </div>
                <div class="rating-bubble">&#9733; 4.8 <span style="color:var(--ink-soft);font-weight:600;">(2,140)</span></div>
            </div>
        </div>
    </section>

    {{-- ============ FLASH SALE ============ --}}
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

    {{-- ============ VALUE PROPS ============ --}}
    <section class="values">
        <div class="wrap">
            <div class="value">
                <span class="icon"><x-icon name="box" :size="20" /></span>
                <div><h3>Verified sellers</h3><p>Every phone inspected on arrival</p></div>
            </div>
            <div class="value">
                <span class="icon"><x-icon name="check" :size="20" /></span>
                <div><h3>7-day returns</h3><p>Change your mind, no stress</p></div>
            </div>
            <div class="value">
                <span class="icon"><x-icon name="truck" :size="20" /></span>
                <div><h3>Pay on delivery</h3><p>Available across Lagos</p></div>
            </div>
            <div class="value">
                <span class="icon"><x-icon name="arrow-right" :size="20" /></span>
                <div><h3>Fast dispatch</h3><p>Same-day shipping before 3pm</p></div>
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
                                    <img src="{{ str($brand->logo)->startsWith(['http://','https://']) ? $brand->logo : asset($brand->logo) }}" alt="{{ $brand->name }}" class="cat-tile-image">
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
            <<div class="section-head section-head--banner">
                <div><h2>All phones &amp; gadgets</h2><div class="sub">Everything in stock, no filters needed</div></div>
                <span class="count-badge">{{ $products->count() }} in stock</span>
            </div>
            <div class="grid">
                @foreach($products as $i => $product)
                    <x-product-card :product="$product" :seed="$i + 30" />
                @endforeach
            </div>
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
@endsection