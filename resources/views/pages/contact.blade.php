@extends('layouts.app')

@section('title', 'Contact Us — Quality Gadgets Hub')

@section('content')

    @php
        $address = 'Suite 20/21, No. 10, Adepele Street, Computer Village Ikeja Lagos';
        $mapQuery = urlencode($address);
    @endphp

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Contact</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Contact</h2></div>
            </div>

            <div class="contact-map-wrap">
                <a href="https://www.google.com/maps/search/?api=1&query={{ $mapQuery }}" target="_blank" rel="noopener" class="contact-map-open">
                    Open in Maps
                </a>
                <iframe
                    src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed"
                    class="contact-map-frame"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Quality Gadgets Hub location">
                </iframe>
            </div>

            <div class="contact-details">
                <p class="contact-address"><strong>Address:</strong> {{ $address }}</p>

                <div class="contact-line">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.362 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    <span>09161273663 | 08169698791</span>
                </div>

                <div class="contact-line">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zM8 12l3 3 5-6"/></svg>
                    <span>08076460107 | 07049486290</span>
                </div>

                <div class="contact-socials">
                    <a href="https://x.com/QualityGadgets_" class="contact-social-line">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 4l16 16M20 4L4 20" stroke="currentColor" stroke-width="2"/></svg>
                        <span>@QualityGadgets_</span>
                    </a>
                    <a href="https://www.instagram.com/quality_gadgets_hub/?hl=en" class="contact-social-line">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                        <span>@quality_gadgets_hub</span>
                    </a>
                    <a href="https://web.facebook.com/qualitygadgetsng/" class="contact-social-line">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 4h-2a4 4 0 00-4 4v3H7v3h2v6h3v-6h2.5l.5-3H12V8a1 1 0 011-1h2V4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        <span>Quality Gadgets Hub</span>
                    </a>
                    <a href="https://www.tiktok.com/@quality_gadget_hub" class="contact-social-line">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M14 4v10.5a3 3 0 11-3-3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M14 4c0 2.5 2 4.5 4.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span>@quality_gadgets_hub</span>
                    </a>
                </div>

                <div class="contact-hours">
                    <h3>Opening Hours:</h3>
                    <p>Monday to Saturday &mdash; 9:00am to 6:00pm</p>
                    <p>Sunday &mdash; Closed</p>
                </div>
            </div>
        </div>
    </section>

@endsection