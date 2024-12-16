<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncDataOnLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

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

        $params = ['dtAtualizacao' => '2024-10-10'];

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url);

        $response->throw();

        $data = $response->json()['data']['list'][0]; // Remover [0] e adicionar lógica de pegar apenas um usuário

        $customer = Customer::firstOrNew(['extCliente' => $data['cliente']['idCliente']]);
        $customer->fill([
            'nmCliente' => $data['nmPessoa'],
            'extCliente' => $data['cliente']['idCliente'],
            'tpCliente' => $data['tpPessoa'],
            'emailCliente' => $data['dsEmail'] ?? 'example' . $data['idPessoa'] . '@email.com', // Remover ?? e validar campo de email
            'codCliente' => $data['tpPessoa'] === 'F' ? $data['nrCpf'] : $data['nrCnpj'],
        ]);
        $customer->save();

        foreach ($data['financeiro'] as $invoice) {

        }
    }
}
