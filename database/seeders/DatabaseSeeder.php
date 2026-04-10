<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // User dulu
            ProductSeeder::class,     // Baru produk
            StockMovementSeeder::class, // Terakhir transaksi
        ]);
    }
}