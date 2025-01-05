<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandCategoryRelationSeeder extends Seeder
{
    public function run()
    {
        // Defining relationships according to the provided table
        $relationships = [
            'Processors' => ['Intel', 'AMD', 'Nvidia', 'Other'],
            'Motherboards' => ['ASUS', 'GIGABYTE', 'MSI', 'EVGA', 'Other'],
            'Graphics Card' => ['Nvidia', 'AMD', 'Intel', 'Other'],
            'RAMs' => ['Corsair', 'Crucial', 'Adata', 'Kingston', 'G.Skill', 'Samsung', 'XPG', 'OLOY', 'Lezar', 'PNY', 'T-Force', 'V-Color', 'Other'],
            'Storage' => ['ADATA', 'Corsair', 'Crucial', 'Ease', 'GIGABYTE', 'Kingston', 'Lexar', 'Netac', 'PNY', 'Samsung', 'Western Digital', 'Seagate', 'Other'],
            'Cooling' => ['LianLi', 'Darkflash', 'Corsair', 'DeepCool', 'Cooler Master', 'NZXT', 'Antec', 'Redragon', 'Sapphire', 'ID-Cooling', 'XIGMATEK', 'Alseye', 'Thermaltake', 'XPG', 'Other'],
            'PSU' => ['ASUS', 'Corsair', 'ThermalTake', 'XPG', 'Gigabyte', 'LianLi', 'MSI', 'XIGMATEK', 'Gamdias', 'Darkflash', 'Redragon', 'EVGA', 'NZXT', 'Cooler Master', 'Other'],
            'Monitors' => ['ASUS', 'GIGABYTE', 'MSI', 'SAMSUNG', 'HP', 'DELL', 'Phillips', 'ViewSonic', 'Acer', 'LG', 'AOC', 'BENQ', 'EASE', 'Lenovo', 'Other'],
            'Cases' => ['Corsair', 'ASUS', 'LianLi', 'DarkFlash', 'GameMax', '1st Player', 'Other'],
            'Mouse' => ['1st Player', 'Apple', 'Arozzi', 'Asus', 'Corsair', 'EASE', 'Finalmouse', 'Gamdias', 'Glorious', 'Havit', 'Logitech', 'Razer', 'Redragon', 'Steelseries', 'Other'],
            'Keyboards' => ['1st Player', 'Apple', 'Asus', 'Aukey', 'Corsair', 'DarkFlash', 'Ease', 'Gamdias', 'Glorious', 'Logitech', 'Razer', 'Redragon', 'Skyloong', 'SteelSeries', 'Other'],
            'Headphone' => ['1st Player', 'Apple', 'Asus', 'Aukey', 'Corsair', 'DarkFlash', 'Ease', 'Gamdias', 'Glorious', 'Logitech', 'Razer', 'Redragon', 'Skyloong', 'SteelSeries', 'Other'],
            'Consoles' => ['Sony PlayStation', 'Microsoft Xbox', 'Nintendo', 'Other'],
        ];

        foreach ($relationships as $categoryName => $brandNames) {
            $categoryId = DB::table('categories')->where('name', $categoryName)->value('id');

            if (!$categoryId) {
                Log::error("Category '$categoryName' not found. Skipping...");
                continue;
            }

            foreach ($brandNames as $brandName) {
                $brandId = DB::table('brands')->where('name', $brandName)->value('id');

                if (!$brandId) {
                    Log::error("Brand '$brandName' not found for category '$categoryName'. Skipping...");
                    continue;
                }

                // Avoid duplicate relationships
                $exists = DB::table('brand_category')->where([
                    ['brand_id', '=', $brandId],
                    ['category_id', '=', $categoryId]
                ])->exists();

                if (!$exists) {
                    DB::table('brand_category')->insert([
                        'brand_id' => $brandId,
                        'category_id' => $categoryId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
