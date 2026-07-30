<footer>
    <div class="foot-top">
        <div class="wrap">
            <div class="foot-brand">
                <a class="brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Quality Gadgets Hub logo" style="width:38px;height:38px;">
                    <span class="name">Quality Gadgets Hub</span>
                </a>
                <p>Verified new and UK-used phones, shipped across Nigeria with real support behind every order.</p>
                <div class="foot-social">
                    <a href="https://www.instagram.com/quality_gadgets_hub/?hl=en" aria-label="Instagram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                    </a>
                    <a href="https://x.com/QualityGadgets_" aria-label="X">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4l16 16M20 4L4 20" stroke="currentColor" stroke-width="2"/></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zM8 12l3 3 5-6"/></svg>
                    </a>
                </div>
            </div>

@php
                $findCategoryBySlug = function ($categories, $slug) use (&$findCategoryBySlug) {
                    foreach ($categories as $cat) {
                        if ($cat->slug === $slug) {
                            return $cat;
                        }
                        if ($cat->children->isNotEmpty()) {
                            $found = $findCategoryBySlug($cat->children, $slug);
                            if ($found) {
                                return $found;
                            }
                        }
                    }
                    return null;
                };

                $phoneCategory = $findCategoryBySlug($navCategories ?? collect(), 'phone');
                $iphoneCategory = $findCategoryBySlug($navCategories ?? collect(), 'iphone');
                $laptopCategory = $findCategoryBySlug($navCategories ?? collect(), 'laptop');
                $accessoriesCategory = $findCategoryBySlug($navCategories ?? collect(), 'accessories');
            @endphp

            <div class="foot-col">
                <h4>Shop</h4>
                <ul>
                    <li><a href="{{ $phoneCategory ? route('category.show', $phoneCategory) : '#' }}">All Phones</a></li>
                    <li><a href="{{ $iphoneCategory ? route('category.show', $iphoneCategory) : '#' }}">iPhones</a></li>
                    <li><a href="{{ $laptopCategory ? route('category.show', $laptopCategory) : '#' }}">Laptops</a></li>
                    <li><a href="{{ $accessoriesCategory ? route('category.show', $accessoriesCategory) : '#' }}">Accessories</a></li>
                    <li><a href="{{ route('home') }}#deals">Flash deals</a></li>
                </ul>
            </div>

            <div class="foot-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ route('pages.about') }}">About us</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contact us</a></li>
                </ul>
            </div>

    <div class="foot-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="{{ route('pages.terms') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('pages.privacy') }}">Privacy policy</a></li>
                    <li>
                        <!-- <a href="{{ route('pages.returns') }}">Return policy</a> -->
                    </li>
                    <li><a href="{{ route('pages.refundGuidelines') }}">Refund &amp; Replacement Guidelines</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="foot-bottom">
        <div class="wrap">
            <span>&copy; {{ now()->year }} Quality Gadgets Hub. All rights reserved.</span>
            <div class="pay-icons">
                <span>Card</span>
                <span>Bank Transfer</span>
                <span>POD</span>
                <span>USSD</span>
            </div>
        </div>
    </div>
</footer>