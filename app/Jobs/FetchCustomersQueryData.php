<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchCustomersQueryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            $urlBase = config('app.query_customers');

            DB::beginTransaction();

            DB::table('customers')->delete();

            $morePages = true;
            $pageLength = 10;
            $start = 0;
            $end = $pageLength;

            // while($morePages) {
            //     $response = Http::get($urlBase . "&start={$start}&end={$end}");
            //     $customers = $response['pessoas']['id'];

            //     foreach($response['pessoas']['id'] as $customer) {
            //         Customer::create([
            //             'nmCliente' => $customer['nmPessoa'],
            //             'extCliente' => $customer['idPessoa'],
            //             'tpCliente' => $customer['tpPessoa'] === 'F' ? 'pf' : 'pj',
            //             'codCliente' => $customer['tpPessoa'] === 'F' ? $customer['nrCpf'] : $customer['nrCnpj'],
            //         ]);
            //     }

            //     $start = $end + 1;
            //     $end += $pageLength;
                
            //     if (count($customers) < $pageLength) { 
            //         $morePages = false;
            //     }
            // }

            $response = Http::get($urlBase);
            foreach($response['pessoas']['id'] as $customer) {
                Customer::create([
                    'nmCliente' => $customer['nmPessoa'],
                    'extCliente' => $customer['idPessoa'],
                    'tpCliente' => $customer['tpPessoa'] === 'F' ? 'pf' : 'pj',
                    'codCliente' => $customer['tpPessoa'] === 'F' ? $customer['nrCpf'] : $customer['nrCnpj'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
        }
    }
}
