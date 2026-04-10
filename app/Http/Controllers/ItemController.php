<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();
        
        // Search berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }
        
        // Filter berdasarkan status stok
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'low') {
                $query->where('stock', '<=', 10);
            } elseif ($request->stock_status == 'out') {
                $query->where('stock', '<=', 0);
            } elseif ($request->stock_status == 'safe') {
                $query->where('stock', '>', 10);
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validasi sort_by agar tidak bisa inject
        $allowedSorts = ['created_at', 'name', 'stock', 'price'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Pagination (10 items per page)
        $items = $query->paginate(10)->withQueryString();
        
        // Ambil daftar kategori unik untuk filter dropdown
        $categories = Item::select('category')->distinct()->pluck('category');
        
        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0'
        ]);
    
        Item::create($request->all());
    
        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Item $item)
    {
        // Optional: bisa diisi nanti untuk detail produk
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0'
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus');
    }
}