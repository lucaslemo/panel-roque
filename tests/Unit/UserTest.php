<?php

namespace Tests\Unit;

use App\Models\BillToReceive;
use App\Models\CreditLimit;
use App\Models\User;
use App\Models\Organization;
use App\Models\Sale;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of user.
     */
    public function test_can_create_user(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();
        $this->assertNotNull($user);
    }

    public function test_can_read_user(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();
        $searchId = $user->id;

        $searchedUser = User::find($searchId);

        $this->assertNotNull($searchedUser);
        $this->assertTrue($user->is($searchedUser));
    }

    public function test_can_update_user(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create(['name' => 'User']);
        $user->name = 'Other-User';
        $user->save();
        $this->assertEquals($user->name, 'Other-User');
    }

    public function test_can_delete_user(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();
        $user->delete();

        $this->assertSoftDeleted($user);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_organizations(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $userWithOrganizations = User::factory()->has(Organization::factory()->count(2))->create();
           
        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseCount('users_has_organizations', 2);
        
        $this->assertDatabaseHas('users_has_organizations', [
            'get_user_id' => $userWithOrganizations->id,
        ]);

        $this->assertDatabaseMissing('users_has_organizations', ['get_user_id' => $user->id]);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_organizations_that_has_sales(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()
            ->has(
                Organization::factory()
                    ->count(2)
                    ->has(CreditLimit::factory())
                    ->has(Sale::factory()->count(2)->has(BillToReceive::factory()->count(5), 'billsToReceive'))
            )
            ->create();
           
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('credit_limits', 2);
        $this->assertDatabaseCount('organizations', 2);
        $this->assertDatabaseCount('sales', 4);
        $this->assertDatabaseCount('bills_to_receive', 20);
        $this->assertDatabaseHas('users_has_organizations', ['get_user_id' => $user->id]);
    }
}
