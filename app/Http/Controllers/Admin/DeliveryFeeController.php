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

        return view('admin.delivery-fees.edit', compact('deliveryFees'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fees' => 'required|array',
            'fees.*' => 'required|integer|min:0',
        ]);

        foreach ($validated['fees'] as $id => $fee) {
            DeliveryFee::where('id', $id)->update(['fee' => $fee]);
        }

        return back()->with('status', 'Delivery fees updated.');
    }
}