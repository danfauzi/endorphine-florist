<?php

namespace Tests\Support;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesEndorphineData
{
    protected function createEndorphineUser(string $role, string $email): User
    {
        return User::create([
            'name' => ucfirst($role).' Test',
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
            'phone' => '081234567890',
            'is_active' => true,
        ]);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected function createEndorphineProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Buket Test',
            'category' => 'bunga',
            'price' => 100000,
            'stock' => 5,
            'status' => 'Ready',
            'description' => 'Buket untuk pengujian.',
        ], $attributes));
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected function createEndorphineOrder(User $user, array $attributes = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'E2E-'.strtoupper(str()->random(12)),
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'total_price' => 100000,
            'payment_method' => 'QRIS',
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'shipping_address' => 'Jl. Mawar No. 1',
            'recipient_phone' => '081234567890',
        ], $attributes));
    }
}
