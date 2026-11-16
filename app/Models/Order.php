<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'pending' => 'قيد المراجعة',
        'processing' => 'جاري التجهيز',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
    ];

    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'email', 'address', 'city', 'notes',
        'subtotal', 'shipping', 'total', 'status', 'payment_method',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** رقم العميل بصيغة واتساب الدولية */
    public function getWhatsappAttribute(): string
    {
        $d = preg_replace('/\D/', '', $this->phone);
        if (str_starts_with($d, '00')) return substr($d, 2);
        if (str_starts_with($d, '0')) return '20'.substr($d, 1);
        return $d;
    }
}
