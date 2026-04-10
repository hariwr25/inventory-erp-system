<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Asus ROG',
                'category' => 'Elektronik',
                'stock' => 15,
                'price' => 15000000,
            ],
            [
                'name' => 'Mouse Logitech MX Master',
                'category' => 'Aksesoris',
                'stock' => 30,
                'price' => 1250000,
            ],
            [
                'name' => 'Keyboard Mechanical Keychron',
                'category' => 'Aksesoris',
                'stock' => 8,
                'price' => 850000,
            ],
            [
                'name' => 'Monitor Samsung 24"',
                'category' => 'Elektronik',
                'stock' => 5,
                'price' => 2100000,
            ],
            [
                'name' => 'SSD NVMe 1TB',
                'category' => 'Komponen',
                'stock' => 20,
                'price' => 1450000,
            ],
            [
                'name' => 'RAM DDR4 16GB',
                'category' => 'Komponen',
                'stock' => 12,
                'price' => 850000,
            ],
            [
                'name' => 'Webcam Logitech C920',
                'category' => 'Aksesoris',
                'stock' => 3,
                'price' => 1750000,
            ],
            [
                'name' => 'Headphone Sony WH-1000XM4',
                'category' => 'Audio',
                'stock' => 7,
                'price' => 4250000,
            ],
            [
                'name' => 'Power Bank Anker 20000mAh',
                'category' => 'Aksesoris',
                'stock' => 25,
                'price' => 650000,
            ],
            [
                'name' => 'Microphone Blue Yeti',
                'category' => 'Audio',
                'stock' => 2,
                'price' => 2350000,
            ],
        ];

        foreach ($products as $product) {
            Item::create($product);
        }
    }
}