<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkCustomer implements ShouldQueue
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
        public int $synchronizationId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $synchronization = Synchronization::findOrFail($this->synchronizationId);
        $syncDetail = $synchronization->syncDetails()->where('nmEntidade', Customer::class)->first();

        Customer::chunk(100, function($customers) use($synchronization, $syncDetail) {
            $jobs = [];

            foreach($customers as $customer) {
                LinkOrders::dispatch($synchronization, $customer->idCliente, $customer->extCliente);
                LinkInvoices::dispatch($synchronization, $customer->idCliente, $customer->extCliente);
            }

            $syncDetail->numDadosAtualizados += count($customers);
            $syncDetail->save();
        });

    }
}
