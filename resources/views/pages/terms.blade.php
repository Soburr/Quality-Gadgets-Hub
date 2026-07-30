@extends('layouts.app')

@section('title', 'Terms & Conditions — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Terms &amp; Conditions</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Terms &amp; Conditions</h2></div>
            </div>

            <div class="legal-page">
                <p>We welcome you to Quality Gadgets Hub, the following terms govern your use of our website <a href="https://www.qualitygadgetshub.com.ng" target="_blank" rel="noopener">www.qualitygadgetshub.com.ng</a> and the purchase of any product(s) from us. By accessing our Site or purchasing from us, you agree to these Terms. Please read them carefully.</p>

                <h2>1. General Information</h2>
                <ul>
                    <li>The Site is operated by Quality Gadgets Hub registered in Nigeria.</li>
                    <li>By using the Site, you confirm that you are at least 18 years old or have the permission of a parent/guardian.</li>
                </ul>

                <h2>2. Products &amp; Orders</h2>
                <ul>
                    <li>All Products displayed are subject to availability.</li>
                    <li>We make sufficient effort to ensure descriptions, images, color and prices are accurate, but errors may occur.</li>
                    <li>Placing an order does not mean it is accepted. We reserve the right to refuse or cancel any order, especially in cases of pricing errors, suspected fraud, or availability issues.</li>
                </ul>

                <h2>3. Pricing &amp; Payment</h2>
                <ul>
                    <li>Prices are listed in Naira (&#8358;) and include/exclude taxes where applicable.</li>
                    <li>Payment must be made in full and confirmed before order dispatch.</li>
                </ul>

                <h2>4. Shipping &amp; Delivery</h2>
                <ul>
                    <li>Even though we will explore every possible means to deliver your order in the agreed timeframe, times provided are estimated and not guaranteed.</li>
                    <li>We are not responsible for delays caused by courier services, customs, or unforeseen events.</li>
                </ul>

                <h2>5. Intellectual Property</h2>
                <ul>
                    <li>All content on the Site (logos, images, product descriptions, designs) is the property of Quality Gadgets Hub or product manufacturers.</li>
                    <li>You may not copy, reproduce, or distribute any content without prior written permission.</li>
                </ul>

                <h2>6. Privacy</h2>
                <p>Your personal information will be handled in line with our <a href="{{ route('pages.privacy') }}">Privacy Policy</a>.</p>

                <h2>7. Changes to Terms</h2>
                <p>We reserve the right to update these Terms at any time. Updates will be posted on this page, and continued use of the Site means acceptance of the changes.</p>

                <h2>Contact Us</h2>
                <p>For any questions regarding these Terms, please contact us via any of our mobile or digital channels.</p>
                <ul>
                    <li>Email: <a href="mailto:qualitygadgetsng@gmail.com">qualitygadgetsng@gmail.com</a></li>
                    <li>Phone: 08169698791 | 09161273663</li>
                    <li>WhatsApp: 08076460107 | 07049486290</li>
                </ul>
            </div>
        </div>
    </section>

@endsection