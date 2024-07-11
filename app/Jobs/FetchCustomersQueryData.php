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

    public int $start = 0;
    public int $end = 0;

    /**
     * Create a new job instance.
     */
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $urlBase = config('app.query_customers');

            DB::beginTransaction();

            $response = Http::get($urlBase . "&start={$this->start}&end={$this->end}");

            $customers = $response['pessoas']['id'];
            $qty = count($customers);

            Log::info("Quantidade entre {$this->start} e {$this->end}: {$qty}");

            // DB::table('customers')->delete();

            // $response = Http::get($urlBase);
            // foreach($response['pessoas']['id'] as $customer) {
            //     Customer::create([
            //         'nmCliente' => $customer['nmPessoa'],
            //         'extCliente' => $customer['idPessoa'],
            //         'tpCliente' => $customer['tpPessoa'] === 'F' ? 'pf' : 'pj',
            //         'codCliente' => $customer['tpPessoa'] === 'F' ? $customer['nrCpf'] : $customer['nrCnpj'],
            //     ]);
            // }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
