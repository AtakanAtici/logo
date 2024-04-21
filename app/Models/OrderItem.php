<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'stock_code',
        'quantity',
        'per_price',
        'tax_percent',
        'tax_amount',
        'total_price',
        'deleted_at',
    ];
}
