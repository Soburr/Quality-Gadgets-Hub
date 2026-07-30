@extends('layouts.app')

@section('title', 'About Us — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">About Us</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>About Us</h2><div class="sub">Utmost Quality At All Times</div></div>
            </div>

            <div class="legal-page">
                <p>Quality Gadgets Hub was borne out of the need to solve gadgets procurement needs for businesses, creatives, students and tech professionals. We deliver quality gadgets for the populace at very good rates. Not only will you get a quality device when you patronize us, it will also be at a very good rate.</p>

                <h2>Quality Gadgets Hub</h2>
                <p>Since October 2017 when we started, our core values remains unchanged which is &ldquo;utmost quality at all times&rdquo;.</p>
                <p>Apart from physical store pick-up option, we also offer seamless nation and worldwide delivery to your location.</p>

                <h2>Delivery</h2>
                <p>Same day delivery is guaranteed within Lagos. Orders made from outside Lagos may take up to 24&ndash;48 hours.</p>
            </div>
        </div>
    </section>

@endsection