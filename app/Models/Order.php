<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'greeting_card',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'shipping_address',
        'recipient_phone',
        'payment_proof',
        'stock_deducted',
        'rating',
        'review',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'stock_deducted' => 'boolean',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
