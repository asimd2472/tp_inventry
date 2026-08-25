<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SiteVisitStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_site_visit_can_be_submitted_via_ajax(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $executive = User::factory()->create();
        $executive->assignRole('Sales Executive');

        $payload = [
            'visit_date' => '2026-08-10',
            'visit_time' => '14:30',
            'customer_name' => 'Test Customer',
            'mobile' => '9876543210',
            'state' => 'Maharashtra',
            'district' => 'Mumbai',
            'construction_stage' => 'Foundation / Site Preparation',
            'products' => ['Doors'],
            'timeline' => 'Within 1 Month',
            'interest' => 'High',
            'qty' => [
                'doors' => 2,
                'windows' => 1,
                'frames' => 0,
                'others' => 0,
            ],
        ];

        $response = $this->actingAs($executive)
            ->postJson('/admin/site-visit-store', $payload);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['message', 'visit_id', 'redirect_url']);

        $this->assertDatabaseHas('site_visits', [
            'user_id' => $executive->id,
            'customer_name' => 'Test Customer',
            'mobile' => '9876543210',
            'qty_total' => 3,
        ]);
    }

    public function test_follow_up_requires_a_date_when_enabled(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $executive = User::factory()->create();
        $executive->assignRole('Sales Executive');

        $payload = [
            'visit_date' => '2026-08-10',
            'visit_time' => '14:30',
            'customer_name' => 'Test Customer',
            'mobile' => '9876543210',
            'state' => 'Maharashtra',
            'district' => 'Mumbai',
            'construction_stage' => 'Foundation / Site Preparation',
            'products' => ['Doors'],
            'timeline' => 'Within 1 Month',
            'interest' => 'High',
            'follow_up' => 'Yes',
            'qty' => [
                'doors' => 1,
                'windows' => 0,
                'frames' => 0,
                'others' => 0,
            ],
        ];

        $response = $this->actingAs($executive)
            ->postJson('/admin/site-visit-store', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['follow_update']);

        $payload['follow_update'] = '2026-08-20';

        $response = $this->actingAs($executive)
            ->postJson('/admin/site-visit-store', $payload);

        $response->assertOk();
        $this->assertDatabaseHas('site_visits', [
            'user_id' => $executive->id,
            'customer_name' => 'Test Customer',
            'follow_up' => true,
            'follow_update' => '2026-08-20',
        ]);
    }

    public function test_dropped_lead_requires_and_stores_drop_reasons(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $executive = User::factory()->create();
        $executive->assignRole('Sales Executive');

        $payload = [
            'visit_date' => '2026-08-10',
            'visit_time' => '14:30',
            'customer_name' => 'Dropped Customer',
            'mobile' => '9876543210',
            'state' => 'Maharashtra',
            'district' => 'Mumbai',
            'construction_stage' => 'Foundation / Site Preparation',
            'products' => ['Doors'],
            'timeline' => 'Within 1 Month',
            'interest' => 'Low',
            'lead_status' => ['Dropped / Lost'],
            'qty' => ['doors' => 1],
        ];

        $response = $this->actingAs($executive)->postJson('/admin/site-visit-store', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['drop_reasons']);

        $payload['intermediary_name'] = 'A. Sharma';
        $payload['intermediary_type'] = 'Architect';
        $payload['drop_reasons'] = ['Price too high', 'Other'];
        $payload['drop_reason_other'] = 'Budget was not approved';

        $response = $this->actingAs($executive)->postJson('/admin/site-visit-store', $payload);

        $response->assertOk();
        $this->assertDatabaseHas('site_visits', [
            'customer_name' => 'Dropped Customer',
            'intermediary_name' => 'A. Sharma',
            'intermediary_type' => 'Architect',
            'drop_reason_other' => 'Budget was not approved',
        ]);

        $this->assertSame(
            ['Dropped / Lost'],
            json_decode((string) DB::table('site_visits')->where('customer_name', 'Dropped Customer')->value('lead_status'), true)
        );
    }
}
