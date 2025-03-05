<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'stock', 'created_at'];

    protected $casts = [
        'price' => 'decimal:2', // Giá sản phẩm có 2 chữ số thập phân
        'stock' => 'integer',   // Số lượng tồn kho
        'created_at' => 'datetime',
    ];
}
