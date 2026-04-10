@extends('layouts.app')

@section('title', 'Stock In')
@section('content')

<!-- Page Title & Breadcrumb -->
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
        <span class="text-gray-800">Inventory</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Stock In</span>
    </div>
    <h1 class="text-2xl font-semibold text-gray-800">Stock In</h1>
    <p class="text-sm text-gray-500 mt-1">Add stock to your inventory</p>
</div>

<!-- Form Card -->
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('stock.in') }}" method="POST">
            @csrf
            
            <!-- Form Body -->
            <div class="p-6 space-y-5">
                <!-- Select Product -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Select Product <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" 
                            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('product_id') border-red-500 @enderror" 
                            required>
                        <option value="">Choose a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Current stock: {{ $product->stock }} units)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 text-sm">+</span>
                        <input type="number" name="quantity" 
                               class="w-full pl-8 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('quantity') border-red-500 @enderror" 
                               placeholder="Enter quantity" required min="1" value="{{ old('quantity') }}">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Enter the number of units to add</p>
                    @error('quantity')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Description <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <textarea name="description" rows="3" 
                              class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('description') border-red-500 @enderror"
                              placeholder="e.g., Purchase from supplier, Warehouse transfer, Return from customer">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Info Box -->
                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-xs text-blue-700">
                            <p>Adding stock will:</p>
                            <ul class="list-disc list-inside mt-1 space-y-0.5">
                                <li>Increase product stock quantity</li>
                                <li>Record this transaction in history</li>
                                <li>Update inventory value automatically</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    Add Stock
                </button>
            </div>
        </form>
    </div>
    
    <!-- Recent Stock In History Link -->
    <div class="mt-4 text-center">
        <a href="{{ route('stock.history') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
            View all stock movement history →
        </a>
    </div>
</div>
@endsection