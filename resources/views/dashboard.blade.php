@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-900">Good {{ \Carbon\Carbon::now()->format('A') == 'AM' ? 'Morning' : 'Afternoon' }}, {{ Auth::user()->name }}!</h1>
    <p class="text-gray-500 mt-1">Here's what's happening with your inventory today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-gray-300 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Products</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($totalProducts) }}</p>
                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    +12% from last month
                </p>
            </div>
            <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-4-4m4 4H4m8 4v4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Stock -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-gray-300 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Stock</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($totalStock) }}</p>
                <p class="text-xs text-gray-500 mt-2">across all products</p>
            </div>
            <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-gray-300 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Low Stock</p>
                <p class="text-2xl font-semibold text-amber-600 mt-1">{{ $lowStock }}</p>
                <p class="text-xs text-gray-500 mt-2">needs attention</p>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Value -->
    <div class="bg-gray-900 rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-400">Inventory Value</p>
                <p class="text-2xl font-semibold text-white mt-1">Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-2">total assets</p>
            </div>
            <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stock Movement Chart -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-semibold text-gray-900">Stock Movement</h3>
                <p class="text-sm text-gray-500 mt-0.5">Last 30 days</p>
            </div>
            <div class="flex gap-1">
                <button class="px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 rounded-md transition">Weekly</button>
                <button class="px-3 py-1.5 text-xs font-medium bg-gray-900 text-white rounded-md">Monthly</button>
            </div>
        </div>
        <canvas id="stockChart" height="220"></canvas>
        @if($stockInData->isEmpty() && $stockOutData->isEmpty())
            <div class="text-center py-10">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm">No transaction data yet</p>
                <a href="{{ route('stock.in.form') }}" class="text-blue-600 text-sm hover:underline mt-2 inline-block">Start first transaction →</a>
            </div>
        @endif
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="mb-5">
            <h3 class="font-semibold text-gray-900">Best Sellers</h3>
            <p class="text-sm text-gray-500 mt-0.5">Top 5 products by sales</p>
        </div>
        @if($topProducts->count() > 0)
            <div class="space-y-4">
                @foreach($topProducts as $index => $item)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ Str::limit($item->product->name ?? 'Product deleted', 20) }}</p>
                            <p class="text-xs text-gray-500">units sold</p>
                        </div>
                    </div>
                    <p class="font-semibold text-gray-900">{{ number_format($item->total_out) }}</p>
                </div>
                @if(!$loop->last)
                    <div class="border-t border-gray-100"></div>
                @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm">No sales data yet</p>
            </div>
        @endif
    </div>
</div>

<!-- Recent Activity & Low Stock -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Recent Activity</h3>
            <p class="text-sm text-gray-500 mt-0.5">Latest stock transactions</p>
        </div>
        <div class="p-5">
            @if($recentMovements->count() > 0)
                <div class="space-y-4 max-h-[380px] overflow-y-auto">
                    @foreach($recentMovements as $movement)
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            @if($movement->type == 'in')
                                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-900 text-sm truncate">{{ $movement->product->name ?? 'Product deleted' }}</p>
                                @if($movement->type == 'in')
                                    <span class="text-emerald-600 font-medium text-sm">+{{ number_format($movement->quantity) }}</span>
                                @else
                                    <span class="text-red-600 font-medium text-sm">-{{ number_format($movement->quantity) }}</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $movement->description ?? 'No description' }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $movement->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">No activity yet</p>
                    <a href="{{ route('stock.in.form') }}" class="text-blue-600 text-sm hover:underline mt-2 inline-block">Start transaction →</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Low Stock Alert</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Products that need restock</p>
                </div>
                @if($lowStockProducts->count() > 0)
                    <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-md">{{ $lowStockProducts->count() }} items</span>
                @endif
            </div>
        </div>
        <div class="p-5">
            @if($lowStockProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                    <div class="bg-amber-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-amber-700 font-medium">{{ $product->stock }} left</p>
                        </div>
                        <div class="w-full bg-amber-100 rounded-full h-1.5 mb-3">
                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ min(100, ($product->stock / max($product->min_stock ?? 10, 1)) * 100) }}%"></div>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-500">Min stock: {{ $product->min_stock ?? 10 }}</p>
                            <a href="{{ route('stock.in.form') }}?product={{ $product->id }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Restock →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">All stock levels are healthy!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stockChart')?.getContext('2d');
        if (ctx) {
            const stockInData = @json($stockInData);
            const stockOutData = @json($stockOutData);
            
            const allDates = [...new Set([
                ...stockInData.map(item => item.date),
                ...stockOutData.map(item => item.date)
            ])].sort();
            
            const stockInValues = allDates.map(date => {
                const found = stockInData.find(item => item.date === date);
                return found ? found.total : 0;
            });
            
            const stockOutValues = allDates.map(date => {
                const found = stockOutData.find(item => item.date === date);
                return found ? found.total : 0;
            });
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: allDates.map(date => {
                        const d = new Date(date);
                        return d.toLocaleDateString('en-US', {day:'numeric', month:'short'});
                    }),
                    datasets: [
                        {
                            label: 'Stock In',
                            data: stockInValues,
                            borderColor: '#059669',
                            backgroundColor: 'rgba(5, 150, 105, 0.04)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#059669',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                        {
                            label: 'Stock Out',
                            data: stockOutValues,
                            borderColor: '#DC2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.04)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#DC2626',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6,
                                padding: 12,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#1F2937',
                            titleColor: '#F9FAFB',
                            bodyColor: '#D1D5DB',
                            padding: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#F3F4F6',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 11 },
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush