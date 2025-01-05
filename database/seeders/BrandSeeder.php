<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'Intel', 'AMD', 'ASUS', 'GIGABYTE', 'MSI', 'EVGA', 'Nvidia',
            'Corsair', 'Crucial', 'Adata', 'Kingston', 'G.Skill', 'Samsung',
            'OLOY', 'Lezar', 'PNY', 'T-Force', 'V-Color', 'XPG', 'Ease',
            'Netac', 'Western Digital', 'Seagate', 'LianLi', 'Darkflash',
            'DeepCool', 'Cooler Master', 'NZXT', 'Antec', 'Redragon',
            'Sapphire', 'ID-Cooling', 'XIGMATEK', 'Alseye', 'Thermaltake',
            'Gamdias', 'HP', 'DELL', 'Phillips', 'ViewSonic', 'Acer', 'LG',
            'AOC', 'BENQ', 'Lenovo', 'GameMax', '1st Player', 'Apple',
            'Arozzi', 'Finalmouse', 'Glorious', 'Havit', 'Logitech', 'Razer',
            'Steelseries', 'Skyloong', 'Sony PlayStation', 'Microsoft Xbox',
            'Nintendo', 'Other',
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand,
                'image' => 'images/default.jpg',
                'slug' => strtolower(str_replace(' ', '-', $brand)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
