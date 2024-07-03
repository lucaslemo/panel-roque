<?php

namespace Tests\Unit;

use App\Models\CreditLimit;
use App\Models\Customer;
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
        $creditLimit = CreditLimit::factory()->for(Customer::factory())->create();

        $this->assertNotNull($creditLimit);
    }

    public function test_can_read_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()->for(Customer::factory())->create();
        $searchId = $creditLimit->idLimiteDeCredito;

        $searchedCreditLimit = CreditLimit::find($searchId);

        $this->assertNotNull($searchedCreditLimit);
        $this->assertTrue($creditLimit->is($searchedCreditLimit));
    }

    public function test_can_update_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()
            ->for(Customer::factory())
            ->create([
                'vrLimite' => 10000,
                'vrUtilizado' => 5000,
                'vrReservado' => 1000,
                'vrDisponivel' => 4000,
            ]);

        $creditLimit->vrUtilizado += 2500;
        $creditLimit->vrReservado -= 500;
        $creditLimit->updateAvailable();
        $creditLimit->save();

        $this->assertEquals($creditLimit->vrDisponivel, 2000);
    }

    public function test_can_delete_credit_limit(): void
    {
        $creditLimit = CreditLimit::factory()->for(Customer::factory())->create();
        $creditLimit->delete();

        $this->assertSoftDeleted($creditLimit);
    }
}
