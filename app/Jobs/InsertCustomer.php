<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertCustomer implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function __construct(public mixed $customer)
    {
        //
    }

        /**
     * Execute the job.
     */
    public function handle(): void
    {
        rand(1, 10) == 1 ? throw new \Exception('Erro ao inserir cliente') : null;

        $customer = Customer::whereNot('codCliente', '')
            ->where(function($query) {
                $query->where('codCliente', $this->customer['nrCpf']);
                $query->orWhere('codCliente', $this->customer['nrCnpj']);
                $query->orWhere('extCliente', $this->customer['idPessoa']);
            })
            ->first();

        if(is_null($customer)) {
            $customer = new Customer;
        }

        $customer->fill([
            'nmCliente' => $this->customer['nmPessoa'],
            'extCliente' => $this->customer['idPessoa'],
            'tpCliente' => $this->customer['tpPessoa'],
            'emailCliente' => $this->customer['emailPessoa'] ?? 'example' . $this->customer['idPessoa'] . '@email.com',
            'codCliente' => $this->customer['tpPessoa'] === 'F' ? $this->customer['nrCpf'] : $this->customer['nrCnpj'],
        ]);

        $customer->save();
    }
}
