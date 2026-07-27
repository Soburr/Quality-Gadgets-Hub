<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $doorFee = Setting::get('delivery_fee_door', 1550);
        $pickupFee = Setting::get('delivery_fee_pickup', 750);

        return view('admin.settings.edit', compact('doorFee', 'pickupFee'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'delivery_fee_door' => 'required|integer|min:0',
            'delivery_fee_pickup' => 'required|integer|min:0',
        ]);

        Setting::set('delivery_fee_door', $validated['delivery_fee_door']);
        Setting::set('delivery_fee_pickup', $validated['delivery_fee_pickup']);

        return back()->with('status', 'Delivery fees updated.');
    }
}