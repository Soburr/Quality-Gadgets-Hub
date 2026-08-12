<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit()
    {
        $doorFee = Setting::get('delivery_fee_door', 1550);
        $pickupFee = Setting::get('delivery_fee_pickup', 750);
        $paymentMode = Setting::get('payment_mode', 'paystack');
        $bankAccountName = Setting::get('bank_account_name');
        $bankAccountNumber = Setting::get('bank_account_number');
        $bankName = Setting::get('bank_name');
        $whatsappNumber = Setting::get('whatsapp_number');

        return view('admin.settings.edit', compact(
            'doorFee', 'pickupFee', 'paymentMode',
            'bankAccountName', 'bankAccountNumber', 'bankName', 'whatsappNumber'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'delivery_fee_door' => 'required|integer|min:0',
            'delivery_fee_pickup' => 'required|integer|min:0',
            'payment_mode' => 'required|in:paystack,bank_transfer',
            'bank_account_name' => 'required_if:payment_mode,bank_transfer|nullable|string|max:255',
            'bank_account_number' => 'required_if:payment_mode,bank_transfer|nullable|string|max:20',
            'bank_name' => 'required_if:payment_mode,bank_transfer|nullable|string|max:255',
            'whatsapp_number' => 'required_if:payment_mode,bank_transfer|nullable|string|max:20',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('status', 'Settings updated.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.'])->withInput();
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return back()->with('status', 'Password updated successfully.');
    }
}