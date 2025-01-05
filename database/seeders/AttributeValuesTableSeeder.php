<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValuesTableSeeder extends Seeder
{
    public function run()
    {
        // Sample attribute values data
        $attributeValues = [
            // For Panel Type
            ['attribute_id' => 1, 'value' => 'VA Panel'],
            ['attribute_id' => 1, 'value' => 'TN Panel'],
            ['attribute_id' => 1, 'value' => 'IPS Panel'],

            // For Screen Size
            ['attribute_id' => 2, 'value' => '24 inch'],
            ['attribute_id' => 2, 'value' => '27 inch'],
            ['attribute_id' => 2, 'value' => '32 inch'],

            // For Refresh Rate
            ['attribute_id' => 3, 'value' => '60 Hz'],
            ['attribute_id' => 3, 'value' => '120 Hz'],
            ['attribute_id' => 3, 'value' => '144 Hz'],

            // For Resolution
            ['attribute_id' => 4, 'value' => '1920x1080'],
            ['attribute_id' => 4, 'value' => '2560x1440'],
            ['attribute_id' => 4, 'value' => '3840x2160'],

            // For Color
            ['attribute_id' => 5, 'value' => 'Black'],
            ['attribute_id' => 5, 'value' => 'White'],
            ['attribute_id' => 5, 'value' => 'Silver'],
        ];

        // Insert attribute values into the database
        DB::table('attribute_values')->insert($attributeValues);
    }
}
