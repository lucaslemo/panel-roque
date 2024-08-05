<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of customer.
     */
    public function test_can_create_customer(): void
    {
        $customer = Customer::factory()->create();
        $this->assertNotNull($customer);
    }

    public function test_can_read_customer(): void
    {
        $customer = Customer::factory()->create();
        $searchId = $customer->idCliente;

        $searchedCustomer = Customer::find($searchId);

        $this->assertNotNull($searchedCustomer);
        $this->assertTrue($customer->is($searchedCustomer));
    }

    public function test_can_update_customer(): void
    {
        $customer = Customer::factory()->create(['nmCliente' => 'Customer']);
        $customer->nmCliente = 'Other-Customer';
        $customer->save();
        $this->assertEquals($customer->nmCliente, 'Other-Customer');
    }

    public function test_can_delete_customer(): void
    {
        $customer = Customer::factory()->create();
        $customer->delete();

        $this->assertSoftDeleted($customer);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_invoices(): void
    {
        Customer::factory()
            ->has(Invoice::factory())
            ->create();

        Invoice::factory()
            ->for(Customer::factory())->create();

        $this->assertDatabaseCount('invoices', 2);
    }
}
