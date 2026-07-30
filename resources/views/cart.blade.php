@extends('layouts.app')

@section('title', 'Your Cart — Quality Gadgets Hub')

@section('content')

    <section class="section" style="padding-bottom:0;">
        <div class="wrap">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Cart</span>
            </nav>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <h2>Your Cart</h2>
                    <div class="sub">{{ $items->sum('quantity') }} {{ \Illuminate\Support\Str::plural('item', $items->sum('quantity')) }}</div>
                </div>
            </div>

            @if($items->isEmpty())
                <div class="empty-state">
                    <p>Your cart is empty.</p>
                    <a href="{{ route('home') }}#grid" class="btn btn-primary" style="margin-top:16px;display:inline-flex;">Start shopping</a>
                </div>
            @else
                <div class="cart-layout">
                    <div class="cart-items">
                        @foreach($items as $item)
                            <div class="cart-row" data-price="{{ $item->product->price }}">
                                <a href="{{ route('product.show', $item->product) }}" class="cart-row-thumb">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" loading="lazy">
                                </a>

                                <div class="cart-row-info">
                                    <a href="{{ route('product.show', $item->product) }}" class="cart-row-title">{{ $item->product->name }}</a>
                                    @if($item->color)
                                        <div class="cart-row-color">Color: {{ $item->color }}</div>
                                    @endif
                                    <div class="cart-row-price mono">&#8358;{{ number_format($item->product->price) }}</div>
                                </div>

                                <form action="{{ route('cart.update', $item->key) }}" method="POST" class="cart-row-qty">
                                    @csrf
                                    @method('PATCH')
                                    <div class="qty-stepper qty-stepper--sm">
                                        <button type="button" class="qty-btn cart-qty-minus" aria-label="Decrease quantity">&minus;</button>
                                        <input type="number" name="quantity" class="cart-qty-input" value="{{ $item->quantity }}" min="0" inputmode="numeric">
                                        <button type="button" class="qty-btn cart-qty-plus" aria-label="Increase quantity">+</button>
                                    </div>
                                    <button type="submit" class="cart-update-btn">Update</button>
                                </form>

                                <div class="cart-row-subtotal mono" id="rowSubtotal-{{ $item->key }}">&#8358;{{ number_format($item->subtotal) }}</div>

                                <form action="{{ route('cart.remove', $item->key) }}" method="POST" class="cart-row-remove">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Remove {{ $item->product->name }} from cart">
                                        <x-icon name="close" :size="16" />
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <aside class="cart-summary">
                        <h3>Order Summary</h3>
                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span class="mono" id="cartSubtotal">&#8358;{{ number_format($subtotal) }}</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Delivery</span>
                            <span>Calculated at checkout</span>
                        </div>
                        <div class="cart-summary-row cart-summary-total">
                            <span>Total</span>
                            <span class="mono" id="cartTotal">&#8358;{{ number_format($subtotal) }}</span>
                        </div>
                        <a href="{{ route('checkout.show') }}" class="btn btn-primary cart-checkout-btn">Proceed to Checkout</a>
                        <a href="{{ route('home') }}#grid" class="cart-continue-link">&larr; Continue shopping</a>
                    </aside>
                </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    function currency(n) {
        return '₦' + n.toLocaleString('en-NG');
    }

    function recalcTotals() {
        let total = 0;
        document.querySelectorAll('.cart-row').forEach(row => {
            const price = parseInt(row.dataset.price, 10);
            const qty = parseInt(row.querySelector('.cart-qty-input').value || 0, 10);
            total += price * qty;
        });
        document.getElementById('cartSubtotal').textContent = currency(total);
        document.getElementById('cartTotal').textContent = currency(total);
    }

    document.querySelectorAll('.cart-row-qty').forEach(form => {
        const row = form.closest('.cart-row');
        const price = parseInt(row.dataset.price, 10);
        const input = form.querySelector('.cart-qty-input');
        const minus = form.querySelector('.cart-qty-minus');
        const plus = form.querySelector('.cart-qty-plus');
        const rowSubtotal = row.querySelector('[id^="rowSubtotal-"]');

        function updateRow() {
            const qty = parseInt(input.value || 0, 10);
            rowSubtotal.textContent = currency(price * qty);
            recalcTotals();
        }

        minus.addEventListener('click', () => {
            input.value = Math.max(parseInt(input.value || 0, 10) - 1, 0);
            updateRow();
        });
        plus.addEventListener('click', () => {
            input.value = parseInt(input.value || 0, 10) + 1;
            updateRow();
        });
        input.addEventListener('input', updateRow);
    });
});
</script>
@endpush