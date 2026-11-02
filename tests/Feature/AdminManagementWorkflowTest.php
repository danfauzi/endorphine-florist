<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\CreatesEndorphineData;
use Tests\TestCase;

class AdminManagementWorkflowTest extends TestCase
{
    use CreatesEndorphineData;
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_products(): void
    {
        Storage::fake('public');
        $admin = $this->createEndorphineUser('admin', 'product-admin@example.com');

        $this->actingAs($admin)
            ->post(route('products.store'), [
                'name' => 'Buket Produk Baru',
                'category' => 'bunga',
                'price' => 120000,
                'stock' => 0,
                'description' => 'Deskripsi buket baru.',
                'image' => UploadedFile::fake()->image('buket.jpg'),
            ])
            ->assertRedirect();

        $product = $this->assertDatabaseHasProductAndGet('Buket Produk Baru');
        $this->assertDatabaseHas('products', [
            'name' => 'Buket Produk Baru',
            'stock' => 0,
            'status' => 'Habis',
        ]);
        Storage::disk('public')->assertExists($product->image);

        $this->put(route('products.update', $product), [
            'name' => 'Buket Produk Diperbarui',
            'category' => 'wisuda',
            'price' => 150000,
            'stock' => 8,
            'description' => 'Stok tersedia.',
        ])->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Buket Produk Diperbarui',
            'category' => 'wisuda',
            'stock' => 8,
            'status' => 'Ready',
        ]);

        $this->delete(route('products.destroy', $product))->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_creation_rejects_invalid_category_and_file_type(): void
    {
        $admin = $this->createEndorphineUser('admin', 'product-validation@example.com');

        $this->actingAs($admin)
            ->post(route('products.store'), [
                'name' => 'Produk Invalid',
                'category' => 'lainnya',
                'price' => 100000,
                'stock' => 1,
                'image' => UploadedFile::fake()->create('gambar.txt', 5, 'text/plain'),
            ])
            ->assertSessionHasErrors(['category', 'image']);

        $this->assertDatabaseMissing('products', ['name' => 'Produk Invalid']);
    }

    public function test_admin_can_update_banner_and_invalid_title_is_rejected(): void
    {
        $admin = $this->createEndorphineUser('admin', 'banner-admin@example.com');
        $slide = HeroSlide::query()->firstOrFail();

        $this->actingAs($admin)
            ->patch(route('admin.hero_slides.update', $slide), [
                'title' => 'Banner Uji Diperbarui',
                'eyebrow' => 'Promo',
                'description' => 'Deskripsi banner uji.',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('hero_slides', [
            'id' => $slide->id,
            'title' => 'Banner Uji Diperbarui',
            'is_active' => true,
        ]);

        $this->patch(route('admin.hero_slides.update', $slide), [
            'title' => '',
            'is_active' => true,
        ])->assertSessionHasErrors('title');
    }

    public function test_admin_can_manage_vouchers_and_duplicate_codes_are_rejected(): void
    {
        $admin = $this->createEndorphineUser('admin', 'voucher-admin@example.com');
        $payload = [
            'code' => 'PROMOHEMAT',
            'type' => 'fixed',
            'discount_value' => 15000,
            'min_order_price' => 50000,
            'quota' => 3,
            'expired_date' => now()->addDays(3)->toDateString(),
        ];

        $this->actingAs($admin)
            ->post(route('admin.vouchers.store'), $payload)
            ->assertRedirect();

        $this->assertDatabaseHas('vouchers', [
            'code' => 'PROMOHEMAT',
            'discount_value' => 15000,
            'quota' => 3,
            'is_active' => true,
        ]);

        $voucher = Voucher::query()->where('code', 'PROMOHEMAT')->firstOrFail();
        $this->post(route('admin.vouchers.store'), $payload)
            ->assertSessionHasErrors('code');

        $this->patch(route('admin.vouchers.toggle', $voucher))->assertRedirect();
        $this->assertFalse($voucher->fresh()->is_active);

        $this->delete(route('admin.vouchers.destroy', $voucher))->assertRedirect();
        $this->assertDatabaseMissing('vouchers', ['id' => $voucher->id]);
    }

    public function test_admin_can_manage_bank_accounts_and_empty_required_fields_are_rejected(): void
    {
        $admin = $this->createEndorphineUser('admin', 'bank-admin@example.com');

        $this->actingAs($admin)
            ->post(route('admin.bank_accounts.store'), [
                'bank_name' => 'BCA',
                'account_number' => '9876543210',
                'account_holder' => 'Endorphine Florist',
            ])
            ->assertRedirect();

        $account = BankAccount::query()->where('bank_name', 'BCA')->firstOrFail();
        $this->assertTrue($account->is_active);

        $this->post(route('admin.bank_accounts.store'), [
            'account_holder' => '',
        ])->assertSessionHasErrors(['bank_name', 'account_number', 'account_holder']);

        $this->patch(route('admin.bank_accounts.toggle', $account->id))->assertRedirect();
        $this->assertFalse($account->fresh()->is_active);

        $this->delete(route('admin.bank_accounts.destroy', $account))->assertRedirect();
        $this->assertDatabaseMissing('bank_accounts', ['id' => $account->id]);
    }

    public function test_admin_can_manage_staff_but_cannot_assign_owner_role_or_disable_self(): void
    {
        $admin = $this->createEndorphineUser('admin', 'staff-admin@example.com');
        $payload = [
            'name' => 'Kasir Baru',
            'email' => 'staff-new@example.com',
            'role' => 'kasir',
            'password' => 'ValidPass123!',
            'password_confirmation' => 'ValidPass123!',
        ];

        $this->actingAs($admin)
            ->post(route('admin.users.store'), $payload)
            ->assertRedirect(route('admin.users.index'));

        $staff = User::query()->where('email', $payload['email'])->firstOrFail();
        $this->assertSame('kasir', $staff->role);

        $this->put(route('admin.users.update', $staff->id), [
            'name' => 'Kasir Diperbarui',
            'email' => 'staff-new@example.com',
            'role' => 'admin',
        ])->assertRedirect(route('admin.users.index'));

        $this->put(route('admin.users.update', $staff->id), [
            'name' => 'Owner Tidak Diizinkan',
            'email' => 'staff-new@example.com',
            'role' => 'owner',
        ])->assertSessionHasErrors('role');

        $this->patch(route('admin.users.toggle-status', $staff->id))->assertRedirect();
        $this->assertFalse($staff->fresh()->is_active);

        $this->post(route('logout'));
        $this->post(route('login'), [
            'email' => $staff->email,
            'password' => 'ValidPass123!',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->actingAs($admin);
        $this->patch(route('admin.users.toggle-status', $admin->id))->assertForbidden();
    }

    private function assertDatabaseHasProductAndGet(string $name): Product
    {
        $this->assertDatabaseHas('products', ['name' => $name]);

        return Product::query()->where('name', $name)->firstOrFail();
    }
}
