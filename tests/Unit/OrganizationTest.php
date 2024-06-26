<?php

namespace Tests\Unit;

use App\Models\BillToReceive;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of organization.
     */
    public function test_can_create_organization(): void
    {
        $organization = Organization::factory()->create();
        $this->assertNotNull($organization);
    }

    public function test_can_read_organization(): void
    {
        $organization = Organization::factory()->create();
        $searchId = $organization->id;

        $searchedOrganization = Organization::find($searchId);

        $this->assertNotNull($searchedOrganization);
        $this->assertTrue($organization->is($searchedOrganization));
    }

    public function test_can_update_organization(): void
    {
        $organization = Organization::factory()->create(['name' => 'Organization']);
        $organization->name = 'Other-Organization';
        $organization->save();
        $this->assertEquals($organization->name, 'Other-Organization');
    }

    public function test_can_delete_organization(): void
    {
        $organization = Organization::factory()->create();
        $organization->delete();

        $this->assertSoftDeleted($organization);
    }

    /**
     * Testing many to many relationship.
     */
    public function test_has_bills_to_receive(): void
    {
        Organization::factory()
            ->has(BillToReceive::factory()->count(30), 'billsToReceive')
            ->create();

        BillToReceive::factory()->for(Organization::factory())->create();

        $this->assertDatabaseCount('bills_to_receive', 31);
    }
}
