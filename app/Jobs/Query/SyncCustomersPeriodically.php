<?php

namespace App\Jobs\Query;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncCustomersPeriodically implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $startDate,
        public int $currentPage
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://openapi.acessoquery.com/api/pessoas";
        $token = config('app.query_token');
        
        $lastUpdate = Synchronization::findOrFail(1)->dtSincronizacao;

        $params = [
            'dtAtualizacao' => $lastUpdate,
            'page' => $this->currentPage
        ];

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url, $params);

        $response->throw();

        $incomingCustomers = $response->json()['data']['list'];
        
        foreach ($incomingCustomers as $incomingCustomer) {
            if ($incomingCustomer['hasPortalCliente'] === 'Sim') {

                $customer = Customer::withTrashed()->firstOrNew(['extCliente' => $incomingCustomer['idPessoa']]);

                if (!is_null($customer->deleted_at)) {
                    $customer->restore();
                }

                $customer->fill([
                    'nmCliente' => $incomingCustomer['nmPessoa'],
                    'extCliente' => $incomingCustomer['idPessoa'],
                    'tpCliente' => $incomingCustomer['tpPessoa'],
                    'emailCliente' => $incomingCustomer['dsEmail'],
                    'codCliente' => $incomingCustomer['tpPessoa'] === 'F' ? $incomingCustomer['nrCpf'] : $incomingCustomer['nrCnpj'],
                ]);

                $customer->save();

                $creditLimit = CreditLimit::withTrashed()->firstOrNew(['idCliente' => $customer->idCliente]);

                if (!is_null($creditLimit->deleted_at)) {
                    $creditLimit->restore();
                }

                $creditLimit->fill([
                    'vrLimite' => $incomingCustomer['vrLimiteAprovado'] ?? 0,
                    'vrUtilizado' => $incomingCustomer['vrLimiteConsumido'] ?? 0,
                    'vrReservado' => $incomingCustomer['vrLimiteConsumidoPrevenda'] ?? 0,
                    'vrDisponivel' => $incomingCustomer['vrLimiteDisponivel'] ?? 0,
                    'idCliente' => $customer->idCliente,
                ]);

                $creditLimit->save();

            } else {
                $customer = Customer::where('extCliente', $incomingCustomer['idPessoa'])->first();
                if ($customer) {
                    $customer->delete();
                }
            }
        }

        $pagination = $response->json()['data']['pagination'];

        if ($pagination['total_pages'] > $pagination['current_page']) {
            SyncCustomersPeriodically::dispatch($this->startDate, ($this->currentPage + 1));
        } else {
            $sync = Synchronization::findOrFail(1);
            $sync->dtSincronizacao = $this->startDate;
            $sync->save();
        }
    }
}
