<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesEndorphineData;
use Tests\TestCase;

class StorefrontWorkflowTest extends TestCase
{
    use CreatesEndorphineData;
    use RefreshDatabase;

    public function test_guest_can_search_filter_and_open_product_details(): void
    {
        $rose = $this->createEndorphineProduct(['name' => 'Buket Rose Pink']);
        $snack = $this->createEndorphineProduct([
            'name' => 'Buket Cokelat',
            'category' => 'snack',
        ]);

        $this->get(route('home', ['search' => 'Rose']))
            ->assertOk()
            ->assertSee('Buket Rose Pink')
            ->assertDontSee('Buket Cokelat');

        $this->get(route('home', ['category' => 'SNACK']))
            ->assertOk()
            ->assertSee('Buket Cokelat')
            ->assertDontSee('Buket Rose Pink');

        $this->get(route('products.show', $rose))
            ->assertOk()
            ->assertSee('Buket Rose Pink');
        $this->get(route('products.show', $snack))
            ->assertOk()
            ->assertSee('Buket Cokelat');
    }

    public function test_customer_can_add_cart_item_and_cart_addition_respects_stock(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'cart-stock@example.com');
        $product = $this->createEndorphineProduct(['stock' => 1]);

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 1])
            ->assertSessionHas('success');

        $this->post(route('cart.add', $product), ['quantity' => 1])
            ->assertSessionHas('error');

        $this->assertDatabaseHas('carts', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_increasing_cart_quantity_cannot_exceed_available_stock(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'cart-increase@example.com');
        $product = $this->createEndorphineProduct(['stock' => 1]);
        $cart = Cart::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($customer)
            ->patch(route('cart.update', $cart), ['action' => 'increase'])
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'quantity' => 1,
        ]);
    }

    public function test_checkout_applies_percentage_discount_and_consumes_voucher_quota(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'checkout-voucher@example.com');
        $product = $this->createEndorphineProduct(['price' => 100000]);
        Cart::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'note' => 'Pita merah',
        ]);
        BankAccount::create([
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'Endorphine Florist',
            'is_active' => true,
        ]);
        $voucher = Voucher::create([
            'code' => 'HEMAT20',
            'type' => 'percent',
            'discount_amount' => 20,
            'discount_value' => 20,
            'min_order_price' => 100000,
            'quota' => 2,
            'expired_date' => now()->addDays(2),
            'is_active' => true,
        ]);

        $this->actingAs($customer)
            ->post(route('cart.applyVoucher'), ['code' => 'hemat20'])
            ->assertSessionHas('voucher.discount', 40000);

        $this->post(route('checkout.store'), [
            'shipping_address' => 'Jl. Mawar No. 1',
            'recipient_phone' => '081234567890',
            'payment_method' => 'BCA',
        ])->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'total_price' => 160000,
            'payment_method' => 'BCA',
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);
        $this->assertSame(1, $voucher->fresh()->quota);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'note' => 'Pita merah',
        ]);
        $this->assertDatabaseMissing('carts', ['user_id' => $customer->id]);
    }

    public function test_checkout_rejects_empty_cart_and_cash_payment(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'checkout-invalid@example.com');

        $this->actingAs($customer)
            ->get(route('checkout'))
            ->assertRedirect(route('cart.index'));

        $product = $this->createEndorphineProduct();
        Cart::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->post(route('checkout.store'), [
            'shipping_address' => 'Jl. Mawar No. 1',
            'recipient_phone' => '081234567890',
            'payment_method' => 'Cash',
        ])->assertSessionHasErrors('payment_method');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_payment_proof_accepts_an_image_and_rejects_a_text_file(): void
    {
        Storage::fake('public');
        $customer = $this->createEndorphineUser('pelanggan', 'payment-proof@example.com');
        $order = $this->createEndorphineOrder($customer);

        $this->actingAs($customer)
            ->post(route('orders.uploadProof', $order), [
                'payment_proof' => UploadedFile::fake()->image('proof.jpg'),
            ])
            ->assertRedirect(route('orders.success', $order->id));

        $order->refresh();
        $this->assertSame('Menunggu Verifikasi', $order->payment_status);
        Storage::disk('public')->assertExists($order->payment_proof);

        $secondOrder = $this->createEndorphineOrder($customer, [
            'order_number' => 'E2E-'.strtoupper(str()->random(12)),
        ]);
        $this->post(route('orders.uploadProof', $secondOrder), [
            'payment_proof' => UploadedFile::fake()->create('proof.txt', 5, 'text/plain'),
        ])->assertSessionHasErrors('payment_proof');

        $this->assertSame('unpaid', $secondOrder->fresh()->payment_status);
    }

    public function test_customer_can_review_paid_completed_order_and_invalid_reviews_are_rejected(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'review-customer@example.com');
        $order = $this->createEndorphineOrder($customer, [
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        $this->actingAs($customer)
            ->post(route('orders.review', $order), [
                'rating' => 5,
                'review' => 'Buket bagus dan sesuai pesanan.',
            ])
            ->assertRedirect(route('orders.index', ['status' => 'review']));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'rating' => 5,
            'review' => 'Buket bagus dan sesuai pesanan.',
        ]);

        $ineligibleOrder = $this->createEndorphineOrder($customer, [
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);
        $this->post(route('orders.review', $ineligibleOrder), [
            'rating' => 6,
            'review' => '',
        ])->assertUnprocessable();
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $customer = $this->createEndorphineUser('pelanggan', 'review-owner@example.com');
        $otherCustomer = $this->createEndorphineUser('pelanggan', 'review-other@example.com');
        $order = $this->createEndorphineOrder($otherCustomer);

        $this->actingAs($customer)
            ->get(route('orders.success', $order->id))
            ->assertForbidden();

        $this->post(route('orders.review', $order), [
            'rating' => 4,
            'review' => 'Review tidak berhak.',
        ])->assertForbidden();
    }
}
