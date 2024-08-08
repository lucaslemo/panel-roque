<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Synchronization $synchronization,
        public string $customerId,
        public string $customerExtId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $syncDetail = $this->synchronization->syncDetails()->where('nmEntidade', Invoice::class)->first();
        Invoice::where('extCliente', $this->customerExtId)->chunk(100, function($invoices) use($syncDetail) {
            foreach($invoices as $invoice) {
                $invoice->idCliente = $this->customerId;
                $invoice->save();
            }

            $syncDetail->numDadosAtualizados += count($invoices);
            $syncDetail->save();
        });
        $this->synchronization->dtSincronizacao = now();
        $this->synchronization->save();
    }
}
