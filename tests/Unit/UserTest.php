<?php

namespace Tests\Unit;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
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
    public function test_has_customers(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $userWithCustomers = User::factory()->has(Customer::factory()->count(2))->create();

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseCount('users_has_customers', 2);

        $this->assertDatabaseHas('users_has_customers', ['idUsuario' => $userWithCustomers->id]);

        $this->assertDatabaseMissing('users_has_customers', ['idUsuario' => $user->id]);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_customers_that_has_sales(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()
            ->has(Customer::factory()
                    ->count(2)
                    ->has(CreditLimit::factory())
                    ->has(Invoice::factory())
                    ->has(Order::factory()->count(2))
                )->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('credit_limits', 2);
        $this->assertDatabaseCount('customers', 2);
        $this->assertDatabaseCount('orders', 4);
        $this->assertDatabaseCount('invoices', 2);
        $this->assertDatabaseHas('users_has_customers', ['idUsuario' => $user->id]);
    }
}
