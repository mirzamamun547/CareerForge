<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create an admin user if one does not already exist.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@careerforge.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'verified' => true,
            ]
        );
    }
}
