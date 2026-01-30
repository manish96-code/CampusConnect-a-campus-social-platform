<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'manish@gmail.com'],
            [
                'first_name' => 'Manish',
                'last_name' => 'Admin',
                'dob' => '2000-01-01',
                'gender' => 'male',
                'contact' => '9999999999',
                'password' => Hash::make('123456789'),
                'is_admin' => true,
            ]
        );
    }
}
