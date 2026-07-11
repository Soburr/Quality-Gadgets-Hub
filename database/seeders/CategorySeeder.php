<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            [
                'label' => 'Phone',
                'icon' => 'phone',
                'children' => [
                    ['label' => 'iPhone', 'children' => [
                        ['label' => 'New'],
                        ['label' => 'Premium used'],
                    ]],
                    ['label' => 'Samsung', 'children' => [
                        ['label' => 'New'],
                        ['label' => 'Premium used'],
                    ]],
                    ['label' => 'Redmi', 'children' => [
                        ['label' => 'New'],
                        ['label' => 'Premium used'],
                    ]],
                ],
            ],
            [
                'label' => 'Gadgets',
                'icon' => 'earbud',
                'children' => [
                    ['label' => 'Headphones'],
                    ['label' => 'Earbuds'],
                    ['label' => 'Speakers'],
                    ['label' => 'Smartwatch'],
                    ['label' => 'Gaming'],
                ],
            ],
            [
                'label' => 'Laptop',
                'icon' => 'tablet',
                'children' => [
                    ['label' => 'Windows PC'],
                    ['label' => 'MacBook'],
                ],
            ],
            [
                'label' => 'Accessories',
                'icon' => 'dots',
                'children' => [
                    ['label' => 'Cases'],
                    ['label' => 'Chargers'],
                    ['label' => 'Power Banks'],
                    ['label' => 'Screen Guards'],
                ],
            ],
        ];

        foreach ($tree as $i => $node) {
            $this->createNode($node, null, $i);
        }
    }

    private function createNode(array $node, ?int $parentId, int $sortOrder): void
    {
        $category = Category::updateOrCreate(
            ['slug' => Str::slug($node['label']), 'parent_id' => $parentId],
            [
                'label' => $node['label'],
                'icon' => $node['icon'] ?? '',
                'sort_order' => $sortOrder,
            ]
        );

        foreach ($node['children'] ?? [] as $i => $child) {
            $this->createNode($child, $category->id, $i);
        }
    }
}