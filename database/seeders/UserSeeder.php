<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'father_name' => 'Michael Doe',
                'email'      => 'john@example.com',
                'dob'        => '1990-01-01',
                'address'    => '123 Main Street',
                'cnic'       => '12345-6789012-3',
                'phone'      => '+92-315-853-9620',
                'type'       => 'admin',
                'password'   => Hash::make('password123'), // Always hash passwords
                'verification' => 'Unverified',
                'terms'      => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Doe',
                'father_name' => 'Thomas Doe',
                'email'      => 'jane@example.com',
                'dob'        => '1992-05-10',
                'address'    => '456 Another St',
                'cnic'       => '54321-0987654-1',
                'phone'      => '+92-315-123-4567',
                'type'       => 'seller',
                'password'   => Hash::make('secret123'),
                'verification' => 'Verified',
                'terms'      => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
