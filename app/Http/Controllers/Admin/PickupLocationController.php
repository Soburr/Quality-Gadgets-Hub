<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupLocation;
use Illuminate\Http\Request;

class PickupLocationController extends Controller
{
    public function index()
    {
        $locations = PickupLocation::orderBy('sort_order')->get();

        return view('admin.pickup-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.pickup-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        PickupLocation::create($validated);

        return redirect()->route('admin.pickup-locations.index')->with('status', 'Pickup location added.');
    }

    public function edit(PickupLocation $pickupLocation)
    {
        return view('admin.pickup-locations.edit', ['location' => $pickupLocation]);
    }

    public function update(Request $request, PickupLocation $pickupLocation)
    {
        $pickupLocation->update($this->validated($request));

        return redirect()->route('admin.pickup-locations.index')->with('status', 'Pickup location updated.');
    }

    public function destroy(PickupLocation $pickupLocation)
    {
        $pickupLocation->delete();

        return back()->with('status', 'Pickup location deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}