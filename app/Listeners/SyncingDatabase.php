<?php

namespace App\Listeners;

use App\Events\StartSyncDatabase;
use App\Jobs\CustomersStore;
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
            $urlBase = 'http://localhost/api/pessoas?teste=true';

            $morePages = true;
            $perPage = 500;
            $start = 0;
            $end = $perPage;
            $totalCustomersFetchData = 0;

            while($morePages) {
                $response = Http::get($urlBase . "&start={$start}&end={$end}");
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

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
