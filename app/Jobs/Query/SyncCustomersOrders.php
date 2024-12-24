<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncCustomersOrders implements ShouldQueue
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
        $url = "https://openapi.acessoquery.com/api/vendas";
        $token = config('app.query_token');

        $customers = Customer::with('orders')
            ->whereHas('users', function($query) {
                $query->where('users.id', $this->user->id);
            })
            ->get();

        foreach ($customers as $customer) {
            $params = [
                'idPessoa' => $customer->extCliente,
                'data_inicial' => now()->subDays(90)->format('y-m-d'),
                'data_final' => now()->format('y-m-d')
            ];

            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($url, $params);

            $response->throw();

            $customers->orders()->delete();

            $order = new Order;

            foreach ($response->json()['data']['list'] as $item) {
                $order->fill([
                    'extCliente' => $item['idPessoa'],
                    'extPedido' => $item['idVenda'],
                    'idCliente' => null,
                    'idFilial' => null,
                    'nmVendedor' => $item['nmPessoaRca'],
                    'tpEntrega' => $item['tpEntrega'] == 'EXW' ? 'Retirada' : 'Entrega',
                    'statusPedido' => $item['statusVenda'],
                    'statusEntrega' => 'Separado/Montado/Em trânsito/Entregue/Reprogramado/Devolvido',
                    'dtPedido' => $item['dtVenda'],
                    'dtFaturamento' => $item['dtFaturamento'],
                    'dtEntrega' => $item['dtEntrega'],
                    'vrTotal' => $item['vrVenda'],
                    'numOrdemCompra' => $item['nrOrdemDeCompra'],
                    'nmArquivoDetalhes' => null,
                    'nmArquivoNotaFiscal' => null,
                ]);
                $order->save();
            }
        }
    }
}
