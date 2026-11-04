<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'full_name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'sme_owner',
                'is_verified' => true,
            ]
        );

        $this->call(BusinessAutopsyMasterSeeder::class);
    }
}
