<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesTableSeeder extends Seeder
{
    public function run()
    {
        // Sample attributes data
        $attributes = [
            ['name' => 'Panel Type', 'type' => 'select'],
            ['name' => 'Screen Size', 'type' => 'select'],
            ['name' => 'Refresh Rate', 'type' => 'select'],
            ['name' => 'Resolution', 'type' => 'text'],
            ['name' => 'Color', 'type' => 'select'],
        ];

        // Insert attributes into the database
        DB::table('attributes')->insert($attributes);
    }
}
