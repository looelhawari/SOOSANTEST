<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    /**
     * Test that the reports index page loads successfully for admin users
     */
    public function test_reports_index_loads_for_admin()
    {
        $adminUser = \App\Models\User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($adminUser)
                        ->get('/admin/reports');

        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.index');
    }

    /**
     * Test that regular employees cannot access reports
     */
    public function test_reports_denied_for_employees()
    {
        $employee = \App\Models\User::factory()->create([
            'role' => 'employee'
        ]);

        $response = $this->actingAs($employee)
                        ->get('/admin/reports');

        $response->assertStatus(403);
    }

    /**
     * Test that CEO users can access reports
     */
    public function test_reports_accessible_for_ceo()
    {
        $ceoUser = \App\Models\User::factory()->create([
            'role' => 'ceo'
        ]);

        $response = $this->actingAs($ceoUser)
                        ->get('/admin/reports');

        $response->assertStatus(200);
    }

    /**
     * Test comprehensive report download
     */
    public function test_comprehensive_report_download()
    {
        $adminUser = \App\Models\User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($adminUser)
                        ->get('/admin/reports/comprehensive?period=last_30_days');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test owners report download
     */
    public function test_owners_report_download()
    {
        $adminUser = \App\Models\User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($adminUser)
                        ->get('/admin/reports/owners?period=last_30_days');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test sales report download
     */
    public function test_sales_report_download()
    {
        $adminUser = \App\Models\User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($adminUser)
                        ->get('/admin/reports/sales?period=last_30_days');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test custom date range functionality
     */
    public function test_custom_date_range_reports()
    {
        $adminUser = \App\Models\User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($adminUser)
                        ->get('/admin/reports/comprehensive?period=custom&start_date=2024-01-01&end_date=2024-12-31');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
