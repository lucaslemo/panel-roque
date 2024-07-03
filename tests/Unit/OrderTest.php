<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\IndependentSalesRepresentative;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of order.
     */
    public function test_can_create_order(): void
    {
        $order = Order::factory()
            ->for(IndependentSalesRepresentative::factory())
            ->for(Customer::factory())
            ->for(Branch::factory())
            ->create();
        $this->assertNotNull($order);
    }

    public function test_can_read_order(): void
    {
        $order = Order::factory()
            ->for(IndependentSalesRepresentative::factory())
            ->for(Customer::factory())
            ->for(Branch::factory())
            ->create();
        $searchId = $order->idPedidoCabecalho;

        $searchedSale = Order::find($searchId);

        $this->assertNotNull($searchedSale);
        $this->assertTrue($order->is($searchedSale));
    }

    public function test_can_update_order(): void
    {
        $order = Order::factory()
            ->for(IndependentSalesRepresentative::factory())
            ->for(Customer::factory())
            ->for(Branch::factory())
            ->create(['dtFaturamento' => null]);
        $now = Carbon::now();
        $order->dtFaturamento = $now;
        $order->save();
        $this->assertTrue($order->dtFaturamento->eq($now));
    }

    public function test_can_delete_order(): void
    {
        $order = Order::factory()
            ->for(IndependentSalesRepresentative::factory())
            ->for(Customer::factory())
            ->for(Branch::factory())
            ->create();
        $order->delete();

        $this->assertSoftDeleted($order);
    }
}
