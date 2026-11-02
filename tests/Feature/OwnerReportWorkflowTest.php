<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesEndorphineData;
use Tests\TestCase;

class OwnerReportWorkflowTest extends TestCase
{
    use CreatesEndorphineData;
    use RefreshDatabase;

    public function test_owner_report_filters_and_totals_paid_orders_for_selected_period(): void
    {
        $owner = $this->createEndorphineUser('owner', 'owner-report@example.com');
        $customer = $this->createEndorphineUser('pelanggan', 'report-customer@example.com');
        $this->createEndorphineOrder($customer, [
            'order_number' => 'E2E-REPORT-PAID',
            'total_price' => 175000,
            'payment_method' => 'QRIS',
            'payment_status' => 'paid',
            'status' => 'completed',
        ]);
        $this->createEndorphineOrder($customer, [
            'order_number' => 'E2E-REPORT-UNPAID',
            'total_price' => 90000,
        ]);

        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        $this->actingAs($owner)
            ->get(route('owner.reports', [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]))
            ->assertOk()
            ->assertSee('E2E-REPORT-PAID')
            ->assertSee('175.000')
            ->assertDontSee('E2E-REPORT-UNPAID');

        $this->get(route('owner.reports.chart', [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]))->assertOk();
    }

    public function test_owner_can_download_pdf_report_for_selected_period(): void
    {
        $owner = $this->createEndorphineUser('owner', 'owner-pdf@example.com');

        $response = $this->actingAs($owner)
            ->get(route('owner.export.pdf', [
                'start_date' => now()->startOfMonth()->toDateString(),
                'end_date' => now()->endOfMonth()->toDateString(),
            ]));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
        $this->assertStringContainsString('.pdf', $response->headers->get('content-disposition'));
    }
}
