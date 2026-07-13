<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category' => ['Phone', 'iPhone', 'New'],           'name' => 'iPhone 15 · 128GB',                    'price' => 890000, 'was_price' => null,   'rating' => 4.8, 'reviews_count' => 540,  'badge' => 'New'],
            ['category' => ['Phone', 'iPhone', 'New'],           'name' => 'iPhone 14 Pro Max · 256GB',            'price' => 950000, 'was_price' => 1050000,'rating' => 4.9, 'reviews_count' => 1820, 'badge' => '-10%'],
            ['category' => ['Phone', 'iPhone', 'Premium used'],  'name' => 'iPhone 13 · 128GB (UK Used)',          'price' => 420000, 'was_price' => 480000, 'rating' => 4.6, 'reviews_count' => 1340, 'badge' => '-13%'],
            ['category' => ['Phone', 'iPhone', 'Premium used'],  'name' => 'iPhone 11 · 64GB (UK Used)',           'price' => 265000, 'was_price' => null,   'rating' => 4.3, 'reviews_count' => 980,  'badge' => 'Verified'],
            ['category' => ['Phone', 'Samsung', 'New'],          'name' => 'Samsung Galaxy S23 Ultra · 256GB',     'price' => 780000, 'was_price' => 860000, 'rating' => 4.8, 'reviews_count' => 1120, 'badge' => '-9%'],
            ['category' => ['Phone', 'Samsung', 'New'],          'name' => 'Samsung Galaxy A54 5G · 128GB',        'price' => 285000, 'was_price' => 319000, 'rating' => 4.5, 'reviews_count' => 2210, 'badge' => '-11%'],
            ['category' => ['Phone', 'Samsung', 'New'],          'name' => 'Samsung Galaxy A14 · 64GB',            'price' => 118000, 'was_price' => null,   'rating' => 4.2, 'reviews_count' => 760,  'badge' => 'New'],
            ['category' => ['Phone', 'Samsung', 'Premium used'], 'name' => 'Samsung Galaxy Z Flip 5 · 256GB (UK Used)', 'price' => 720000, 'was_price' => 799000, 'rating' => 4.7, 'reviews_count' => 410, 'badge' => '-10%'],
            ['category' => ['Phone', 'Redmi', 'New'],            'name' => 'Redmi Note 13 Pro · 256GB',            'price' => 245000, 'was_price' => 279000, 'rating' => 4.6, 'reviews_count' => 1560, 'badge' => '-12%'],
            ['category' => ['Phone', 'Redmi', 'New'],            'name' => 'Redmi 12C · 128GB',                    'price' => 89000,  'was_price' => 99000,  'rating' => 4.1, 'reviews_count' => 890,  'badge' => '-10%'],
            ['category' => ['Phone', 'Redmi', 'Premium used'],   'name' => 'Redmi Note 12 · 128GB (UK Used)',      'price' => 165000, 'was_price' => null,   'rating' => 4.4, 'reviews_count' => 670,  'badge' => 'Verified'],
            ['category' => ['Gadgets', 'Headphones'],            'name' => 'Apple AirPods Max',                    'price' => 420000, 'was_price' => 459000, 'rating' => 4.8, 'reviews_count' => 320,  'badge' => '-8%'],
            ['category' => ['Gadgets', 'Earbuds'],               'name' => 'Apple AirPods Pro (2nd Gen)',          'price' => 165000, 'was_price' => 189000, 'rating' => 4.9, 'reviews_count' => 2040, 'badge' => '-13%'],
            ['category' => ['Gadgets', 'Earbuds'],               'name' => 'Samsung Galaxy Buds2 Pro',             'price' => 98000,  'was_price' => null,   'rating' => 4.6, 'reviews_count' => 610,  'badge' => 'Verified'],
            ['category' => ['Gadgets', 'Speakers'],              'name' => 'JBL Flip 6 Bluetooth Speaker',         'price' => 89000,  'was_price' => 99000,  'rating' => 4.7, 'reviews_count' => 780,  'badge' => '-10%'],
            ['category' => ['Gadgets', 'Smartwatch'],            'name' => 'Apple Watch Series 9 · 45mm',          'price' => 410000, 'was_price' => null,   'rating' => 4.8, 'reviews_count' => 290,  'badge' => 'New'],
            ['category' => ['Gadgets', 'Gaming'],                'name' => 'Logitech G435 Gaming Headset',         'price' => 62000,  'was_price' => 72000,  'rating' => 4.5, 'reviews_count' => 340,  'badge' => '-14%'],
            ['category' => ['Laptop', 'MacBook'],                'name' => 'MacBook Air M1 · 256GB',               'price' => 890000, 'was_price' => 950000, 'rating' => 4.9, 'reviews_count' => 340,  'badge' => '-6%'],
            ['category' => ['Laptop', 'Windows PC'],             'name' => 'HP Pavilion 15 · Core i5 · 512GB SSD', 'price' => 520000, 'was_price' => null,   'rating' => 4.4, 'reviews_count' => 210,  'badge' => 'New'],
            ['category' => ['Laptop', 'Windows PC'],             'name' => 'Lenovo ThinkPad E14 · Core i7',        'price' => 610000, 'was_price' => 690000, 'rating' => 4.6, 'reviews_count' => 190,  'badge' => '-12%'],
            ['category' => ['Accessories', 'Power Banks'],       'name' => 'Anker 20000mAh Power Bank',            'price' => 32000,  'was_price' => 38000,  'rating' => 4.5, 'reviews_count' => 1220, 'badge' => '-16%'],
            ['category' => ['Accessories', 'Chargers'],          'name' => 'Anker 20W USB-C Fast Charger',         'price' => 14500,  'was_price' => null,   'rating' => 4.3, 'reviews_count' => 640,  'badge' => 'Verified'],
            ['category' => ['Accessories', 'Cases'],             'name' => 'Spigen Clear Case (iPhone 15)',        'price' => 9800,   'was_price' => 12500,  'rating' => 4.4, 'reviews_count' => 450,  'badge' => '-22%'],
            ['category' => ['Accessories', 'Screen Guards'],     'name' => 'Tempered Glass Screen Protector',      'price' => 3500,   'was_price' => null,   'rating' => 4.2, 'reviews_count' => 980,  'badge' => 'Verified'],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id'   => $this->categoryId($p['category']),
                    'name'          => $p['name'],
                    'description'   => "Genuine {$p['name']} available at Quality Gadgets Hub. Every unit is quality-checked before shipping, backed by our 7-day return window, and ships fast within Lagos and nationwide.",
                    'price'         => $p['price'],
                    'was_price'     => $p['was_price'],
                    'rating'        => $p['rating'],
                    'reviews_count' => $p['reviews_count'],
                    'badge'         => $p['badge'],
                    'image'         => 'https://placehold.co/600x600/20141A/FFF8F6?text=QGH',
                    'colors'        => $p['category'][0] === 'Phone' ? $this->defaultColors() : null,
                    'gallery'       => $this->placeholderGallery(),
                    'stock'         => 25,
                ]
            );
        }
    }

    private function defaultColors(): array
    {
        return [
            ['name' => 'Midnight',  'hex' => '#1d1d1f'],
            ['name' => 'Starlight', 'hex' => '#f0e6d8'],
            ['name' => 'Blue',      'hex' => '#3f5b7c'],
            ['name' => 'Pink',      'hex' => '#e8c7cf'],
        ];
    }

    private function placeholderGallery(): array
    {
        return [
            'https://placehold.co/600x600/20141A/FFF8F6?text=1',
            'https://placehold.co/600x600/8C0027/FFF8F6?text=2',
            'https://placehold.co/600x600/C40356/FFF8F6?text=3',
            'https://placehold.co/600x600/20141A/FFF8F6?text=4',
        ];
    }

    /**
     * Walks a label path (e.g. ['Phone', 'iPhone', 'New']) down the category
     * tree by slug at each level, since slugs like 'new' repeat under
     * different parents and are only unique scoped to their own parent_id.
     */
    private function categoryId(array $path): int
    {
        $parentId = null;
        $category = null;

        foreach ($path as $label) {
            $category = Category::where('parent_id', $parentId)
                ->where('slug', Str::slug($label))
                ->firstOrFail();
            $parentId = $category->id;
        }

        return $category->id;
    }
}