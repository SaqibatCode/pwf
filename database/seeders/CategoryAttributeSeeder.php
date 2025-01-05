<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryAttributes = [
            // For category "Monitor" (category_id => attribute_id)
            ['category_id' => 4, 'attribute_id' => 1], // Panel Type
            ['category_id' => 4, 'attribute_id' => 2], // Screen Size
            ['category_id' => 4, 'attribute_id' => 3], // Refresh Rate

        ];

        // Insert the category-attribute relationships into the database
        DB::table('category_attribute')->insert($categoryAttributes);
    }
}
