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
                    <a href="#" aria-label="Instagram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                    </a>
                    <a href="#" aria-label="X">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4l16 16M20 4L4 20" stroke="currentColor" stroke-width="2"/></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zM8 12l3 3 5-6"/></svg>
                    </a>
                </div>
            </div>

            <div class="foot-col">
                <h4>Shop</h4>
                <ul>
                    <li><a href="#">Android phones</a></li>
                    <li><a href="#">iPhones</a></li>
                    <li><a href="#">Tablets</a></li>
                    <li><a href="#">Accessories</a></li>
                    <li><a href="#deals">Flash deals</a></li>
                </ul>
            </div>

            <div class="foot-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>

            <div class="foot-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="#">Return policy</a></li>
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