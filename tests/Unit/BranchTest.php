<?php

namespace Tests\Unit;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of branch.
     */
    public function test_can_create_branch(): void
    {
        $branch = Branch::factory()->create();

        $this->assertNotNull($branch);
    }

    public function test_can_read_branch(): void
    {
        $branch = Branch::factory()->create();
        $searchId = $branch->idFilial;

        $searchedBranch = Branch::find($searchId);

        $this->assertNotNull($searchedBranch);
        $this->assertTrue($branch->is($searchedBranch));
    }

    public function test_can_update_branch(): void
    {
        $branch = Branch::factory()
            ->create(['nmFilial' => 'Filial - 1']);

        $branch->nmFilial = 'Filial - 2';
        $branch->save();

        $this->assertEquals($branch->nmFilial, 'Filial - 2');
    }

    public function test_can_delete_branch(): void
    {
        $branch = Branch::factory()->create();
        $branch->delete();

        $this->assertSoftDeleted($branch);
    }
}
