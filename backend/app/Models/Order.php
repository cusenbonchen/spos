<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'total_price', 'status', 'created_at'];

    protected $casts = [
        'total_price' => 'decimal:2', // Tổng tiền của đơn hàng
        'status' => 'integer',        // Trạng thái đơn hàng (0: pending, 1: completed)
        'created_at' => 'datetime',
    ];
}
