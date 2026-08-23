<?php

namespace Database\Seeders;

use App\Models\DeliveryFee;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DeliveryFeeSeeder extends Seeder
{
    private const REDUCED_COURIER_STATES = ['Kwara', 'Ogun', 'Oyo', 'Osun', 'Ondo', 'Ekiti'];

    public function run(): void
    {
        foreach (DeliveryFee::STATES as $state) {
            $courierFee = match (true) {
                $state === 'Lagos' => 0,
                in_array($state, self::REDUCED_COURIER_STATES, true) => 3000,
                default => 4000,
            };

            DeliveryFee::updateOrCreate(
                ['state' => $state],
                [
                    'fee' => DeliveryFee::where('state', $state)->value('fee') ?? ($state === 'Lagos' ? 1550 : 3000),
                    'courier_fee' => $courierFee,
                ]
            );
        }

        Setting::set('store_pickup_fee', 0);
    }
}