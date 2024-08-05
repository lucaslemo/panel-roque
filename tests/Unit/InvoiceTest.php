<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing CRUD of invoice.
     */
    public function test_can_create_invoice(): void
    {
        $invoice = Invoice::factory()->for(Customer::factory())->create();
        $this->assertNotNull($invoice);
    }

    public function test_can_read_invoice(): void
    {
        $invoice = Invoice::factory()->for(Customer::factory())->create();
        $searchId = $invoice->idConta;

        $searchedInvoice = Invoice::find($searchId);

        $this->assertNotNull($searchedInvoice);
        $this->assertTrue($invoice->is($searchedInvoice));
    }

    public function test_can_update_invoice(): void
    {
        $invoice = Invoice::factory()->for(Customer::factory())->create(['dtPagamento' => null]);
        $now = Carbon::now();
        $invoice->dtPagamento = $now;
        $invoice->save();
        $this->assertTrue($invoice->dtPagamento->eq($now));
    }

    public function test_can_delete_invoice(): void
    {
        $invoice = Invoice::factory()->for(Customer::factory())->create();
        $invoice->delete();

        $this->assertSoftDeleted($invoice);
    }
}
