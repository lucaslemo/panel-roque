<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchCustomersOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Customer $customer,
        public int $currentPage,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://openapi.acessoquery.com/api/vendas";
        $token = config('app.query_token');

        $params = [
            'idPessoa' => $this->customer->extCliente,
            'data_inicial' => now()->subDays(90)->format('Y-m-d'),
            'data_final' => now()->format('Y-m-d'),
            'has_produtos' => 1,
            'page' => $this->currentPage
        ];

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url, $params);

        $response->throw();

        foreach ($response->json()['data']['list'] as $item) {
            $order = new Order;

            $order->fill([
                'extCliente' => $item['idPessoa'],
                'extPedido' => $item['idVenda'],
                'idCliente' => $this->customer->idCliente,
                'idFilial' => null,
                'nmVendedor' => $item['nmPessoaRCA'],
                'tpEntrega' => $item['tpEntrega'] == 'EXW' ? 'Retirada' : 'Entrega',
                'statusPedido' => $item['statusVenda'],
                'statusEntrega' => null,
                'dtPedido' =>  $this->formatDateTime($item['dtVenda']),
                'dtFaturamento' =>  $this->formatDateTime($item['dtFaturamento']),
                'dtEntrega' => null,
                'vrTotal' => $item['vrVenda'],
                'vrBruto' => $item['vrBruto'],
                'vrFrete' => $item['vrFrete'],
                'numOrdemCompra' => null,
                'nmArquivoDetalhes' => null,
                'nmArquivoNotaFiscal' => $item['idNotaFiscal'] ? route('app.nfe', $item['idNotaFiscal']) : null,
                'nmArquivoXml' => $item['idNotaFiscal'] ? route('app.xml', $item['idNotaFiscal']) : null,
            ]);

            $order->save();

            foreach ($item['produtos'] as $product) {
                $orderDetail = new OrderDetail;

                $orderDetail->fill([
                    'idCliente' => $this->customer->idCliente,
                    'idPedidoCabecalho' => $order->idPedidoCabecalho,
                    'codProduto' => $product['idProduto'],
                    'nmProduto' => $product['produto']['nmProduto'],
                    'qtdProduto' => (double) $product['qtdProduto'] * (double) $product['qtdEmbalagemProduto'],
                    'cdUnidade' => $product['produto']['cdUnidadeVenda'],
                    'vrTabela' => $product['vrTabela'],
                    'vrDesconto' => $product['vrDesconto'],
                    'vrProduto' => $product['vrProduto'],
                    'vrTotal' => $product['vrTotalProduto'],
                ]);

                $orderDetail->save();
            }
        }

        $pagination = $response->json()['data']['pagination'];

        if ($pagination['total_pages'] > $pagination['current_page']) {
            FetchCustomersOrders::dispatchSync($this->customer, ($this->currentPage + 1));
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
