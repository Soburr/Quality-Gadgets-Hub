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

    <!-- <div class="admin-panel" style="margin-bottom:24px;">
        <h3>Delivery Fees</h3>
        <div class="admin-field-row" style="max-width:500px;">
            <div class="admin-field">
                <label for="delivery_fee_door">Doorstep delivery fee (&#8358;)</label>
                <input type="number" id="delivery_fee_door" name="delivery_fee_door" value="{{ old('delivery_fee_door', $doorFee) }}" required min="0">
            </div>
            <div class="admin-field">
                <label for="delivery_fee_pickup">Pickup station fee (&#8358;)</label>
                <input type="number" id="delivery_fee_pickup" name="delivery_fee_pickup" value="{{ old('delivery_fee_pickup', $pickupFee) }}" required min="0">
            </div>
        </div>
    </div> -->

    <div class="admin-panel" style="margin-bottom:24px;">
        <h3>Online Payment</h3>
        <p class="admin-hint" style="margin-bottom:16px;">
            Controls what "Pay Now" does at checkout. Switch to Paystack once the account is fully set up — no code changes needed, just save this form.
        </p>

        <div class="option-cards" style="max-width:600px;margin-bottom:20px;">
            <label class="option-card">
                <input type="radio" name="payment_mode" value="bank_transfer" id="modeBankTransfer" @checked(old('payment_mode', $paymentMode)==='bank_transfer' )>
                <span class="option-card-icon"><x-icon name="box" :size="20" /></span>
                <span class="option-card-body"><strong>Bank Transfer</strong><span>Shows account details + WhatsApp confirmation</span></span>
            </label>
            <label class="option-card">
                <input type="radio" name="payment_mode" value="paystack" id="modePaystack" @checked(old('payment_mode', $paymentMode)==='paystack' )>
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
                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsappNumber) }}" placeholder="2347049486290">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Settings</button>
</form>

<div class="admin-panel" style="margin-top:24px;max-width:500px;">
    <h3>Change Password</h3>

    @if($errors->any())
    <div class="auth-error" style="margin-bottom:16px;">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('admin.settings.updatePassword') }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')

        <div class="admin-field">
            <label for="current_password">Current password</label>
            <div class="auth-password-wrap">
                <input type="password" id="current_password" name="current_password" required>
                <button type="button" class="auth-password-toggle" data-target="current_password" aria-label="Show password">
                    <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg class="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none;">
                        <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a20.3 20.3 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 7 11 7a20.29 20.29 0 01-3.22 4.31M14.12 14.12a3 3 0 11-4.24-4.24" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 1l22 22" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="admin-field">
            <label for="password">New password</label>
            <div class="auth-password-wrap">
                <input type="password" id="password" name="password" required minlength="8">
                <button type="button" class="auth-password-toggle" data-target="password" aria-label="Show password">
                    <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg class="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none;">
                        <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a20.3 20.3 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 7 11 7a20.29 20.29 0 01-3.22 4.31M14.12 14.12a3 3 0 11-4.24-4.24" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 1l22 22" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <p class="admin-hint">At least 8 characters.</p>
        </div>

        <div class="admin-field">
            <label for="password_confirmation">Confirm new password</label>
            <div class="auth-password-wrap">
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
                <button type="button" class="auth-password-toggle" data-target="password_confirmation" aria-label="Show password">
                    <svg class="icon-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg class="icon-eye-off" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none;">
                        <path d="M17.94 17.94A10.94 10.94 0 0112 19c-7 0-11-7-11-7a20.3 20.3 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 7 11 7a20.29 20.29 0 01-3.22 4.31M14.12 14.12a3 3 0 11-4.24-4.24" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 1l22 22" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:8px;">Update Password</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.auth-password-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const eyeIcon = btn.querySelector('.icon-eye');
                const eyeOffIcon = btn.querySelector('.icon-eye-off');
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';
                eyeIcon.style.display = isHidden ? 'none' : 'block';
                eyeOffIcon.style.display = isHidden ? 'block' : 'none';
                btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        });
    });
</script>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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