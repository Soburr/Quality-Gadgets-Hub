@extends('layouts.app')

@section('title', 'Checkout — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <a href="{{ route('cart.show') }}">Cart</a>
                <span class="sep">/</span>
                <span class="current">Checkout</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div><h2>Checkout</h2><div class="sub">{{ $items->sum('quantity') }} {{ \Illuminate\Support\Str::plural('item', $items->sum('quantity')) }} in your order</div></div>
            </div>

            @if($errors->any())
                <div class="auth-error" style="margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" class="cart-layout">
                @csrf

                <div class="checkout-form">
                    <div class="checkout-block">
                        <h3>Shipping details</h3>
                        <div class="auth-field">
                            <label for="shipping_name">Full name</label>
                            <input type="text" id="shipping_name" name="shipping_name" value="{{ old('shipping_name', $user->name) }}" required>
                        </div>
                        <div class="auth-field">
                            <label for="shipping_phone">Phone number</label>
                            <input type="text" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                        </div>
                        <div class="auth-field">
                            <label for="shipping_address">Delivery address</label>
                            <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                        </div>
                        <div class="checkout-field-row">
                            <div class="auth-field">
                                <label for="shipping_city">City / Area</label>
                                <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                            </div>
                            <div class="auth-field">
                                <label for="shipping_state">State</label>
                                <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state', 'Lagos') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <h3>Delivery method</h3>
                        <div class="option-cards">
                            <label class="option-card">
                                <input type="radio" name="delivery_method" value="door" checked>
                                <span class="option-card-icon"><x-icon name="truck" :size="20" /></span>
                                <span class="option-card-body">
                                    <strong>Door Delivery</strong>
                                    <span>Delivered to your address &middot; &#8358;1,550</span>
                                </span>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="delivery_method" value="pickup">
                                <span class="option-card-icon"><x-icon name="box" :size="20" /></span>
                                <span class="option-card-body">
                                    <strong>Pickup Station</strong>
                                    <span>Collect at a station near you &middot; &#8358;750</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <h3>Payment method</h3>
                        <div class="option-cards">
                            <label class="option-card">
                                <input type="radio" name="payment_method" value="pod" checked>
                                <span class="option-card-icon"><x-icon name="truck" :size="20" /></span>
                                <span class="option-card-body"><strong>Pay on Delivery</strong><span>Cash or transfer when it arrives</span></span>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <span class="option-card-icon"><x-icon name="box" :size="20" /></span>
                                <span class="option-card-body"><strong>Bank Transfer</strong><span>Pay before dispatch</span></span>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="payment_method" value="card">
                                <span class="option-card-icon"><x-icon name="check" :size="20" /></span>
                                <span class="option-card-body"><strong>Card</strong><span>Visa, Mastercard, Verve</span></span>
                            </label>
                            <label class="option-card">
                                <input type="radio" name="payment_method" value="ussd">
                                <span class="option-card-icon"><x-icon name="chevron-down" :size="20" /></span>
                                <span class="option-card-body"><strong>USSD</strong><span>Pay from your bank app</span></span>
                            </label>
                        </div>
                        <p class="checkout-note">Card and USSD payments aren't processed live yet — your order will still be placed and marked pending.</p>
                    </div>
                </div>

                <aside class="cart-summary">
                    <h3>Order Summary</h3>
                    @foreach($items as $item)
                        <div class="cart-summary-row">
                            <span>{{ $item->product->name }} &times; {{ $item->quantity }}</span>
                            <span class="mono">&#8358;{{ number_format($item->subtotal) }}</span>
                        </div>
                    @endforeach
                    <div class="cart-summary-row" style="border-top:1px solid var(--line);padding-top:12px;margin-top:12px;">
                        <span>Subtotal</span>
                        <span class="mono">&#8358;{{ number_format($subtotal) }}</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Delivery</span>
                        <span id="deliveryFeeDisplay" class="mono">&#8358;1,550</span>
                    </div>
                    <div class="cart-summary-row cart-summary-total">
                        <span>Total</span>
                        <span class="mono" id="totalDisplay">&#8358;{{ number_format($subtotal + 1550) }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary cart-checkout-btn">Place Order</button>
                </aside>
            </form>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const subtotal = {{ $subtotal }};
    const fees = { door: 1550, pickup: 750 };
    const feeDisplay = document.getElementById('deliveryFeeDisplay');
    const totalDisplay = document.getElementById('totalDisplay');

    document.querySelectorAll('input[name="delivery_method"]').forEach(input => {
        input.addEventListener('change', () => {
            const fee = fees[input.value];
            feeDisplay.textContent = '₦' + fee.toLocaleString('en-NG');
            totalDisplay.textContent = '₦' + (subtotal + fee).toLocaleString('en-NG');
        });
    });
});
</script>
@endpush