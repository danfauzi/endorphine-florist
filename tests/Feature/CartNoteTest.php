<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CartNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_voucher_quota_is_decremented_and_rejected_when_exhausted(): void
    {
        $user = User::create([
            'name' => 'Pelanggan Voucher',
            'email' => 'voucher@example.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081234567891',
        ]);

        $product = Product::create([
            'name' => 'Buket Promo',
            'category' => 'Kado',
            'price' => 100000,
            'stock' => 5,
            'status' => 'active',
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $voucher = Voucher::create([
            'code' => 'PROMO2X',
            'type' => 'fixed',
            'discount_amount' => 20000,
            'discount_value' => 20000,
            'min_order_price' => 0,
            'quota' => 1,
            'expired_date' => now()->addDays(7),
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post(route('cart.applyVoucher'), ['code' => 'PROMO2X'])
            ->assertSessionHas('voucher')
            ->assertSessionHas('success');

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Mawar No. 3',
                'recipient_phone' => '081234567891',
                'payment_method' => 'QRIS',
            ])
            ->assertRedirect();

        $voucher->refresh();
        $this->assertSame(0, $voucher->quota);

        $this->actingAs($user)
            ->post(route('cart.applyVoucher'), ['code' => 'PROMO2X'])
            ->assertSessionHas('error', 'Kode voucher sudah kadaluarsa atau habis digunakan.');
    }

    public function test_admin_can_manual_toggle_voucher_status_after_auto_disable(): void
    {
        $admin = User::create([
            'name' => 'Admin Voucher',
            'email' => 'admin-voucher@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567891',
        ]);

        $voucher = Voucher::create([
            'code' => 'OWNERREACT',
            'type' => 'fixed',
            'discount_amount' => 15000,
            'discount_value' => 15000,
            'min_order_price' => 0,
            'quota' => 0,
            'expired_date' => now()->addDays(2),
            'is_active' => true,
        ]);

        $voucher->refreshStatus();
        $this->assertFalse($voucher->fresh()->is_active);

        $this->actingAs($admin)
            ->patch(route('admin.vouchers.toggle', $voucher))
            ->assertRedirect();

        $voucher->refresh();
        $this->assertTrue($voucher->is_active);
    }

    public function test_owner_can_open_graph_report_page(): void
    {
        $owner = User::create([
            'name' => 'Owner Grafis',
            'email' => 'owner-graph@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567892',
        ]);

        $this->actingAs($owner)
            ->get(route('owner.reports.chart', ['start_date' => now()->startOfMonth()->toDateString(), 'end_date' => now()->endOfMonth()->toDateString()]))
            ->assertOk()
            ->assertSee('Grafik Omset');
    }

    public function test_customer_note_is_saved_and_copied_to_order_item(): void
    {
        $user = User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081234567890',
        ]);
        $product = Product::create([
            'name' => 'Buket Test',
            'category' => 'Kado',
            'price' => 75000,
            'stock' => 5,
            'status' => 'active',
        ]);
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user)
            ->patch(route('cart.update', $cart), [
                'note' => 'Pita warna pink',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'note' => 'Pita warna pink',
        ]);

        BankAccount::create([
            'bank_name' => 'BRI',
            'account_number' => '1234567890',
            'account_holder' => 'Toko Test',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Melati No. 1',
                'recipient_phone' => '081234567890',
                'payment_method' => 'BRI',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'payment_method' => 'BRI',
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $this->actingAs($user)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Riwayat Transaksi')
            ->assertSee('Buket Test')
            ->assertSee('BRI');

        $this->actingAs($user)
            ->get(route('orders.index', ['status' => 'unpaid']))
            ->assertOk()
            ->assertSee('Lanjutkan Pembayaran');

        $order = Order::latest('id')->firstOrFail();

        $this->actingAs($user)
            ->get(route('orders.success', $order->id))
            ->assertOk()
            ->assertSee('Bank BRI');

        $order->update([
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        $this->actingAs($user)
            ->get(route('orders.index', ['status' => 'review']))
            ->assertOk()
            ->assertSee('Penilaian')
            ->assertSee('Beri bintang');

        $this->actingAs($user)
            ->post(route('orders.review', $order), [
                'rating' => 5,
                'review' => 'Buketnya bagus dan sesuai pesanan.',
            ])
            ->assertRedirect(route('orders.index', ['status' => 'review']));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'rating' => 5,
            'review' => 'Buketnya bagus dan sesuai pesanan.',
        ]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Ulasan Pelanggan')
            ->assertSee('Pelanggan Test')
            ->assertSee('Buketnya bagus dan sesuai pesanan.');

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Ulasan Pelanggan');

        $this->get(route('reviews.index'))
            ->assertOk()
            ->assertSee('Semua Ulasan')
            ->assertSee('Pelanggan Test');

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'note' => 'Pita warna pink',
        ]);

        $cashier = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);
        $this->actingAs($cashier)
            ->get(route('kasir.orders.detail', $order))
            ->assertOk()
            ->assertSee('Catatan Buket')
            ->assertSee('Pita warna pink');
    }
}
