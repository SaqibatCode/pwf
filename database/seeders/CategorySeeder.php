<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Complete PC Build',
            'Processors',
            'Graphic Cards',
            'Monitors',
            'RAMs',
            'Motherboards',
            'Storage',
            'Cooling',
            'PSU',
            'Cases',
            'Mouse',
            'Keyboards',
            'Headphones',
            'Consoles',
            'PC Essentials',
            'Other Products',
            'Apple Products',
            'Laptops',
            'Gaming Chair',
            'Gaming Desks',
            'iMac',
            'MacBook',
            'Mac Mini',
            'AirPods',
            'Accessories',
            'Printers',
            'Webcams',
            'Routers',
            'Cables',
            'Speakers',
            'Microphones',
            'Mousepads',
            'Headphone Stands',
            'Laptop Bags',
            'Mouse Bungees',
            'iPad',
            'Complete PCs',
            'Packages',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'image' => 'images/default.jpg',
                'slug' => strtolower(str_replace(' ', '-', $category)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
