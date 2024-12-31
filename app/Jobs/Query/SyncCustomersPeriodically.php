<?php

namespace App\Jobs\Query;

use App\Models\Customer;
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
        public string $date,
        public int $currentPage
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://openapi.acessoquery.com/api/pessoas";
        $token = config('app.query_token');

        $params = [
            'dtAtualizacao' => $this->date,
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
        $pagination = $response->json()['data']['pagination'];

        foreach ($incomingCustomers as $incomingCustomer) {
            if ($incomingCustomer['hasPortalCliente']) {
                $customer = Customer::firstOrNew(['extCliente' => $incomingCustomer['cliente']['idCliente']]);
                $customer->fill([
                    'nmCliente' => $incomingCustomer['nmPessoa'],
                    'extCliente' => $incomingCustomer['cliente']['idCliente'],
                    'tpCliente' => $incomingCustomer['tpPessoa'],
                    'emailCliente' => $incomingCustomer['dsEmail'],
                    'codCliente' => $incomingCustomer['tpPessoa'] === 'F' ? $incomingCustomer['nrCpf'] : $incomingCustomer['nrCnpj'],
                ]);
                $customer->save();
            }
        }

        if ($pagination['total_pages'] > $pagination['current_page']) {
            SyncCustomersPeriodically::dispatch($this->date, ($this->currentPage + 1));
        }
    }
}
