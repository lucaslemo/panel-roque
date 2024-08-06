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
use Illuminate\Support\Facades\Bus;
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
    public function __construct()
    {
        //
    }

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

            $customersBatch = Bus::batch([new FetchCustomers($customersSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, 500)])
                ->name('Fetch customers')
                ->dispatch();

            $ordersBatch = Bus::batch([new FetchOrders($ordersSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, 500)])
                ->name('Fetch orders')
                ->dispatch();

            $invoicesBatch = Bus::batch([new FetchInvoices($invoicesSync->idDetalheSincronizacao, $lastSynchronization->created_at, 0, 500)])
                ->name('Fetch invoices')
                ->dispatch();

            CheckDatabaseSynchronization::dispatch($synchronization->idSincronizacao, $customersBatch->id, $ordersBatch->id, $invoicesBatch->id, 1)
                ->delay(now()->addSeconds(30));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
