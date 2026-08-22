<?php

namespace Database\Seeders;

use App\Models\PickupLocation;
use Illuminate\Database\Seeder;

class PickupLocationSeeder extends Seeder
{
    public function run(): void
    {
        PickupLocation::query()->delete();

        $tiers = [
            3000 => ['Ikeja', 'Ojota', 'Maryland', 'MM1 & MM2 Airport', 'Ogba', 'Oshodi', 'Agege', 'Ketu', 'Mile 12', 'Iyana Ipaja'],
            4000 => ['Omole', 'Magodo', 'Berger', 'Ajao Estate', 'Ogudu', 'Fagba', 'Idimu', 'Egbeda', 'Abule Egba', 'Meiran', 'Isolo', 'Jakande'],
            5000 => ['Gbagada', 'Ilupeju', 'Mushin', 'Surulere', 'Yaba', 'Ebute Metta'],
            6000 => ['Marina', 'VI', 'Ikoyi', 'Obalende', 'Oyinbo', 'Igando', 'Ikotun', 'Ijaye', 'Alakuko', 'Alagbodo', 'Costain'],
            7000 => ['Lagos Island' , 'Idumota', 'Igbo Efon', 'Ikate', 'Lekki Phase 1', 'Ajegunle', 'Apapa', 'Chevron', 'Eleganza', 'Oke Afa'],
            8000 => ['Ago Palace', 'Festac', 'Mile 2', 'Ikorodu', 'Odongunyan', 'Majidun', 'Owode Onirin', 'VGC'],
            9000 => ['Akute', 'Opic', 'Iyana School', 'Lasu', 'Iba', 'Maza Maza', 'Abule Ado', 'Ajah', 'Okokomaiko', 'Iyana Isashi', 'Ojoo', 'Iyana Era', 'Ijede', 'Irete', 'Parafa'],
            10000 => ['Arepo', 'Ajangbadi', 'Sangotedo', 'Badore', 'Langbasa', 'Ogombo', 'Abijo', 'Alaba', 'Imota'],
            11000 => ['Mowe', 'Toll Gate', 'Ibeju Lekki', 'Agbowa'],
            12000 => ['Sango Under Bridge', 'Lakowe', 'Eleko', 'Awoyaya', 'Agbara'],
        ];

        $sortOrder = 0;

        foreach ($tiers as $fee => $locations) {
            foreach ($locations as $name) {
                PickupLocation::create([
                    'name' => $name,
                    'fee' => $fee,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }
}