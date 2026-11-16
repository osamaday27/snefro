<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'email', 'address', 'city', 'notes',
        'subtotal', 'shipping', 'total', 'status', 'payment_method',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
