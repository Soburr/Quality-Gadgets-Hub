<?php

namespace Database\Seeders;

use App\Models\DeliveryFee;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DeliveryFeeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (DeliveryFee::STATES as $state) {
            DeliveryFee::updateOrCreate(
                ['state' => $state],
                ['fee' => $state === 'Lagos' ? 1550 : 3000]
            );
        }

        Setting::set('store_pickup_fee', 0);
    }
}