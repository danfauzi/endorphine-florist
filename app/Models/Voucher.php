<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'discount_amount',
        'discount_value',
        'min_order_price',
        'quota',
        'expired_date',
        'is_active',
    ];

    protected $casts = [
        'expired_date' => 'date',
        'is_active'    => 'boolean',
    ];

    public function refreshStatus(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $expired = $this->expired_date && now()->greaterThanOrEqualTo($this->expired_date);
        $quotaReached = (int) $this->quota <= 0;

        if ($expired || $quotaReached) {
            $this->update(['is_active' => false]);

            return false;
        }

        return true;
    }

    public function isAvailable(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->expired_date && now()->greaterThanOrEqualTo($this->expired_date)) {
            return false;
        }

        return (int) $this->quota > 0;
    }

    public function toggleStatusByOwner(): bool
    {
        $this->update(['is_active' => ! $this->is_active]);

        return $this->is_active;
    }
}