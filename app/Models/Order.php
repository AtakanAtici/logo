<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SDamian\Larasort\AutoSortable;

class Order extends Model
{
    use HasFactory, AutoSortable;

    protected $guarded = [];

    private array $sortables = [
        'id',
        'current_id',
        'status_key',
        'created_at',
        'updated_at',
    ];

    public function getStatusAttribute()
    {
        return config('services.order_status')[$this->status_key];
    }

    function items() {
        return $this->hasMany(OrderItem::class);
    }
}
