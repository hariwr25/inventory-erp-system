@extends('layouts.app')

@section('title', 'Edit Product')
@section('content')

<!-- Page Title & Breadcrumb -->
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
        <a href="{{ route('items.index') }}" class="hover:text-gray-700">Products</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('items.edit', $item->id) }}" class="hover:text-gray-700">Edit</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800">{{ $item->name }}</span>
    </div>
    <h1 class="text-2xl font-semibold text-gray-800">Edit Product</h1>
    <p class="text-sm text-gray-500 mt-1">Update product information</p>
</div>

<!-- Form Card -->
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Form Body -->
            <div class="p-6 space-y-5">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" 
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('name') border-red-500 @enderror"
                           placeholder="Enter product name" required>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}"
                           class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('category') border-red-500 @enderror"
                           placeholder="e.g., Electronics, Accessories, Furniture" required>
                    @error('category')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stock & Price Row -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-sm">📦</span>
                            <input type="number" name="stock" value="{{ old('stock', $item->stock) }}"
                                   class="w-full pl-8 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('stock') border-red-500 @enderror"
                                   placeholder="0" min="0" required>
                        </div>
                        @error('stock')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Price <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-sm">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $item->price) }}"
                                   class="w-full pl-8 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('price') border-red-500 @enderror"
                                   placeholder="0" step="1000" min="0" required>
                        </div>
                        @error('price')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Stock Status Info -->
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-3 text-sm">
                        <span class="text-gray-500">Current Stock Status:</span>
                        @if($item->stock <= 0)
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-red-50 text-red-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Out of Stock
                            </span>
                        @elseif($item->stock <= 10)
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-amber-50 text-amber-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Low Stock ({{ $item->stock }} units left)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                In Stock ({{ $item->stock }} units)
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('items.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                    Update Product
                </button>
            </div>
        </form>
    </div>
    
    <!-- Help Text -->
    <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xs text-gray-500">
                To manage stock levels more accurately, use the <strong>Stock In</strong> and <strong>Stock Out</strong> features instead of editing stock directly.
            </p>
        </div>
    </div>
</div>
@endsection