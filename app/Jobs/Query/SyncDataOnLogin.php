<?php

namespace App\Jobs\Query;

use App\Models\CreditLimit;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncDataOnLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://openapi.acessoquery.com/api/pessoas";
        $token = config('app.query_token');

        $customers = Customer::with('creditLimit')
            ->whereHas('users', function($query) {
                $query->where('users.id', $this->user->id);
            })
            ->get();

        foreach ($customers as $customer) {
            $params = ['idPessoa' => $customer->extCliente];
    
            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($url, $params);

            $response->throw();

            $data = $response->json()['data']['list'][0];

            $customer->fill([
                'nmCliente' => $data['nmPessoa'],
                'extCliente' => $data['idPessoa'],
                'tpCliente' => $data['tpPessoa'],
                'emailCliente' => $data['dsEmail'],
                'codCliente' => $data['tpPessoa'] === 'F' ? $data['nrCpf'] : $data['nrCnpj'],
            ]);

            $customer->save();

            if (!is_null($customer->creditLimit)) {
                $creditLimit = $customer->creditLimit;
            } else {
                $creditLimit = new CreditLimit;
            }

            $creditLimit->fill([
                'vrLimite' => $data['vrLimiteAprovado'] ?? 0,
                'vrUtilizado' => $data['vrLimiteConsumido'] ?? 0,
                'vrReservado' => $data['vrLimiteConsumidoPrevenda'] ?? 0,
                'vrDisponivel' => $data['vrLimiteDisponivel'] ?? 0,
                'idCliente' => $customer->idCliente,
            ]);

            $creditLimit->save();
        }
    }
}
