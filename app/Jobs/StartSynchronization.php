<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Synchronization;
use App\Models\SynchronizationDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

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
        public int $perPage
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            Log::channel('synchronization')->info(config('app.query_customers'), ['url' => 'customers']);
            Log::channel('synchronization')->info(config('app.query_orders'), ['url' => 'orders']);
            Log::channel('synchronization')->info(config('app.query_invoices'), ['url' => 'invoices']);

            $lastSynchronization = Synchronization::whereNotNull('dtSincronizacao')->latest()->firstOrFail();

            $synchronization = Synchronization::create();

            $customersSync = SynchronizationDetail::create([
                'idSincronizacao' => $synchronization->idSincronizacao,
                'nmEntidade' => Customer::class,
            ]);

            $ordersSync = SynchronizationDetail::create([
                'idSincronizacao' => $synchronization->idSincronizacao,
                'nmEntidade' => Order::class,
            ]);

            $invoicesSync = SynchronizationDetail::create([
                'idSincronizacao' => $synchronization->idSincronizacao,
                'nmEntidade' => Invoice::class,
            ]);

            DB::commit();

            FetchCustomers::dispatch($customersSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, $this->perPage);
            FetchOrders::dispatch($ordersSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, $this->perPage);
            FetchInvoices::dispatch($invoicesSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, $this->perPage);

            CheckDatabaseSynchronization::dispatch($synchronization->idSincronizacao, 1)->delay(now()->addSeconds(30));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
