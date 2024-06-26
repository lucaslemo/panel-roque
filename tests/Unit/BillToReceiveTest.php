<?php

namespace Tests\Unit;

use App\Models\BillToReceive;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillToReceiveTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of bill to receive.
     */
    public function test_can_create_bill_to_receive(): void
    {
        $billToReceive = BillToReceive::factory()->for(Organization::factory())->create();
        $this->assertNotNull($billToReceive);
    }

    public function test_can_read_bill_to_receive(): void
    {
        $billToReceive = BillToReceive::factory()->for(Organization::factory())->create();
        $searchId = $billToReceive->id;

        $searchedBillToReceive = BillToReceive::find($searchId);

        $this->assertNotNull($searchedBillToReceive);
        $this->assertTrue($billToReceive->is($searchedBillToReceive));
    }

    public function test_can_update_bill_to_receive(): void
    {
        $billToReceive = BillToReceive::factory()->for(Organization::factory())->create(['payment_date' => null]);
        $now = Carbon::now();
        $billToReceive->payment_date = $now;
        $billToReceive->save();
        $this->assertTrue($billToReceive->payment_date->eq($now));
    }

    public function test_can_delete_bill_to_receive(): void
    {
        $billToReceive = BillToReceive::factory()->for(Organization::factory())->create();
        $billToReceive->delete();

        $this->assertSoftDeleted($billToReceive);
    }
}
