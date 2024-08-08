<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkOrders implements ShouldQueue
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
        $syncDetail = $this->synchronization->syncDetails()->where('nmEntidade', Order::class)->first();
        Order::where('extCliente', $this->customerExtId)->chunk(100, function($orders)  use($syncDetail) {
            foreach($orders as $order) {
                $order->idCliente = $this->customerId;
                $order->save();
            }

            $syncDetail->numDadosAtualizados += count($orders);
            $syncDetail->save();
        });
        $this->synchronization->dtSincronizacao = now();
        $this->synchronization->save();
    }
}
