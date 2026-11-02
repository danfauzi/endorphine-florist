<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminOrderDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_order_list_replaces_status_actions_with_order_details(): void
    {
        $admin = $this->createAdmin();
        $order = $this->createOrder($admin);

        $this->actingAs($admin)
            ->get(route('admin.orders'))
            ->assertOk()
            ->assertSee('Detail Pesanan')
            ->assertSee(route('admin.orders.show', $order), false)
            ->assertDontSee('Aksi / Update Status')
            ->assertDontSee('name="status"', false);

        $this->assertFalse(Route::has('admin.orders.updateStatus'));
    }

    public function test_order_detail_displays_buyer_requests(): void
    {
        $admin = $this->createAdmin();
        $order = $this->createOrder($admin);

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Permintaan Pembeli')
            ->assertSee('Tolong gunakan pita warna pink.')
            ->assertSee('Selamat ulang tahun!')
            ->assertSee('Alamat Pembeli');
    }

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin Test',
            'email' => 'admin-order-details@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);
    }

    private function createOrder(User $admin): Order
    {
        $product = Product::create([
            'name' => 'Buket Mawar',
            'category' => 'bunga',
            'price' => 100000,
            'stock' => 5,
            'status' => 'Ready',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-20261019-001',
            'user_id' => $admin->id,
            'customer_name' => 'Pembeli Test',
            'total_price' => 100000,
            'status' => 'pending',
            'shipping_address' => 'Alamat Pembeli',
            'recipient_phone' => '081234567891',
            'greeting_card' => 'Selamat ulang tahun!',
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 100000,
            'note' => 'Tolong gunakan pita warna pink.',
        ]);

        return $order;
    }
}
