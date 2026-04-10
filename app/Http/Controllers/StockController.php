<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Form stok masuk
    public function stockInForm()
    {
        $products = Item::orderBy('name')->get();
        return view('stock.in', compact('products'));
    }

    // Proses stok masuk
    public function stockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $product = Item::findOrFail($request->product_id);
        
        // Tambah stok
        $product->stock += $request->quantity;
        $product->save();

        // Simpan ke history
        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $request->quantity,
            'description' => $request->description,
            'reference' => 'STOCK_IN_' . date('YmdHis'),
            'created_by' => auth()->id() ?? 1
        ]);
        
        return redirect()->route('stock.history')
            ->with('success', "Stok {$product->name} berhasil ditambahkan (+{$request->quantity})");
    }

    // Form stok keluar
    public function stockOutForm()
    {
        $products = Item::orderBy('name')->get();
        return view('stock.out', compact('products'));
    }

    // Proses stok keluar
    public function stockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $product = Item::findOrFail($request->product_id);
        
        // Cek stok cukup tidak
        if ($product->stock < $request->quantity) {
            return back()->with('error', "Stok {$product->name} tidak mencukupi! (Sisa: {$product->stock})");
        }

        // Kurang stok
        $product->stock -= $request->quantity;
        $product->save();

        // Simpan ke history
        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => $request->quantity,
            'description' => $request->description,
            'reference' => 'STOCK_OUT_' . date('YmdHis'),
            'created_by' => auth()->id() ?? 1
        ]);
        
        return redirect()->route('stock.history')
            ->with('success', "Stok {$product->name} berhasil dikurangi (-{$request->quantity})");
    }

    // History semua transaksi
    // History semua transaksi
public function history()
{
    $movements = StockMovement::with('product')
        ->latest()
        ->paginate(20);
    
    return view('stock.history', compact('movements'));
}
}