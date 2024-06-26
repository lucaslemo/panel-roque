<?php

namespace Tests\Unit;

use App\Models\CreditLimit;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreditLimitTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Testing CRUD of credit limit.
     */
    public function test_can_create_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()->for(Organization::factory())->create();

        $this->assertNotNull($creditLimit);
    }

    public function test_can_read_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()->for(Organization::factory())->create();
        $searchId = $creditLimit->id;

        $searchedCreditLimit = CreditLimit::find($searchId);

        $this->assertNotNull($searchedCreditLimit);
        $this->assertTrue($creditLimit->is($searchedCreditLimit));
    }

    public function test_can_update_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()
            ->for(Organization::factory())
            ->create([
                'limit' => 10000,
                'used' => 5000,
                'reserved' => 1000,
                'available' => 4000,
            ]);

        $creditLimit->used += 2500;
        $creditLimit->reserved -= 500;
        $creditLimit->updateAvalible();
        $creditLimit->save();

        $this->assertEquals($creditLimit->available, 2000);
    }

    public function test_can_delete_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()->for(Organization::factory())->create();
        $creditLimit->delete();

        $this->assertSoftDeleted($creditLimit);
    }
}
