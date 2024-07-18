<?php

namespace App\Listeners;

use App\Events\StartSyncDatabase;
use App\Jobs\CustomersStore;
use App\Jobs\InvoicesStore;
use App\Jobs\OrdersStore;
use App\Models\Update;
use Illuminate\Support\Facades\Http;

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

            $totalCustomersFetchData = 0;
            $totalOrdersFetchData = 0;
            $totalInvoicesFetchData = 0;

            $morePages = true;
            $perPage = 500;
            $start = 0;
            $end = $perPage;

            // Fetch Customers
            while($morePages) {
                $response = Http::get($urlBaseCustomers . "&start={$start}&end={$end}");
                $customers = $response['pessoas']['id'];
                $countCustomers = count($customers);

                CustomersStore::dispatch($customers);

                $start = $end;
                $end += $perPage;
                $totalCustomersFetchData += $countCustomers;
                if ($countCustomers < $perPage) {
                    $morePages = false;
                }
            }

            Update::create([
                'nmEntidade' => 'customers',
                'numTotalDados' => $totalCustomersFetchData,
            ]);

            $morePages = true;
            $start = 0;
            $end = $perPage;

            // Fetch Orders
            while($morePages) {
                $response = Http::get($urlBaseOrders . "&start={$start}&end={$end}");
                $orders = $response['pedidos']['id'];
                $countOrders = count($orders);

                OrdersStore::dispatch($orders);

                $start = $end;
                $end += $perPage;
                $totalOrdersFetchData += $countOrders;
                if ($countOrders < $perPage) {
                    $morePages = false;
                }
            }

            Update::create([
                'nmEntidade' => 'orders',
                'numTotalDados' => $totalOrdersFetchData,
            ]);

            $morePages = true;
            $start = 0;
            $end = $perPage;

            // Fetch Invoices
            while($morePages) {
                $response = Http::get($urlBaseInvoices . "&start={$start}&end={$end}");
                $invoices = $response['duplicatas']['id'];
                $countInvoices = count($invoices);

                InvoicesStore::dispatch($invoices);

                $start = $end;
                $end += $perPage;
                $totalInvoicesFetchData += $countInvoices;
                if ($countInvoices < $perPage) {
                    $morePages = false;
                }
            }

            Update::create([
                'nmEntidade' => 'invoices',
                'numTotalDados' => $totalInvoicesFetchData,
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
