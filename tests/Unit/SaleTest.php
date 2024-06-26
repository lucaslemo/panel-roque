<?php

namespace Tests\Unit;

use App\Models\Organization;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class SaleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of sale.
     */
    public function test_can_create_sale(): void
    {
        $sale = Sale::factory()->for(Organization::factory())->create();
        $this->assertNotNull($sale);
    }

    public function test_can_read_sale(): void
    {
        $sale = Sale::factory()->for(Organization::factory())->create();
        $searchId = $sale->id;

        $searchedSale = Sale::find($searchId);

        $this->assertNotNull($searchedSale);
        $this->assertTrue($sale->is($searchedSale));
    }

    public function test_can_update_sale(): void
    {
        $sale = Sale::factory()->for(Organization::factory())->create(['billing_date' => null]);
        $now = Carbon::now();
        $sale->billing_date = $now;
        $sale->save();
        $this->assertTrue($sale->billing_date->eq($now));
    }

    public function test_can_delete_sale(): void
    {
        $sale = Sale::factory()->for(Organization::factory())->create();
        $sale->delete();

        $this->assertSoftDeleted($sale);
    }
}
