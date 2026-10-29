@extends('layouts.app')

@section('title', 'Complete Payment — Quality Gadgets Hub')

@section('content')

    <section class="section">
        <div class="wrap" style="max-width:520px;">
            <div class="bank-transfer-card">
                <div class="bank-transfer-head">
                    <h2>Payment Details</h2>
                    <p class="sub">Transfer into the account below</p>
                </div>

                <div class="bank-transfer-rows">
                    <div class="bank-transfer-row">
                        <span>Account Name</span>
                        <strong>{{ $accountName }}</strong>
                    </div>
                    <div class="bank-transfer-row">
                        <span>Account Number</span>
                        <strong class="mono" id="accountNumberValue">{{ $accountNumber }}</strong>
                        <button type="button" id="copyAccountNumber" class="bank-transfer-copy" aria-label="Copy account number">
                            <x-icon name="box" :size="14" />
                        </button>
                    </div>
                    <div class="bank-transfer-row">
                        <span>Bank</span>
                        <strong>{{ $bankName }}</strong>
                    </div>
                    <div class="bank-transfer-row bank-transfer-row--amount">
                        <span>Amount</span>
                        <strong class="mono">&#8358;{{ number_format($order->total, 2) }}</strong>
                    </div>
                </div>

                <form action="{{ route('checkout.paymentMade', $order) }}" method="POST" target="_blank" id="paymentMadeForm">
                    @csrf
                    <button type="submit" class="btn btn-primary bank-transfer-whatsapp">
                        I have made the payment
                    </button>
                </form>

                <p class="bank-transfer-note">Tapping the button emails you a confirmation and opens WhatsApp with a pre-filled message. Send it and we'll verify your payment shortly.</p>            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('copyAccountNumber');
    const accountNumber = document.getElementById('accountNumberValue');

    copyBtn?.addEventListener('click', () => {
        navigator.clipboard.writeText(accountNumber.textContent.trim()).then(() => {
            const original = copyBtn.innerHTML;
            copyBtn.textContent = 'Copied';
            setTimeout(() => { copyBtn.innerHTML = original; }, 1500);
        });
    });

    document.getElementById('paymentMadeForm')?.addEventListener('submit', () => {
        setTimeout(() => { window.location.href = '{{ route('order.show', $order) }}'; }, 1200);
    });
});
</script>
@endpush