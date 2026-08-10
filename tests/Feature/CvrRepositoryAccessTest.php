<?php

namespace Tests\Feature;

use App\Models\CvrDetails;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CvrRepositoryAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_manager_sees_own_and_team_cvr_records_in_all_tab(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $manager = User::factory()->create();
        $manager->assignRole('Sales Manager');
        $manager->givePermissionTo('repository');

        $executive = User::factory()->create([
            'manager_id' => $manager->id,
        ]);
        $executive->assignRole('Sales Executive');
        $executive->givePermissionTo('repository');

        $otherUser = User::factory()->create();
        $otherUser->assignRole('Sales Executive');
        $otherUser->givePermissionTo('repository');

        CvrDetails::create([
            'user_id' => $manager->id,
            'cvr_id' => 'CVR-MANAGER-1',
            'host' => 'Dealer Manager',
            'distributor' => 'Distributor A',
            'location' => 'Location A',
            'visitor' => 'Visitor A',
            'contact_no' => '1111111111',
            'visitor_date' => '2026-08-01',
            'cvr_data' => ['summary' => 'Manager summary', 'sentiment' => 'Positive'],
        ]);

        CvrDetails::create([
            'user_id' => $executive->id,
            'cvr_id' => 'CVR-EXEC-1',
            'host' => 'Dealer Executive',
            'distributor' => 'Distributor B',
            'location' => 'Location B',
            'visitor' => 'Visitor B',
            'contact_no' => '2222222222',
            'visitor_date' => '2026-08-02',
            'cvr_data' => ['summary' => 'Executive summary', 'sentiment' => 'Neutral'],
        ]);

        CvrDetails::create([
            'user_id' => $otherUser->id,
            'cvr_id' => 'CVR-OTHER-1',
            'host' => 'Dealer Other',
            'distributor' => 'Distributor C',
            'location' => 'Location C',
            'visitor' => 'Visitor C',
            'contact_no' => '3333333333',
            'visitor_date' => '2026-08-03',
            'cvr_data' => ['summary' => 'Other summary', 'sentiment' => 'Negative'],
        ]);

        $response = $this->actingAs($manager)
            ->getJson('/admin/cvr/repository-data?tab=all');

        $response->assertOk();
        $this->assertCount(2, $response->json('items'));
        $this->assertEqualsCanonicalizing(
            ['Dealer Manager', 'Dealer Executive'],
            collect($response->json('items'))->pluck('dealer')->all()
        );
    }

    public function test_sales_executive_sees_only_his_own_cvr_records(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $manager = User::factory()->create();
        $manager->assignRole('Sales Manager');
        $manager->givePermissionTo('repository');

        $executive = User::factory()->create([
            'manager_id' => $manager->id,
        ]);
        $executive->assignRole('Sales Executive');
        $executive->givePermissionTo('repository');

        CvrDetails::create([
            'user_id' => $executive->id,
            'cvr_id' => 'CVR-EXEC-ONLY',
            'host' => 'Dealer Exec Only',
            'distributor' => 'Distributor E',
            'location' => 'Location E',
            'visitor' => 'Visitor E',
            'contact_no' => '4444444444',
            'visitor_date' => '2026-08-04',
            'cvr_data' => ['summary' => 'Executive only summary', 'sentiment' => 'Positive'],
        ]);

        CvrDetails::create([
            'user_id' => $manager->id,
            'cvr_id' => 'CVR-MANAGER-LIMITED',
            'host' => 'Dealer Manager Hidden',
            'distributor' => 'Distributor M',
            'location' => 'Location M',
            'visitor' => 'Visitor M',
            'contact_no' => '5555555555',
            'visitor_date' => '2026-08-05',
            'cvr_data' => ['summary' => 'Manager summary hidden', 'sentiment' => 'Positive'],
        ]);

        $response = $this->actingAs($executive)
            ->getJson('/admin/cvr/repository-data?tab=all');

        $response->assertOk();
        $this->assertCount(1, $response->json('items'));
        $this->assertSame('Dealer Exec Only', $response->json('items.0.dealer'));
    }
}
