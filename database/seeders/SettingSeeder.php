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
        Setting::set('payment_mode', 'bank_transfer'); // 'paystack' or 'bank_transfer'
        Setting::set('bank_account_name', 'Quality Gadgets Hub');
        Setting::set('bank_account_number', '5401750176');
        Setting::set('bank_name', 'Providus Bank');
        Setting::set('whatsapp_number', '2348169698791');
    }
}