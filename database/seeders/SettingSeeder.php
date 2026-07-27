<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('delivery_fee_door', 1550);
        Setting::set('delivery_fee_pickup', 750);
    }
}