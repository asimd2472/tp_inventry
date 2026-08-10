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

    public function test_super_user_can_filter_cvr_by_sales_manager_team(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $superUser = User::factory()->create();
        $superUser->assignRole('Super User');
        $superUser->givePermissionTo('repository');

        $manager = User::factory()->create(['name' => 'Manager A']);
        $manager->assignRole('Sales Manager');
        $manager->givePermissionTo('repository');

        $executive = User::factory()->create([
            'name' => 'Executive B',
            'manager_id' => $manager->id,
        ]);
        $executive->assignRole('Sales Executive');
        $executive->givePermissionTo('repository');

        $otherManager = User::factory()->create(['name' => 'Manager X']);
        $otherManager->assignRole('Sales Manager');
        $otherManager->givePermissionTo('repository');

        CvrDetails::create([
            'user_id' => $manager->id,
            'cvr_id' => 'CVR-MANAGER-A',
            'host' => 'Dealer Manager A',
            'distributor' => 'Distributor A',
            'location' => 'Location A',
            'visitor' => 'Visitor A',
            'contact_no' => '1111111111',
            'visitor_date' => '2026-08-01',
            'cvr_data' => ['summary' => 'Manager A summary', 'sentiment' => 'Positive'],
        ]);

        CvrDetails::create([
            'user_id' => $executive->id,
            'cvr_id' => 'CVR-EXEC-B',
            'host' => 'Dealer Executive B',
            'distributor' => 'Distributor B',
            'location' => 'Location B',
            'visitor' => 'Visitor B',
            'contact_no' => '2222222222',
            'visitor_date' => '2026-08-02',
            'cvr_data' => ['summary' => 'Executive B summary', 'sentiment' => 'Neutral'],
        ]);

        CvrDetails::create([
            'user_id' => $otherManager->id,
            'cvr_id' => 'CVR-MANAGER-X',
            'host' => 'Dealer Manager X',
            'distributor' => 'Distributor X',
            'location' => 'Location X',
            'visitor' => 'Visitor X',
            'contact_no' => '3333333333',
            'visitor_date' => '2026-08-03',
            'cvr_data' => ['summary' => 'Manager X summary', 'sentiment' => 'Negative'],
        ]);

        $response = $this->actingAs($superUser)
            ->getJson('/admin/cvr/repository-data?tab=all&sales_manager=' . $manager->id);

        $response->assertOk();
        $this->assertCount(2, $response->json('items'));
        $this->assertEqualsCanonicalizing(
            ['Dealer Manager A', 'Dealer Executive B'],
            collect($response->json('items'))->pluck('dealer')->all()
        );
    }

    public function test_sales_manager_can_filter_cvr_by_sales_executive(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $manager = User::factory()->create();
        $manager->assignRole('Sales Manager');
        $manager->givePermissionTo('repository');

        $executiveOne = User::factory()->create([
            'name' => 'Executive One',
            'manager_id' => $manager->id,
        ]);
        $executiveOne->assignRole('Sales Executive');
        $executiveOne->givePermissionTo('repository');

        $executiveTwo = User::factory()->create([
            'name' => 'Executive Two',
            'manager_id' => $manager->id,
        ]);
        $executiveTwo->assignRole('Sales Executive');
        $executiveTwo->givePermissionTo('repository');

        CvrDetails::create([
            'user_id' => $manager->id,
            'cvr_id' => 'CVR-MANAGER-OWN',
            'host' => 'Dealer Manager Own',
            'distributor' => 'Distributor M',
            'location' => 'Location M',
            'visitor' => 'Visitor M',
            'contact_no' => '4444444444',
            'visitor_date' => '2026-08-04',
            'cvr_data' => ['summary' => 'Manager own summary', 'sentiment' => 'Positive'],
        ]);

        CvrDetails::create([
            'user_id' => $executiveOne->id,
            'cvr_id' => 'CVR-EXEC-ONE',
            'host' => 'Dealer Executive One',
            'distributor' => 'Distributor E1',
            'location' => 'Location E1',
            'visitor' => 'Visitor E1',
            'contact_no' => '5555555555',
            'visitor_date' => '2026-08-05',
            'cvr_data' => ['summary' => 'Executive one summary', 'sentiment' => 'Positive'],
        ]);

        CvrDetails::create([
            'user_id' => $executiveTwo->id,
            'cvr_id' => 'CVR-EXEC-TWO',
            'host' => 'Dealer Executive Two',
            'distributor' => 'Distributor E2',
            'location' => 'Location E2',
            'visitor' => 'Visitor E2',
            'contact_no' => '6666666666',
            'visitor_date' => '2026-08-06',
            'cvr_data' => ['summary' => 'Executive two summary', 'sentiment' => 'Neutral'],
        ]);

        $response = $this->actingAs($manager)
            ->getJson('/admin/cvr/repository-data?tab=all&sales_executive=' . $executiveOne->id);

        $response->assertOk();
        $this->assertCount(1, $response->json('items'));
        $this->assertSame('Dealer Executive One', $response->json('items.0.dealer'));
    }
}
