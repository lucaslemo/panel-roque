<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Synchronization;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkOrders implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

    private Synchronization $synchronization;
    private Customer $customer;

    /**
     * Create a new job instance.
     */
    public function __construct(Synchronization $synchronization, Customer $customer)
    {
        $this->synchronization = $synchronization;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $syncDetail = $this->synchronization->syncDetails()->where('nmEntidade', Order::class)->first();
        Order::where('extCliente', $this->customer->extCliente)->chunk(100, function($orders)  use($syncDetail) {
            foreach($orders as $order) {
                $order->idCliente = $this->customer->idCliente;
                $order->save();
            }

            $syncDetail->numDadosAtualizados += count($orders);
            $syncDetail->save();
        });
        $this->synchronization->dtSincronizacao = now();
        $this->synchronization->save();
    }
}
