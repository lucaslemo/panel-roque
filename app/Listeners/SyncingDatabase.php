<?php

namespace App\Listeners;

use App\Events\StartSyncDatabase;
use App\Jobs\CustomersStore;
use App\Jobs\InvoicesStore;
use App\Jobs\OrdersStore;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Update;
use App\Utilities\FetchQueryApi;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

            $fetchCustomers->start();
            $fetchOrders->start();
            $fetchInvoices->start();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
