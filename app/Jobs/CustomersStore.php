<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CustomersStore implements ShouldQueue
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
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(public $customers)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            foreach($this->customers as $customerData) {
                $customer = Customer::whereNot('codCliente', '')
                    ->where(function($query) use($customerData) {
                        $query->where('codCliente', $customerData['nrCpf']);
                        $query->orWhere('codCliente', $customerData['nrCnpj']);
                        $query->orWhere('extCliente', $customerData['idPessoa']);
                    })
                    ->first();

                if(is_null($customer)) {
                    $customer = new Customer;
                }

                $customer->fill([
                    'nmCliente' => $customerData['nmPessoa'],
                    'extCliente' => $customerData['idPessoa'],
                    'tpCliente' => $customerData['tpPessoa'],
                    'emailCliente' => $customerData['emailPessoa'] ?? 'example1@email.com',
                    'codCliente' => $customerData['tpPessoa'] === 'F' ? $customerData['nrCpf'] : $customerData['nrCnpj'],
                ]);

                $customer->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
