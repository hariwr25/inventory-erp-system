<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'category', 'stock', 'price'];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'product_id');
    }
    
    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }
    
    // Scope untuk filter kategori
    public function scopeFilterCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', 'like', '%' . $category . '%');
        }
        return $query;
    }
}