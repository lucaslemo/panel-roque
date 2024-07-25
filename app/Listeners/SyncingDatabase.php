<?php

namespace App\Listeners;

use App\Events\StartSyncDatabase;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Synchronization;
use App\Utilities\FetchQueryApi;
use Carbon\Carbon;

class SyncingDatabase
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StartSyncDatabase $event): void
    {
        try {
            $urlBaseCustomers = 'http://localhost/api/pessoas?teste=true';
            $urlBaseOrders = 'http://localhost/api/pedidos?teste=true';
            $urlBaseInvoices = 'http://localhost/api/contas?teste=true';

            $fetchCustomers = new FetchQueryApi($urlBaseCustomers, Customer::class);
            $fetchOrders = new FetchQueryApi($urlBaseOrders, Order::class);
            $fetchInvoices = new FetchQueryApi($urlBaseInvoices, Invoice::class);

            $synchronization = Synchronization::create([
                'dtFinalBusca' => null,
                'dtSincronizacao' => null,
            ]);

            $fetchCustomers->start($synchronization);
            $fetchOrders->start($synchronization);
            $fetchInvoices->start($synchronization);

            $synchronization->dtFinalBusca = Carbon::now();
            $synchronization->save();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
