<?php

namespace App\Jobs\Query;

use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncOrdersLogs implements ShouldQueue
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
        public int $orderId,
        public int $currentPage
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://openapi.acessoquery.com/api/vendas_logs";
        $token = config('app.query_token');

        $order = Order::with('orderHistories')->findOrFail($this->orderId);

        $params = [
            'idVenda' => $order->extPedido,
            'page' => $this->currentPage
        ];

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url, $params);

        $response->throw();

        $order->orderHistories()->delete();

        foreach ($response->json()['data']['list'] as $item) {
            $orderHistory = new OrderHistory;

            $orderHistory->idPedidoCabecalho = $this->orderId;
            $orderHistory->nmStatusPedido = $item['tpLog'];
            $orderHistory->dtStatusPedido = $item['dtLog'];

            $orderHistory->save();
        }

        $pagination = $response->json()['data']['pagination'];

        if ($pagination['total_pages'] > $pagination['current_page']) {
            SyncOrdersLogs::dispatchSync($this->orderId, $this->currentPage++);
        }
    }
}
