@extends('layouts.app')

@section('title', 'Stock Out')
@section('content')

<!-- Page Title & Breadcrumb -->
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
        <span class="text-gray-800">Inventory</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Stock Out</span>
    </div>
    <h1 class="text-2xl font-semibold text-gray-800">Stock Out</h1>
    <p class="text-sm text-gray-500 mt-1">Remove stock from your inventory</p>
</div>

<!-- Form Card -->
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('stock.out') }}" method="POST" id="stockOutForm">
            @csrf
            
            <!-- Form Body -->
            <div class="p-6 space-y-5">
                <!-- Select Product -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Select Product <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="productSelect"
                            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('product_id') border-red-500 @enderror" 
                            required>
                        <option value="">Choose a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stock: {{ $product->stock }} units)
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Current Stock Display -->
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Current Stock:</span>
                        <span id="currentStockDisplay" class="text-lg font-semibold text-gray-800">-</span>
                    </div>
                </div>
                
                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 text-sm">-</span>
                        <input type="number" name="quantity" id="quantityInput"
                               class="w-full pl-8 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('quantity') border-red-500 @enderror" 
                               placeholder="Enter quantity" required min="1" value="{{ old('quantity') }}">
                    </div>
                    <p id="quantityWarning" class="text-xs text-red-500 mt-1 hidden"></p>
                    <p class="text-xs text-gray-400 mt-1">Enter the number of units to remove</p>
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
                              placeholder="e.g., Customer purchase, Damaged goods, Expired items, Transfer out">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Warning Box -->
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="text-xs text-amber-700">
                            <p>Removing stock will:</p>
                            <ul class="list-disc list-inside mt-1 space-y-0.5">
                                <li>Decrease product stock quantity</li>
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
                <button type="submit" id="submitBtn"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                    Remove Stock
                </button>
            </div>
        </form>
    </div>
    
    <!-- Recent Stock Out History Link -->
    <div class="mt-4 text-center">
        <a href="{{ route('stock.history') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
            View all stock movement history →
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('productSelect');
        const quantityInput = document.getElementById('quantityInput');
        const currentStockDisplay = document.getElementById('currentStockDisplay');
        const quantityWarning = document.getElementById('quantityWarning');
        const submitBtn = document.getElementById('submitBtn');
        
        function updateCurrentStock() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const stock = parseInt(selectedOption.dataset.stock) || 0;
                currentStockDisplay.textContent = stock + ' units';
                currentStockDisplay.classList.remove('text-red-600', 'text-amber-600', 'text-emerald-600');
                if (stock <= 0) {
                    currentStockDisplay.classList.add('text-red-600');
                } else if (stock <= 10) {
                    currentStockDisplay.classList.add('text-amber-600');
                } else {
                    currentStockDisplay.classList.add('text-emerald-600');
                }
                validateQuantity();
            } else {
                currentStockDisplay.textContent = '-';
                quantityWarning.classList.add('hidden');
            }
        }
        
        function validateQuantity() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                quantityWarning.textContent = 'Please select a product first';
                quantityWarning.classList.remove('hidden');
                submitBtn.disabled = true;
                return false;
            }
            
            const currentStock = parseInt(selectedOption.dataset.stock) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (quantity <= 0) {
                quantityWarning.textContent = 'Quantity must be greater than 0';
                quantityWarning.classList.remove('hidden');
                submitBtn.disabled = true;
                return false;
            }
            
            if (quantity > currentStock) {
                quantityWarning.textContent = `Insufficient stock! Available: ${currentStock} units`;
                quantityWarning.classList.remove('hidden');
                submitBtn.disabled = true;
                return false;
            }
            
            quantityWarning.classList.add('hidden');
            submitBtn.disabled = false;
            return true;
        }
        
        productSelect.addEventListener('change', updateCurrentStock);
        quantityInput.addEventListener('input', validateQuantity);
        
        // Initial validation
        updateCurrentStock();
        
        // Form submit validation
        document.getElementById('stockOutForm').addEventListener('submit', function(e) {
            if (!validateQuantity()) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush