<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesEndorphineData;
use Tests\TestCase;

class RoleAccessWorkflowTest extends TestCase
{
    use CreatesEndorphineData;
    use RefreshDatabase;

    public function test_private_pages_require_login_and_role_specific_access(): void
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
        $this->get(route('owner.reports'))->assertRedirect(route('login'));
        $this->get(route('kasir.recap'))->assertRedirect(route('login'));

        $customer = $this->createEndorphineUser('pelanggan', 'access-customer@example.com');
        $admin = $this->createEndorphineUser('admin', 'access-admin@example.com');
        $cashier = $this->createEndorphineUser('kasir', 'access-cashier@example.com');
        $owner = $this->createEndorphineUser('owner', 'access-owner@example.com');

        $this->actingAs($customer)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('kasir.recap'))->assertForbidden();
        $this->actingAs($cashier)->get(route('owner.reports'))->assertForbidden();
        $this->actingAs($owner)->get(route('admin.bank_accounts.index'))->assertForbidden();

        $this->actingAs($owner)->get(route('owner.reports'))->assertOk();
        $this->get(route('admin.orders'))->assertOk();
    }
}
