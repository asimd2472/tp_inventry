<?php

namespace Tests\Feature;

use App\Models\SiteVisit;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteVisitRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_user_can_filter_site_visits_by_sales_manager_team(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $superUser = User::factory()->create();
        $superUser->assignRole('Super User');

        $manager = User::factory()->create(['name' => 'Manager A']);
        $manager->assignRole('Sales Manager');

        $executive = User::factory()->create([
            'name' => 'Executive B',
            'manager_id' => $manager->id,
        ]);
        $executive->assignRole('Sales Executive');

        $otherManager = User::factory()->create(['name' => 'Manager X']);
        $otherManager->assignRole('Sales Manager');

        SiteVisit::create([
            'user_id' => $manager->id,
            'visit_date' => '2026-08-01',
            'visit_time' => '10:00:00',
            'customer_name' => 'Customer A',
            'mobile' => '9000000001',
            'state' => 'State A',
            'district' => 'District A',
            'construction_stage' => 'Foundation',
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 10,
        ]);

        SiteVisit::create([
            'user_id' => $executive->id,
            'visit_date' => '2026-08-02',
            'visit_time' => '11:00:00',
            'customer_name' => 'Customer B',
            'mobile' => '9000000002',
            'state' => 'State B',
            'district' => 'District B',
            'construction_stage' => 'Structure',
            'products' => ['Windows'],
            'timeline' => '2 months',
            'interest' => 'Medium',
            'qty_total' => 5,
        ]);

        SiteVisit::create([
            'user_id' => $otherManager->id,
            'visit_date' => '2026-08-03',
            'visit_time' => '12:00:00',
            'customer_name' => 'Customer X',
            'mobile' => '9000000003',
            'state' => 'State X',
            'district' => 'District X',
            'construction_stage' => 'Finishing',
            'products' => ['Frames'],
            'timeline' => '3 months',
            'interest' => 'Low',
            'qty_total' => 3,
        ]);

        $response = $this->actingAs($superUser)
            ->getJson('/admin/site-visit-record/data?sales_manager=' . $manager->id);

        $response->assertOk();
        $response->assertJsonPath('totalVisits', 2);
        $response->assertJsonPath('uniqueCustomers', 2);
        $response->assertJsonPath('highPotentialCustomers', 2);
        $response->assertJsonPath('estimatedProducts', 15);
    }

    public function test_sales_manager_can_filter_site_visits_by_sales_executive(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $manager = User::factory()->create();
        $manager->assignRole('Sales Manager');

        $executiveOne = User::factory()->create([
            'manager_id' => $manager->id,
        ]);
        $executiveOne->assignRole('Sales Executive');

        $executiveTwo = User::factory()->create([
            'manager_id' => $manager->id,
        ]);
        $executiveTwo->assignRole('Sales Executive');

        SiteVisit::create([
            'user_id' => $executiveOne->id,
            'visit_date' => '2026-08-04',
            'visit_time' => '09:00:00',
            'customer_name' => 'Customer One',
            'mobile' => '9111111111',
            'state' => 'State 1',
            'district' => 'District 1',
            'construction_stage' => 'Foundation',
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 8,
        ]);

        SiteVisit::create([
            'user_id' => $executiveTwo->id,
            'visit_date' => '2026-08-05',
            'visit_time' => '10:00:00',
            'customer_name' => 'Customer Two',
            'mobile' => '9222222222',
            'state' => 'State 2',
            'district' => 'District 2',
            'construction_stage' => 'Structure',
            'products' => ['Windows'],
            'timeline' => '2 months',
            'interest' => 'Low',
            'qty_total' => 4,
        ]);

        $response = $this->actingAs($manager)
            ->getJson('/admin/site-visit-record/data?sales_executive=' . $executiveOne->id);

        $response->assertOk();
        $response->assertJsonPath('totalVisits', 1);
        $response->assertJsonPath('uniqueCustomers', 1);
        $response->assertJsonPath('highPotentialCustomers', 1);
        $response->assertJsonPath('estimatedProducts', 8);
        $this->assertSame('Customer One', $response->json('items.0.customer_name'));
    }

    public function test_sales_manager_can_export_filtered_site_visit_csv(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $manager = User::factory()->create();
        $manager->assignRole('Sales Manager');

        $executiveOne = User::factory()->create([
            'manager_id' => $manager->id,
            'name' => 'Executive One',
        ]);
        $executiveOne->assignRole('Sales Executive');

        $executiveTwo = User::factory()->create([
            'manager_id' => $manager->id,
            'name' => 'Executive Two',
        ]);
        $executiveTwo->assignRole('Sales Executive');

        SiteVisit::create([
            'user_id' => $executiveOne->id,
            'visit_date' => '2026-08-04',
            'visit_time' => '09:00:00',
            'customer_name' => 'Customer One',
            'mobile' => '9111111111',
            'state' => 'State 1',
            'district' => 'District 1',
            'construction_stage' => 'Foundation',
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 8,
        ]);

        SiteVisit::create([
            'user_id' => $executiveTwo->id,
            'visit_date' => '2026-08-12',
            'visit_time' => '10:00:00',
            'customer_name' => 'Customer Two',
            'mobile' => '9222222222',
            'state' => 'State 2',
            'district' => 'District 2',
            'construction_stage' => 'Structure',
            'products' => ['Windows'],
            'timeline' => '2 months',
            'interest' => 'Low',
            'qty_total' => 4,
        ]);

        $response = $this->actingAs($manager)
            ->get(route('admin.site_visit_record.export', [
                'type' => 'csv',
                'date_from' => '2026-08-01',
                'date_to' => '2026-08-10',
                'sales_executive' => [$executiveOne->id],
                'export_mode' => 'individual',
            ]));

        $response->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Customer One', $response->streamedContent());
    }

    public function test_super_user_can_export_filtered_site_visit_csv(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $superUser = User::factory()->create();
        $superUser->assignRole('Super User');

        $managerOne = User::factory()->create(['name' => 'Manager One']);
        $managerOne->assignRole('Sales Manager');

        $managerTwo = User::factory()->create(['name' => 'Manager Two']);
        $managerTwo->assignRole('Sales Manager');

        $executive = User::factory()->create([
            'name' => 'Executive A',
            'manager_id' => $managerOne->id,
        ]);
        $executive->assignRole('Sales Executive');

        SiteVisit::create([
            'user_id' => $executive->id,
            'visit_date' => '2026-08-08',
            'visit_time' => '09:00:00',
            'customer_name' => 'Customer A',
            'mobile' => '9333333333',
            'state' => 'State A',
            'district' => 'District A',
            'construction_stage' => 'Foundation',
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 9,
        ]);

        SiteVisit::create([
            'user_id' => $managerTwo->id,
            'visit_date' => '2026-08-09',
            'visit_time' => '11:00:00',
            'customer_name' => 'Customer B',
            'mobile' => '9444444444',
            'state' => 'State B',
            'district' => 'District B',
            'construction_stage' => 'Structure',
            'products' => ['Windows'],
            'timeline' => '2 months',
            'interest' => 'Medium',
            'qty_total' => 6,
        ]);

        $response = $this->actingAs($superUser)
            ->get(route('admin.site_visit_record.export', [
                'type' => 'csv',
                'date_from' => '2026-08-01',
                'date_to' => '2026-08-10',
                'sales_manager' => [$managerOne->id],
                'export_mode' => 'consolidated',
            ]));

        $response->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Customer A', $response->streamedContent());
    }

    public function test_authorized_user_can_view_site_visit_details(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $executive = User::factory()->create();
        $executive->assignRole('Sales Executive');

        $visit = SiteVisit::create([
            'user_id' => $executive->id,
            'visit_date' => '2026-08-04',
            'visit_time' => '09:00:00',
            'customer_name' => 'Customer Details',
            'mobile' => '9111111111',
            'state' => 'State 1',
            'district' => 'District 1',
            'construction_stage' => 'Foundation',
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 8,
        ]);

        $this->actingAs($executive)
            ->get(route('admin.site_visit_record.show', $visit->id))
            ->assertOk()
            ->assertSee('Customer Details')
            ->assertSee('Foundation');
    }

    public function test_listing_groups_customer_visits_and_details_can_switch_history(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $executive = User::factory()->create();
        $executive->assignRole('Sales Executive');

        $visits = collect([
            ['date' => '2026-08-04', 'stage' => 'Foundation'],
            ['date' => '2026-08-12', 'stage' => 'Structure'],
            ['date' => '2026-08-20', 'stage' => 'Finishing'],
        ])->map(fn (array $data) => SiteVisit::create([
            'user_id' => $executive->id,
            'visit_date' => $data['date'],
            'visit_time' => '09:00:00',
            'customer_name' => 'Repeat Customer',
            'mobile' => '9111111111',
            'state' => 'State 1',
            'district' => 'District 1',
            'construction_stage' => $data['stage'],
            'products' => ['Doors'],
            'timeline' => '1 month',
            'interest' => 'High',
            'qty_total' => 8,
        ]));

        $listing = $this->actingAs($executive)
            ->getJson(route('admin.site_visit_record.data'));

        $listing->assertOk()
            ->assertJsonPath('pagination.total', 1)
            ->assertJsonPath('items.0.id', $visits[2]->id)
            ->assertJsonPath('items.0.visit_number_label', '3rd visit')
            ->assertJsonPath('items.0.total_visits', 3);

        $this->actingAs($executive)
            ->get(route('admin.site_visit_record.show', $visits[2]->id))
            ->assertOk()
            ->assertSee('3rd visit')
            ->assertSee('Finishing')
            ->assertSee('2nd visit');

        $this->actingAs($executive)
            ->get(route('admin.site_visit_record.show', [$visits[2]->id, 'visit_id' => $visits[1]->id]))
            ->assertOk()
            ->assertSee('Structure')
            ->assertSee('aria-selected="true"', false);
    }
}
