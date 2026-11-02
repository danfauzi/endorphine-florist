<?php

namespace Tests\Unit;

use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoucherStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_voucher_is_unavailable_after_quota_is_exhausted(): void
    {
        $voucher = Voucher::create([
            'code' => 'UNIT-QUOTA',
            'type' => 'fixed',
            'discount_amount' => 1000,
            'discount_value' => 1000,
            'min_order_price' => 0,
            'quota' => 0,
            'expired_date' => now()->addDays(3),
            'is_active' => true,
        ]);

        $this->assertFalse($voucher->refreshStatus());
        $this->assertFalse($voucher->fresh()->is_active);
        $this->assertFalse($voucher->fresh()->isAvailable());
    }

    public function test_voucher_is_available_while_active_with_remaining_quota(): void
    {
        $voucher = Voucher::create([
            'code' => 'UNIT-ACTIVE',
            'type' => 'percent',
            'discount_amount' => 10,
            'discount_value' => 10,
            'min_order_price' => 0,
            'quota' => 1,
            'expired_date' => now()->addDays(3),
            'is_active' => true,
        ]);

        $this->assertTrue($voucher->refreshStatus());
        $this->assertTrue($voucher->isAvailable());
    }
}
