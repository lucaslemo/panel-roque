<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        public User $user,
        public int $currentPage
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
                'data_inicial' => now()->subDays(90)->format('Y-m-d'),
                'data_final' => now()->format('Y-m-d'),
                'page' => $this->currentPage
            ];

            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($url, $params);

            $response->throw();

            $customer->orders()->delete();

            foreach ($response->json()['data']['list'] as $item) {
                $order = new Order;

                $order->fill([
                    'extCliente' => $item['idPessoa'],
                    'extPedido' => $item['idVenda'],
                    'idCliente' => $customer->idCliente,
                    'idFilial' => null,
                    'nmVendedor' => $item['nmPessoaRCA'],
                    'tpEntrega' => $item['tpEntrega'] == 'EXW' ? 'Retirada' : 'Entrega',
                    'statusPedido' => $item['statusVenda'],
                    'statusEntrega' => 'Separado/Montado/Em trânsito/Entregue/Reprogramado/Devolvido',
                    'dtPedido' =>  $this->formatDateTime($item['dtVenda']),
                    'dtFaturamento' =>  $this->formatDateTime($item['dtFaturamento']),
                    'dtEntrega' => $this->formatDateTime($item['dtEntrega']),
                    'vrTotal' => $item['vrVenda'],
                    'numOrdemCompra' => $item['nrOrdemDeCompra'],
                    'nmArquivoDetalhes' => null,
                    'nmArquivoNotaFiscal' => $item['idNotaFiscal'] ? route('app.nfe', $item['idNotaFiscal']) : null,
                    'nmArquivoXml' => $item['idNotaFiscal'] ? route('app.xml', $item['idNotaFiscal']) : null,
                ]);

                $order->save();
            }

            $pagination = $response->json()['data']['pagination'];

            if ($pagination['total_pages'] > $pagination['current_page']) {
                SyncCustomersOrders::dispatch($this->user, $this->currentPage++);
            }
        }
    }

    private function formatDateTime(string|null $dateTime, bool $short = false): string|null
    {
        $compareDate = $short ? '0000-00-00' : '0000-00-00 00:00:00';
        $format = $short ? 'Y-m-d' : 'Y-m-d H:i:s';

        $date = $dateTime && $dateTime !== $compareDate
            ? Carbon::parse($dateTime)->format($format)
            : null;

        return $date;
    }
}
