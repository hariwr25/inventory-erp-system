<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $products = Item::all();
        
        // Data dummy untuk stok masuk (pembelian dari supplier)
        $stockInData = [
            ['description' => 'Pembelian dari Supplier PT. Elektronik Jaya', 'quantity' => 10],
            ['description' => 'Restock barang laris', 'quantity' => 5],
            ['description' => 'Transfer dari gudang pusat', 'quantity' => 8],
            ['description' => 'Pembelian bulk untuk promo', 'quantity' => 20],
            ['description' => 'Pengiriman dari distributor resmi', 'quantity' => 3],
        ];
        
        // Data dummy untuk stok keluar (penjualan)
        $stockOutData = [
            ['description' => 'Penjualan ke customer retail', 'quantity' => 2],
            ['description' => 'Pemesanan corporate', 'quantity' => 5],
            ['description' => 'Rusak / return', 'quantity' => 1],
            ['description' => 'Donasi / sample', 'quantity' => 1],
            ['description' => 'Transfer ke gudang cabang', 'quantity' => 3],
        ];
        
        // Buat history untuk 30 hari terakhir
        for ($i = 0; $i < 30; $i++) {
            $product = $products->random();
            $date = now()->subDays(rand(0, 30));
            
            // 60% kemungkinan stok masuk, 40% stok keluar
            $isStockIn = rand(1, 100) <= 60;
            
            if ($isStockIn) {
                $data = $stockInData[array_rand($stockInData)];
                $quantity = $data['quantity'] + rand(-2, 5);
                
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => max(1, $quantity),
                    'description' => $data['description'],
                    'reference' => 'PO-' . date('Ymd', strtotime($date)) . '-' . rand(100, 999),
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                // Update stok produk
                $product->stock += max(1, $quantity);
                $product->save();
            } else {
                $data = $stockOutData[array_rand($stockOutData)];
                $quantity = $data['quantity'] + rand(-1, 3);
                
                if ($product->stock >= $quantity) {
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'quantity' => max(1, $quantity),
                        'description' => $data['description'],
                        'reference' => 'SO-' . date('Ymd', strtotime($date)) . '-' . rand(100, 999),
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                    
                    // Update stok produk
                    $product->stock -= max(1, $quantity);
                    $product->save();
                }
            }
        }
        
        // Tambah beberapa transaksi hari ini
        foreach ($products->take(3) as $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => rand(5, 15),
                'description' => 'Stock awal / pembukaan',
                'reference' => 'INIT-' . date('Ymd'),
                'created_at' => now(),
            ]);
        }
    }
}