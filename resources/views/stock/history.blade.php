@extends('layouts.app')

@section('title', 'Stock History')
@section('content')

<!-- Page Title -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Stock Movement History</h1>
            <p class="text-sm text-gray-500 mt-1">Complete record of all stock transactions</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('stock.in.form') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                Stock In
            </a>
            <a href="{{ route('stock.out.form') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
                Stock Out
            </a>
        </div>
    </div>
</div>

<!-- Simple Stats Row (Minimal) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-3">
        <p class="text-xs text-gray-500">Total Records</p>
        <p class="text-xl font-bold text-gray-800">{{ $movements->total() }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-3">
        <p class="text-xs text-gray-500">Stock In</p>
        <p class="text-xl font-bold text-emerald-600">{{ number_format($movements->where('type', 'in')->sum('quantity')) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-3">
        <p class="text-xs text-gray-500">Stock Out</p>
        <p class="text-xl font-bold text-red-600">{{ number_format($movements->where('type', 'out')->sum('quantity')) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-3">
        <p class="text-xs text-gray-500">Period</p>
        <p class="text-sm font-medium text-gray-700">
            @if($movements->isNotEmpty())
                {{ $movements->first()->created_at->format('d/m/Y') }} - {{ $movements->last()->created_at->format('d/m/Y') }}
            @else
                No data
            @endif
        </p>
    </div>
</div>

<!-- History Table Card -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <!-- Filter Bar -->
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="text-xs text-gray-500">Filters:</span>
            </div>
            
            <select id="typeFilter" class="text-xs px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400">
                <option value="">All Types</option>
                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>📥 Stock In</option>
                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>📤 Stock Out</option>
            </select>
            
            <div class="relative">
                <svg class="absolute left-3 top-1.5 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Search product..." value="{{ request('search') }}"
                       class="pl-9 pr-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 w-48">
            </div>
            
            <button id="applyFilters" class="text-xs px-3 py-1.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                Apply
            </button>
            
            @if(request()->anyFilled(['type', 'search']))
                <a href="{{ route('stock.history') }}" class="text-xs px-3 py-1.5 text-gray-500 hover:text-gray-700 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </div>
    
    <!-- Result Info -->
    <div class="px-4 py-2 bg-white border-b border-gray-100 text-xs text-gray-500">
        Showing {{ $movements->firstItem() ?? 0 }} to {{ $movements->lastItem() ?? 0 }} of {{ $movements->total() }} records
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movements as $movement)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="text-sm text-gray-800">{{ $movement->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $movement->created_at->format('H:i:s') }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-medium text-gray-800">{{ $movement->product->name ?? 'Product deleted' }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs text-gray-500">{{ $movement->product->category ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($movement->type == 'in')
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-emerald-50 text-emerald-700 rounded-full font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                IN
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 bg-red-50 text-red-700 rounded-full font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                OUT
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($movement->type == 'in')
                            <span class="text-emerald-600 font-semibold">+{{ number_format($movement->quantity) }}</span>
                        @else
                            <span class="text-red-600 font-semibold">-{{ number_format($movement->quantity) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500 max-w-md">
                        {{ $movement->description ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-gray-500">No stock movement records found</p>
                        <div class="flex gap-3 justify-center mt-3">
                            <a href="{{ route('stock.in.form') }}" class="text-sm text-emerald-600 hover:text-emerald-700">+ Add Stock In</a>
                            <a href="{{ route('stock.out.form') }}" class="text-sm text-amber-600 hover:text-amber-700">- Add Stock Out</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
        {{ $movements->appends(request()->query())->links() }}
    </div>
</div>

<!-- Hidden form for filter submission -->
<form id="filterForm" method="GET" action="{{ route('stock.history') }}" class="hidden">
    <input type="hidden" name="type" id="formType">
    <input type="hidden" name="search" id="formSearch">
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeFilter = document.getElementById('typeFilter');
        const searchInput = document.getElementById('searchInput');
        const applyBtn = document.getElementById('applyFilters');
        
        const formType = document.getElementById('formType');
        const formSearch = document.getElementById('formSearch');
        const filterForm = document.getElementById('filterForm');
        
        applyBtn.addEventListener('click', function() {
            formType.value = typeFilter.value;
            formSearch.value = searchInput.value;
            filterForm.submit();
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyBtn.click();
            }
        });
    });
</script>
@endpush