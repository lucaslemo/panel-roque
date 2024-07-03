<?php

namespace Tests\Unit;

use App\Models\BillToReceive;
use App\Models\Branch;
use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\IndependentSalesRepresentative;
use App\Models\Invoice;
use App\Models\Order;
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
    public function test_has_customers(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $userWithOrganizations = User::factory()->has(Customer::factory()->count(2))->create();

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseCount('usuariosPossuemClientes', 2);

        $this->assertDatabaseHas('usuariosPossuemClientes', ['idUsuario' => $userWithOrganizations->id]);

        $this->assertDatabaseMissing('usuariosPossuemClientes', ['idUsuario' => $user->id]);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_organizations_that_has_sales(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()
            ->has(Customer::factory()
                    ->count(2)
                    ->has(CreditLimit::factory())
                    ->has(Invoice::factory()
                        ->for(Branch::factory())->count(10))
                    ->has(Order::factory()
                        ->count(2)
                        ->for(Branch::factory())
                        ->for(IndependentSalesRepresentative::factory()))
                )->create();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('limitesDeCredito', 2);
        $this->assertDatabaseCount('clientes', 2);
        $this->assertDatabaseCount('pedidosCabecalhos', 4);
        $this->assertDatabaseCount('contas', 20);
        $this->assertDatabaseHas('usuariosPossuemClientes', ['idUsuario' => $user->id]);
    }
}
