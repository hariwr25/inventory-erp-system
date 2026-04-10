<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id', 'type', 'quantity', 
        'reference', 'description', 'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke product (Item)
    public function product()
    {
        return $this->belongsTo(Item::class, 'product_id');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk stok masuk
    public function scopeStockIn($query)
    {
        return $query->where('type', 'in');
    }

    // Scope untuk stok keluar
    public function scopeStockOut($query)
    {
        return $query->where('type', 'out');
    }
}