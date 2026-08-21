<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryFee;
use App\Models\Setting;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    public function edit()
    {
        $deliveryFees = DeliveryFee::orderByRaw("state = 'Lagos' desc")->orderBy('state')->get();
        $storePickupFee = (int) Setting::get('store_pickup_fee', 0);

        return view('admin.delivery-fees.edit', compact('deliveryFees', 'storePickupFee'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fees' => 'required|array',
            'fees.*' => 'required|integer|min:0',
            'store_pickup_fee' => 'required|integer|min:0',
        ]);

        foreach ($validated['fees'] as $id => $fee) {
            DeliveryFee::where('id', $id)->update(['fee' => $fee]);
        }

        Setting::set('store_pickup_fee', $validated['store_pickup_fee']);

        return back()->with('status', 'Delivery fees updated.');
    }
}