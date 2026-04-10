@extends('layouts.app')

@section('title', 'Products')
@section('content')

<!-- Page Title -->
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Products</h1>
    <p class="text-sm text-gray-500 mt-1">Manage your product inventory</p>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <!-- Header with Search & Add Button -->
    <div class="px-5 py-4 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="relative w-full md:w-72">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Search products..." 
                       class="w-full pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
            </div>
            <a href="{{ route('items.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>
    </div>
    
    <!-- Filter Bar -->
    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-xs font-medium text-gray-500">Filter by:</span>
            
            <!-- Category Filter -->
            <select id="categoryFilter" class="text-xs px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            
            <!-- Stock Status Filter -->
            <select id="stockFilter" class="text-xs px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                <option value="">All Stock Status</option>
                <option value="safe" {{ request('stock_status') == 'safe' ? 'selected' : '' }}>Safe (>10)</option>
                <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low (≤10)</option>
                <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock (0)</option>
            </select>
            
            <!-- Sort By -->
            <select id="sortBy" class="text-xs px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by: Date</option>
                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Sort by: Name</option>
                <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Sort by: Stock</option>
                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Sort by: Price</option>
            </select>
            
            <!-- Sort Order -->
            <select id="sortOrder" class="text-xs px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>↓ Descending</option>
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>↑ Ascending</option>
            </select>
            
            <button id="applyFilters" class="text-xs px-3 py-1.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                Apply
            </button>
            
            @if(request()->anyFilled(['search', 'category', 'stock_status', 'sort_by', 'sort_order']))
                <a href="{{ route('items.index') }}" class="text-xs px-3 py-1.5 text-gray-500 hover:text-gray-700 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </div>
    
    <!-- Result Info -->
    <div class="px-5 py-3 text-xs text-gray-500 border-b border-gray-100 bg-white">
        Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} products
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $item->id }}</td>
                    <td class="px-5 py-3">
                        <span class="font-medium text-gray-800">{{ $item->name }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-md">{{ $item->category }}</span>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-600">{{ number_format($item->stock) }} units</td>
                    <td class="px-5 py-3">
                        @if($item->stock <= 0)
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-red-50 text-red-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Out of Stock
                            </span>
                        @elseif($item->stock <= 10)
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-amber-50 text-amber-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Low Stock
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                In Stock
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm font-medium text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('items.edit', $item->id) }}" 
                               class="text-gray-500 hover:text-gray-700 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" 
                                        onclick="return confirm('Delete {{ $item->name }}?')" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-4-4m4 4H4m8 4v4" />
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No products found</p>
                        <a href="{{ route('items.create') }}" class="text-blue-600 text-sm hover:underline mt-2 inline-block">
                            Add your first product →
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
        {{ $items->links() }}
    </div>
</div>

<!-- Hidden form for filter submission -->
<form id="filterForm" method="GET" action="{{ route('items.index') }}" class="hidden">
    <input type="hidden" name="search" id="formSearch" value="{{ request('search') }}">
    <input type="hidden" name="category" id="formCategory" value="{{ request('category') }}">
    <input type="hidden" name="stock_status" id="formStockStatus" value="{{ request('stock_status') }}">
    <input type="hidden" name="sort_by" id="formSortBy" value="{{ request('sort_by', 'created_at') }}">
    <input type="hidden" name="sort_order" id="formSortOrder" value="{{ request('sort_order', 'desc') }}">
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const stockFilter = document.getElementById('stockFilter');
        const sortBy = document.getElementById('sortBy');
        const sortOrder = document.getElementById('sortOrder');
        const applyBtn = document.getElementById('applyFilters');
        
        const formSearch = document.getElementById('formSearch');
        const formCategory = document.getElementById('formCategory');
        const formStockStatus = document.getElementById('formStockStatus');
        const formSortBy = document.getElementById('formSortBy');
        const formSortOrder = document.getElementById('formSortOrder');
        const filterForm = document.getElementById('filterForm');
        
        // Set initial values to form inputs
        if (searchInput) formSearch.value = searchInput.value;
        
        applyBtn.addEventListener('click', function() {
            formSearch.value = searchInput.value;
            formCategory.value = categoryFilter.value;
            formStockStatus.value = stockFilter.value;
            formSortBy.value = sortBy.value;
            formSortOrder.value = sortOrder.value;
            filterForm.submit();
        });
        
        // Enter key on search input
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyBtn.click();
            }
        });
    });
</script>
@endpush