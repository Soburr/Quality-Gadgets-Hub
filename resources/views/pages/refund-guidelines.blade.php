@extends('layouts.app')

@section('title', 'Refund & Replacement Guidelines — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Refund &amp; Replacement Guidelines</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Refund &amp; Replacement Guidelines</h2></div>
            </div>

            <div class="legal-page">
                <p>In the unlikely event that you receive an incorrect, damaged, faulty, or incomplete item, we will promptly address the issue to ensure customer satisfaction.</p>

                <ul>
                    <li>Enjoy a 6&ndash;12 months manufacturer's warranty on new items.</li>
                    <li>Benefit from a 2-week warranty on pre-owned items.</li>
                </ul>

                <p>Please note: The warranty does not extend to damages caused by physical impact, water exposure, or self-inflicted harm.</p>

                <h2>Eligibility For Replacement</h2>
                <p>Items are eligible for return only when we verify that it is defective or incomplete. This must be reported within 24 hours of delivery and must be returned within 10 days of purchase.</p>
            </div>
        </div>
    </section>

@endsection