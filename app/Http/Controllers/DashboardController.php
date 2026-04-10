<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalProducts = Item::count();
        $totalStock = Item::sum('stock');
        $lowStock = Item::where('stock', '<=', 10)->count();
        $outOfStock = Item::where('stock', '<=', 0)->count();
        $totalValue = Item::sum(DB::raw('stock * price'));
        
        // Data untuk grafik (30 hari terakhir)
        $stockInData = StockMovement::where('type', 'in')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $stockOutData = StockMovement::where('type', 'out')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Aktivitas terbaru
        $recentMovements = StockMovement::with('product')
            ->latest()
            ->take(10)
            ->get();
        
        // Produk dengan stok menipis
        $lowStockProducts = Item::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        
        // Produk terlaris (paling banyak keluar)
        $topProducts = StockMovement::where('type', 'out')
            ->select('product_id', DB::raw('SUM(quantity) as total_out'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_out', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalProducts', 'totalStock', 'lowStock', 'outOfStock', 'totalValue',
            'stockInData', 'stockOutData', 'recentMovements', 
            'lowStockProducts', 'topProducts'
        ));
    }
}