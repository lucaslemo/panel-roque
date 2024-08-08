<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SynchronizationDetail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class FetchOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $synchronizationDetailId,
        public string $date,
        public int $start,
        public int $end
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = config('app.query_orders');
        $response = Http::get($url . "&start={$this->start}&end={$this->end}&dtAtualizacao={$this->date}");

        if($response->failed() || !isset($response['pedidos']['id']) || !is_array($response['pedidos']['id'])) {
            $response->throw();
            throw new \Exception("Error processing data from API");
        }

        try {
            DB::beginTransaction();

            $data = $response['pedidos']['id'];
            $countData = count($data);

            foreach($data as $item) {
                $order = Order::where('extPedido', $item['idVenda'])->first();

                if ($order) {
                    $order->delete();
                }

                $dtEntrega = $item['dtEntrega'] && $item['dtEntrega'] != '00/00/0000'
                    ? Carbon::createFromFormat('d/m/Y', $item['dtEntrega'])->format('Y-m-d')
                    : null;

                $dtVenda = $item['dtVenda'] && $item['dtVenda'] != '00/00/0000 00:00'
                    ?  Carbon::createFromFormat('d/m/Y H:i', $item['dtVenda'])->format('Y-m-d H:i')
                    : null;

                $dtFaturamento = $item['dtFaturamento'] && $item['dtFaturamento'] != '00/00/0000 00:00'
                    ?  Carbon::createFromFormat('d/m/Y H:i', $item['dtFaturamento'])->format('Y-m-d H:i')
                    : null;

                $order = new Order;
                $order->fill([
                    'extCliente' => $item['idPessoa'],
                    'extPedido' => $item['idVenda'],
                    'idCliente' => null,
                    'idFilial' => null,
                    'nmVendedor' => $item['nmPessoaRca'],
                    'tpEntrega' => 'Entrega/Retirada',
                    'statusPedido' => $item['status'],
                    'statusEntrega' => 'Separado/Montado/Em trânsito/Entregue/Reprogramado/Devolvido',
                    'dtPedido' => $dtVenda,
                    'dtFaturamento' => $dtFaturamento,
                    'dtEntrega' => $dtEntrega,
                    'vrTotal' => $item['vrVenda'],
                    'numOrdemCompra' => '123456',
                    'nmArquivoDetalhes' => null,
                    'nmArquivoNotaFiscal' => null,
                ]);
                $order->save();
            }

            $syncDetail = SynchronizationDetail::findOrFail($this->synchronizationDetailId);
            $syncDetail->numDadosAtualizar += $countData;
            $syncDetail->save();

            DB::commit();

            $perPage = $this->end - $this->start;

            if($countData >= $perPage) {
                FetchOrders::dispatch($this->synchronizationDetailId, $this->date, $this->start + $perPage, $this->end + $perPage);
            }

            $syncDetail->isCompleto = true;
            $syncDetail->save();

        } catch (\Throwable $th) {
            Log::channel('synchronization')->error($th->getMessage());
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $syncDetail = SynchronizationDetail::findOrFail($this->synchronizationDetailId);
        $syncDetail->numErros++;
        $syncDetail->save();
    }
}
