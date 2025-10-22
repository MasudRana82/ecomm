<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Honey',
                'description' => 'Pure and organic honey from natural sources',
                'is_active' => true
            ],
            [
                'name' => 'Ghee & Butters',
                'description' => 'Pure ghee and organic butters',
                'is_active' => true
            ],
            [
                'name' => 'Oils',
                'description' => 'Cold-pressed and organic oils',
                'is_active' => true
            ],
            [
                'name' => 'Spices',
                'description' => 'Fresh and organic spices',
                'is_active' => true
            ],
            [
                'name' => 'Nuts & Seeds',
                'description' => 'Premium quality nuts and seeds',
                'is_active' => true
            ],
            [
                'name' => 'Dry Fruits',
                'description' => 'Natural and dried fruits',
                'is_active' => true
            ],
            [
                'name' => 'Sweeteners',
                'description' => 'Natural sugar alternatives',
                'is_active' => true
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'is_active' => $categoryData['is_active']
            ]);
        }
    }
}
