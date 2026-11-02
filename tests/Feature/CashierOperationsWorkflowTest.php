<?php

namespace Tests\Feature;

use App\Models\OrderItem;
use App\Models\ShiftRecap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesEndorphineData;
use Tests\TestCase;

class CashierOperationsWorkflowTest extends TestCase
{
    use CreatesEndorphineData;
    use RefreshDatabase;

    public function test_cashier_completing_an_order_deducts_stock_only_once(): void
    {
        $cashier = $this->createEndorphineUser('kasir', 'cashier-status@example.com');
        $customer = $this->createEndorphineUser('pelanggan', 'order-customer@example.com');
        $product = $this->createEndorphineProduct(['stock' => 5]);
        $order = $this->createEndorphineOrder($customer);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price,
        ]);

        $this->actingAs($cashier)
            ->patch(route('kasir.orders.updateStatus', $order->id), ['status' => 'completed'])
            ->assertRedirect();

        $this->assertSame(3, $product->fresh()->stock);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
            'payment_status' => 'paid',
            'stock_deducted' => true,
        ]);

        $this->patch(route('kasir.orders.updateStatus', $order->id), ['status' => 'completed'])
            ->assertRedirect();
        $this->assertSame(3, $product->fresh()->stock);
    }

    public function test_cashier_payment_status_does_not_accept_unknown_values(): void
    {
        $cashier = $this->createEndorphineUser('kasir', 'cashier-payment@example.com');
        $customer = $this->createEndorphineUser('pelanggan', 'payment-customer@example.com');
        $order = $this->createEndorphineOrder($customer);

        $this->actingAs($cashier)
            ->patch(route('kasir.orders.updatePaymentStatus', $order->id), [
                'payment_status' => 'not-a-payment-state',
            ])
            ->assertSessionHasErrors('payment_status');

        $this->assertSame('unpaid', $order->fresh()->payment_status);
    }

    public function test_cashier_can_save_walkin_sale_and_out_of_stock_sale_is_rejected(): void
    {
        $cashier = $this->createEndorphineUser('kasir', 'cashier-pos@example.com');
        $product = $this->createEndorphineProduct(['stock' => 4, 'price' => 75000]);

        $this->actingAs($cashier)
            ->post(route('kasir.walkin.store'), [
                'customer_name' => 'Pembeli Toko',
                'cart_data' => json_encode([
                    ['id' => $product->id, 'name' => $product->name, 'price' => 75000, 'qty' => 2],
                ], JSON_THROW_ON_ERROR),
                'payment_method' => 'Cash',
            ])
            ->assertRedirect(route('kasir.orders'));

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Pembeli Toko',
            'total_price' => 150000,
            'payment_method' => 'Cash',
            'payment_status' => 'paid',
            'status' => 'completed',
            'stock_deducted' => true,
        ]);
        $this->assertSame(2, $product->fresh()->stock);

        $this->post(route('kasir.walkin.store'), [
            'customer_name' => 'Pembeli Kehabisan Stok',
            'cart_data' => json_encode([
                ['id' => $product->id, 'name' => $product->name, 'price' => 75000, 'qty' => 3],
            ], JSON_THROW_ON_ERROR),
            'payment_method' => 'QRIS',
        ])->assertSessionHas('error');

        $this->assertSame(1, \App\Models\Order::query()->count());
        $this->assertSame(2, $product->fresh()->stock);
    }

    public function test_cashier_can_store_shift_recap_with_expected_difference(): void
    {
        $cashier = $this->createEndorphineUser('kasir', 'cashier-recap@example.com');
        $this->createEndorphineOrder($cashier, [
            'order_number' => 'E2E-CASH-RECAP',
            'total_price' => 100000,
            'payment_method' => 'Cash',
            'payment_status' => 'paid',
            'status' => 'completed',
        ]);
        $this->createEndorphineOrder($cashier, [
            'order_number' => 'E2E-QRIS-RECAP',
            'total_price' => 50000,
            'payment_method' => 'QRIS',
            'payment_status' => 'paid',
            'status' => 'completed',
        ]);

        $this->actingAs($cashier)
            ->post(route('kasir.recap.store'), [
                'modal_awal' => 300000,
                'physical_cash' => 390000,
                'notes' => 'Selisih uji.',
            ])
            ->assertRedirect(route('kasir.recap'));

        $recap = ShiftRecap::query()->firstOrFail();
        $this->assertSame(100000.0, (float) $recap->total_tunai);
        $this->assertSame(50000.0, (float) $recap->total_qris);
        $this->assertSame(400000.0, (float) $recap->total_kas_fisik);
        $this->assertSame(390000.0, (float) $recap->physical_cash);
        $this->assertSame(-10000.0, (float) $recap->selisih);
    }

    public function test_cashier_recap_rejects_missing_numeric_inputs(): void
    {
        $cashier = $this->createEndorphineUser('kasir', 'cashier-recap-invalid@example.com');

        $this->actingAs($cashier)
            ->post(route('kasir.recap.store'), ['notes' => 'Tidak lengkap'])
            ->assertSessionHasErrors(['modal_awal', 'physical_cash']);

        $this->assertDatabaseCount('shift_recaps', 0);
    }
}
