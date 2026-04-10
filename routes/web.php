<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;

// Auth routes (otomatis dari Breeze)
require __DIR__.'/auth.php';

// Protected routes (butuh login)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('items', ItemController::class);
    
    Route::prefix('stock')->group(function () {
        Route::get('/in', [StockController::class, 'stockInForm'])->name('stock.in.form');
        Route::post('/in', [StockController::class, 'stockIn'])->name('stock.in');
        Route::get('/out', [StockController::class, 'stockOutForm'])->name('stock.out.form');
        Route::post('/out', [StockController::class, 'stockOut'])->name('stock.out');
        Route::get('/history', [StockController::class, 'history'])->name('stock.history');
    });
});