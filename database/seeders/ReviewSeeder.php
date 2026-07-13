<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Chidinma', 'Emeka', 'Aisha', 'Tunde', 'Ngozi', 'Ibrahim', 'Blessing', 'Kelechi', 'Fatima', 'Segun', 'Chioma', 'Yusuf', 'Amara', 'Femi', 'Halima', 'Uche'];

        $templates = [
            5 => [
                ['title' => 'Exactly as described', 'comment' => 'Product arrived in perfect condition and works great. Delivery was faster than expected too.'],
                ['title' => 'Very happy with this',  'comment' => 'Original product, well packaged. Would buy from this store again.'],
                ['title' => 'No complaints',          'comment' => 'Been using it for two weeks now and everything works fine. Good value for money.'],
            ],
            4 => [
                ['title' => 'Good product', 'comment' => 'Does what it says. Packaging could be better but the item itself is solid.'],
                ['title' => 'Satisfied',    'comment' => 'Took a couple of days longer than expected to arrive but the product is genuine.'],
            ],
            3 => [
                ['title' => 'It is okay', 'comment' => 'Product is fine, nothing special. Matches the description on the page.'],
            ],
        ];

        Product::all()->each(function ($product) use ($names, $templates) {
            $reviewCount = rand(3, 6);

            for ($i = 0; $i < $reviewCount; $i++) {
                $rating = collect([5, 5, 5, 4, 4, 3])->random();
                $template = collect($templates[$rating])->random();

                Review::create([
                    'product_id'    => $product->id,
                    'reviewer_name' => $names[array_rand($names)],
                    'rating'        => $rating,
                    'title'         => $template['title'],
                    'comment'       => $template['comment'],
                    'is_verified'   => true,
                    'created_at'    => now()->subDays(rand(1, 90)),
                ]);
            }
        });
    }
}