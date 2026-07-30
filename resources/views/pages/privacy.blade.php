@extends('layouts.app')

@section('title', 'Privacy Policy — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Privacy Policy</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Privacy Policy</h2></div>
            </div>

            <div class="legal-page">
                <p class="legal-updated">Last updated: {{ now()->format('d F Y') }}</p>

                <h2>1. Information We Collect</h2>
                <p>When you create an account, place an order, or contact us, we may collect your name, email address, phone number, delivery address, and order history. We do not collect or store your card details — all card payments are handled directly by our payment partner, Paystack.</p>

                <h2>2. How We Use Your Information</h2>
                <ul>
                    <li>To process and deliver your orders</li>
                    <li>To send order confirmations and delivery updates</li>
                    <li>To respond to customer support enquiries</li>
                    <li>To improve our products, services, and website experience</li>
                </ul>

                <h2>3. Sharing of Information</h2>
                <p>We do not sell your personal information. We share order and delivery details only with the parties necessary to fulfil your order — such as our payment processor and delivery partners — and only to the extent required.</p>

                <h2>4. Cookies</h2>
                <p>We use cookies and session storage to keep you logged in, remember items in your cart, and understand how our website is used. You can disable cookies through your browser settings, though some features of the site may not function correctly without them.</p>

                <h2>5. Data Security</h2>
                <p>We take reasonable technical and organisational measures to protect your personal information from unauthorised access, loss, or misuse.</p>

                <h2>6. Your Rights</h2>
                <p>You may request access to, correction of, or deletion of your personal data by contacting our support team. Some information may be retained where required for legal, accounting, or order-history purposes.</p>

                <h2>7. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. Any changes will be reflected on this page with an updated revision date.</p>

                <h2>8. Contact</h2>
                <p>For any questions about how we handle your data, please reach out via our Contact Us page.</p>
            </div>
        </div>
    </section>

@endsection