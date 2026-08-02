@extends('admin.layout')

@section('title', 'Settings — Admin')

@section('content')
    <div class="admin-header">
        <h1>Settings</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="auth-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="admin-panel" style="margin-bottom:24px;">
            <h3>Delivery Fees</h3>
            <div class="admin-field-row" style="max-width:500px;">
                <div class="admin-field">
                    <label for="delivery_fee_door">Door delivery fee (&#8358;)</label>
                    <input type="number" id="delivery_fee_door" name="delivery_fee_door" value="{{ old('delivery_fee_door', $doorFee) }}" required min="0">
                </div>
                <div class="admin-field">
                    <label for="delivery_fee_pickup">Pickup station fee (&#8358;)</label>
                    <input type="number" id="delivery_fee_pickup" name="delivery_fee_pickup" value="{{ old('delivery_fee_pickup', $pickupFee) }}" required min="0">
                </div>
            </div>
        </div>

        <div class="admin-panel" style="margin-bottom:24px;">
            <h3>Online Payment</h3>
            <p class="admin-hint" style="margin-bottom:16px;">
                Controls what "Pay Now" does at checkout. Switch to Paystack once the account is fully set up — no code changes needed, just save this form.
            </p>

            <div class="option-cards" style="max-width:600px;margin-bottom:20px;">
                <label class="option-card">
                    <input type="radio" name="payment_mode" value="bank_transfer" id="modeBankTransfer" @checked(old('payment_mode', $paymentMode) === 'bank_transfer')>
                    <span class="option-card-icon"><x-icon name="box" :size="20" /></span>
                    <span class="option-card-body"><strong>Bank Transfer</strong><span>Shows account details + WhatsApp confirmation</span></span>
                </label>
                <label class="option-card">
                    <input type="radio" name="payment_mode" value="paystack" id="modePaystack" @checked(old('payment_mode', $paymentMode) === 'paystack')>
                    <span class="option-card-icon"><x-icon name="check" :size="20" /></span>
                    <span class="option-card-body"><strong>Paystack</strong><span>Real card / USSD / transfer via Paystack</span></span>
                </label>
            </div>

            <div id="bankTransferFields">
                <div class="admin-field-row" style="max-width:600px;">
                    <div class="admin-field">
                        <label for="bank_account_name">Account name</label>
                        <input type="text" id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name', $bankAccountName) }}">
                    </div>
                    <div class="admin-field">
                        <label for="bank_account_number">Account number</label>
                        <input type="text" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $bankAccountNumber) }}">
                    </div>
                </div>
                <div class="admin-field-row" style="max-width:600px;">
                    <div class="admin-field">
                        <label for="bank_name">Bank name</label>
                        <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankName) }}">
                    </div>
                    <div class="admin-field">
                        <label for="whatsapp_number">WhatsApp number (with country code, no + or spaces)</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsappNumber) }}" placeholder="2348169698791">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var bankFields = document.getElementById('bankTransferFields');
    var bankRadio = document.getElementById('modeBankTransfer');
    var paystackRadio = document.getElementById('modePaystack');

    function toggleBankFields() {
        bankFields.style.display = bankRadio.checked ? 'block' : 'none';
    }

    bankRadio.addEventListener('change', toggleBankFields);
    paystackRadio.addEventListener('change', toggleBankFields);
    toggleBankFields();
});
</script>
@endpush