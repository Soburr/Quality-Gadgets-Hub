@extends('layouts.app')

@section('title', 'Return Policy — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Return Policy</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Return Policy</h2></div>
            </div>

            <div class="legal-page">
                <p class="legal-updated">Last updated: {{ now()->format('d F Y') }}</p>

                <h2>1. Return Window</h2>
                <p>You may request a return within <strong>7 days</strong> of receiving your order. Requests made after this window will not be eligible for a refund or exchange, except where the product is faulty.</p>

                <h2>2. Eligibility</h2>
                <ul>
                    <li>The product must be unused, undamaged, and in its original packaging with all accessories included.</li>
                    <li>Proof of purchase (order number or receipt) is required for all returns.</li>
                    <li>Products marked as final sale or clearance are not eligible for return, unless faulty on arrival.</li>
                </ul>

                <h2>3. Faulty or Incorrect Items</h2>
                <p>If you receive a faulty, damaged, or incorrect item, please contact us within 48 hours of delivery with photos of the issue. We will arrange a replacement or full refund at no extra cost to you. See our full <a href="{{ route('pages.refundGuidelines') }}">Refund &amp; Replacement Guidelines</a> for warranty coverage details.</p>

                <h2>4. How to Start a Return</h2>
                <p>To begin a return, go to <a href="{{ route('account.orders') }}">My Orders</a>, select the relevant order, and follow the return instructions, or contact our support team directly with your order number.</p>

                <h2>5. Refunds</h2>
                <p>Once your return is received and inspected, refunds are processed back to your original payment method (for online payments) or via bank transfer (for Pay on Delivery orders) within 5–7 business days.</p>

                <h2>6. Return Shipping</h2>
                <p>If the return is due to our error (wrong or faulty item), we cover return shipping costs. For change-of-mind returns, the customer is responsible for return shipping.</p>
            </div>
        </div>
    </section>

@endsection