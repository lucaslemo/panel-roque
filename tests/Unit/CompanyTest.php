<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of branch.
     */
    public function test_can_create_company(): void
    {
        $company = Company::factory()->create();

        $this->assertNotNull($company);
    }

    public function test_can_read_company(): void
    {
        $company = Company::factory()->create();
        $searchId = $company->idFilial;

        $searchedCompany = Company::find($searchId);

        $this->assertNotNull($searchedCompany);
        $this->assertTrue($company->is($searchedCompany));
    }

    public function test_can_update_company(): void
    {
        $company = Company::factory()
            ->create(['nmFilial' => 'Filial - 1']);

        $company->nmFilial = 'Filial - 2';
        $company->save();

        $this->assertEquals($company->nmFilial, 'Filial - 2');
    }

    public function test_can_delete_company(): void
    {
        $company = Company::factory()->create();
        $company->delete();

        $this->assertSoftDeleted($company);
    }
}
