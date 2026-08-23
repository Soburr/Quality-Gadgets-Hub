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
            <div>
                <h2>Checkout</h2>
                <div class="sub">{{ $items->sum('quantity') }} {{ \Illuminate\Support\Str::plural('item', $items->sum('quantity')) }} in your order</div>
            </div>
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
                        <div class="checkout-field-row">
                            <div class="auth-field">
                                <label for="shipping_state">State</label>
                                <select id="shipping_state" name="shipping_state" required>
                                    <option value="">Select your state</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" @selected(old('shipping_state') === $state)>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="auth-field">
                                <label for="shipping_city">City / Area</label>
                                <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                            </div>
                        </div>
                        <div class="auth-field">
                            <label for="shipping_address">Delivery address</label>
                            <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <h3>Shipment Option</h3>
                        <div class="option-cards">
                            <label class="option-card" id="storePickupCard">
                                <input type="radio" name="delivery_method" value="store_pickup" id="storePickupOption" disabled>
                                <span class="option-card-icon"><x-icon name="box" :size="20" /></span>
                                <span class="option-card-body">
                                    <strong>Store Pickup</strong>
                                    <span id="storePickupHint">Available for Lagos only</span>
                                </span>
                            </label>

                            <label class="option-card">
                                <input type="radio" name="delivery_method" value="delivery" id="deliveryOption" checked>
                                <span class="option-card-icon"><x-icon name="truck" :size="20" /></span>
                                <span class="option-card-body">
                                    <strong id="deliveryMethodLabel">Delivery</strong>
                                    <span id="deliveryMethodFeeLabel">Select your state above to see the price</span>
                                </span>
                            </label>

                            <div class="admin-field" id="pickupLocationWrap" style="display:none;">
                                <label for="pickup_location_id">Delivery area (Lagos)</label>
                                <select id="pickup_location_id" name="pickup_location_id">
                                    <option value="">Select your area</option>
                                    @foreach($lagosAreas as $area)
                                        <option value="{{ $area->id }}" data-fee="{{ $area->fee }}" @selected(old('pickup_location_id') == $area->id)>
                                            {{ $area->name }} &mdash; &#8358;{{ number_format($area->fee) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="option-card" id="courierCard">
                                <input type="radio" name="delivery_method" value="courier" id="courierOption" disabled>
                                <span class="option-card-icon"><x-icon name="truck" :size="20" /></span>
                                <span class="option-card-body">
                                    <strong>Courier Delivery</strong>
                                    <span id="courierHint">Select your state above to see the price</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="checkout-block">
                        <h3>Payment method</h3>
                        <div class="option-cards">
                            <label class="option-card">
                                <input type="radio" name="payment_method" value="pay_now" checked>
                                <span class="option-card-icon"><x-icon name="check" :size="20" /></span>
                                @if($paymentMode === 'paystack')
                                    <span class="option-card-body"><strong>Pay Now</strong><span>Card, bank transfer, or USSD via Paystack</span></span>
                                @else
                                    <span class="option-card-body"><strong>Pay Now</strong><span>Bank transfer with instant confirmation</span></span>
                                @endif
                            </label>
                        </div>
                        @if($paymentMode === 'paystack')
                            <p class="checkout-note">You'll be taken straight to Paystack's secure checkout to complete payment.</p>
                        @else
                            <p class="checkout-note">You'll see our bank transfer details next — your order is confirmed once you notify us on WhatsApp.</p>
                        @endif
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
                        <span id="deliveryFeeDisplay" class="mono">Select your state</span>
                    </div>
                    <div class="cart-summary-total">
                        <span>Total</span>
                        <span class="mono" id="totalDisplay">&#8358;{{ number_format($subtotal) }}</span>
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
    const stateFees = @json($stateFees);
    const courierFees = @json(\App\Models\DeliveryFee::pluck('courier_fee', 'state'));

    const stateSelect = document.getElementById('shipping_state');
    const deliveryOption = document.getElementById('deliveryOption');
    const storePickupOption = document.getElementById('storePickupOption');
    const storePickupCard = document.getElementById('storePickupCard');
    const storePickupHint = document.getElementById('storePickupHint');
    const courierOption = document.getElementById('courierOption');
    const courierCard = document.getElementById('courierCard');
    const courierHint = document.getElementById('courierHint');
    const pickupLocationWrap = document.getElementById('pickupLocationWrap');
    const pickupLocationSelect = document.getElementById('pickup_location_id');
    const deliveryMethodLabel = document.getElementById('deliveryMethodLabel');
    const deliveryMethodFeeLabel = document.getElementById('deliveryMethodFeeLabel');
    const feeDisplay = document.getElementById('deliveryFeeDisplay');
    const totalDisplay = document.getElementById('totalDisplay');

    function isLagos() {
        return stateSelect.value === 'Lagos';
    }

    function selectedAreaFee() {
        const option = pickupLocationSelect.options[pickupLocationSelect.selectedIndex];
        return option && option.dataset.fee ? parseInt(option.dataset.fee, 10) : null;
    }

    function courierFeeForState() {
        const state = stateSelect.value;
        if (!state || !stateFees.hasOwnProperty(state)) return null;
        return stateFees[state] + (courierFees[state] || 0);
    }

    function updateAvailability() {
        const lagos = isLagos();

        storePickupOption.disabled = !lagos;
        storePickupCard.classList.toggle('option-card--disabled', !lagos);
        storePickupHint.textContent = lagos ? 'Collect at our store · Free' : 'Available for Lagos only';
        if (!lagos && storePickupOption.checked) deliveryOption.checked = true;

        courierOption.disabled = lagos || !stateSelect.value;
        courierCard.classList.toggle('option-card--disabled', lagos || !stateSelect.value);
        courierHint.textContent = lagos
            ? 'Not needed — use Doorstep Delivery for Lagos'
            : (stateSelect.value ? '₦' + courierFeeForState().toLocaleString('en-NG') : 'Select your state above to see the price');
        if (lagos && courierOption.checked) deliveryOption.checked = true;

        const showArea = deliveryOption.checked && lagos;
        pickupLocationWrap.style.display = showArea ? 'block' : 'none';
        pickupLocationSelect.required = showArea;
    }

    function currentDeliveryFee() {
        if (storePickupOption.checked) return 0;
        if (courierOption.checked) return courierFeeForState();
        if (isLagos()) return selectedAreaFee();
        const state = stateSelect.value;
        return state && stateFees.hasOwnProperty(state) ? stateFees[state] : null;
    }

    function recalc() {
        updateAvailability();

        const fee = currentDeliveryFee();

        if (deliveryOption.checked) {
            const state = stateSelect.value;
            if (isLagos()) {
                deliveryMethodLabel.textContent = 'Doorstep Delivery';
                deliveryMethodFeeLabel.textContent = fee !== null
                    ? '₦' + fee.toLocaleString('en-NG')
                    : 'Select your delivery area below';
            } else {
                deliveryMethodLabel.textContent = state ? 'Park Pickup' : 'Delivery';
                deliveryMethodFeeLabel.textContent = state
                    ? '₦' + fee.toLocaleString('en-NG')
                    : 'Select your state above to see the price';
            }
        }

        if (storePickupOption.checked) {
            feeDisplay.textContent = 'Free';
            totalDisplay.textContent = '₦' + subtotal.toLocaleString('en-NG');
        } else if (fee === null) {
            feeDisplay.textContent = isLagos() ? 'Select your delivery area' : 'Select your state';
            totalDisplay.textContent = '₦' + subtotal.toLocaleString('en-NG');
        } else {
            feeDisplay.textContent = '₦' + fee.toLocaleString('en-NG');
            totalDisplay.textContent = '₦' + (subtotal + fee).toLocaleString('en-NG');
        }
    }

    stateSelect.addEventListener('change', recalc);
    deliveryOption.addEventListener('change', recalc);
    storePickupOption.addEventListener('change', recalc);
    courierOption.addEventListener('change', recalc);
    pickupLocationSelect.addEventListener('change', recalc);

    recalc();
});
</script>
@endpush