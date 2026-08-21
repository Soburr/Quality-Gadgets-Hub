<?php

namespace Database\Seeders;

use App\Models\PickupLocation;
use Illuminate\Database\Seeder;

class PickupLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Abule Egba', 'fee' => 1000],
            ['name' => 'Iyana Ipaja', 'fee' => 1000],
            ['name' => 'Command', 'fee' => 1200],
        ];

        foreach ($locations as $i => $location) {
            PickupLocation::updateOrCreate(
                ['name' => $location['name']],
                ['fee' => $location['fee'], 'sort_order' => $i]
            );
        }
    }
}