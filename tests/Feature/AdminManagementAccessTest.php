<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminManagementAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_is_limited_to_monitoring_while_admin_can_open_management_pages(): void
    {
        $owner = $this->createUser('owner', 'owner-access@example.com');
        $admin = $this->createUser('admin', 'admin-access@example.com');

        $this->actingAs($owner)
            ->get(route('owner.dashboard'))
            ->assertOk()
            ->assertDontSee('Kelola Slide Beranda')
            ->assertDontSee('Kelola Voucher');

        foreach ([
            route('products.index'),
            route('admin.users.index'),
            route('admin.bank_accounts.index'),
            route('admin.hero_slides.index'),
            route('admin.vouchers.index'),
        ] as $managementUrl) {
            $this->get($managementUrl)->assertForbidden();
        }

        $this->get(route('admin.orders'))->assertOk();
        $this->assertFalse(Route::has('owner.users.index'));
        $this->assertFalse(Route::has('owner.vouchers.index'));
        $this->assertFalse(Route::has('owner.bank_accounts.index'));
        $this->assertFalse(Route::has('owner.hero_slides.index'));

        $this->actingAs($admin);
        foreach ([
            route('admin.users.index'),
            route('admin.bank_accounts.index'),
            route('admin.hero_slides.index'),
            route('admin.vouchers.index'),
        ] as $managementUrl) {
            $this->get($managementUrl)->assertOk();
        }
    }

    public function test_owner_account_is_read_only_in_account_management(): void
    {
        $admin = $this->createUser('admin', 'admin-owner-lock@example.com');
        $owner = $this->createUser('owner', 'owner-lock@example.com');

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Owner · Hanya lihat')
            ->assertDontSee(route('admin.users.edit', $owner->id), false);

        $this->get(route('admin.users.edit', $owner->id))
            ->assertForbidden();

        $this->put(route('admin.users.update', $owner->id), [
            'name' => 'Owner Diubah',
            'email' => 'owner-lock@example.com',
            'role' => 'admin',
        ])->assertForbidden();

        $this->patch(route('admin.users.toggle-status', $owner->id))
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'name' => 'owner',
            'role' => 'owner',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_edit_admin_and_cashier_accounts_but_cannot_assign_owner_role(): void
    {
        $admin = $this->createUser('admin', 'admin-edit@example.com');
        $staff = $this->createUser('kasir', 'staff-edit@example.com');

        $this->actingAs($admin)
            ->put(route('admin.users.update', $staff->id), [
                'name' => 'Kasir Diperbarui',
                'email' => 'staff-edit@example.com',
                'role' => 'admin',
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'name' => 'Kasir Diperbarui',
            'role' => 'admin',
        ]);

        $this->put(route('admin.users.update', $staff->id), [
            'name' => 'Tidak Boleh Jadi Owner',
            'email' => 'staff-edit@example.com',
            'role' => 'owner',
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', [
            'id' => $staff->id,
            'role' => 'owner',
        ]);

        $this->post(route('admin.users.store'), [
            'name' => 'Owner Baru',
            'email' => 'owner-created-by-admin@example.com',
            'role' => 'owner',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('role');
    }

    private function createUser(string $role, string $email): User
    {
        return User::create([
            'name' => $role,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
    }
}
