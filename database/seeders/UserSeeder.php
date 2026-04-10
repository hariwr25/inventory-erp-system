<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Inventory',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        
        // Staff user
        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@inventory.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}