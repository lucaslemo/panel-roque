<?php

namespace App\Jobs;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertOrder implements ShouldQueue
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
    public function __construct(public mixed $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::where('extPedido', $this->order['idVenda'])
            ->first();

        if(is_null($order)) {
            $order = new Order;
        }

        $dtEntrega = $this->order['dtEntrega'] && $this->order['dtEntrega'] != '00/00/0000'
            ? Carbon::createFromFormat('d/m/Y', $this->order['dtEntrega'])->format('Y-m-d')
            : null;

        $dtVenda = $this->order['dtVenda'] && $this->order['dtVenda'] != '00/00/0000 00:00'
            ?  Carbon::createFromFormat('d/m/Y H:i', $this->order['dtVenda'])->format('Y-m-d H:i')
            : null;

        $dtFaturamento = $this->order['dtFaturamento'] && $this->order['dtFaturamento'] != '00/00/0000 00:00'
            ?  Carbon::createFromFormat('d/m/Y H:i', $this->order['dtFaturamento'])->format('Y-m-d H:i')
            : null;

        $order->fill([
            'extCliente' => $this->order['idPessoa'],
            'extPedido' => $this->order['idVenda'],
            'idCliente' => null,
            'idFilial' => null,
            'nmVendedor' => $this->order['nmPessoaRca'],
            'tpEntrega' => 'Entrega/Retirada',
            'tpCobranca' => 'Dinheiro/Cheque/Cartão',
            'statusPedido' => $this->order['status'],
            'dtPedido' => $dtVenda,
            'dtFaturamento' => $dtFaturamento,
            'dtEntrega' => $dtEntrega,
            'vrTotal' => $this->order['vrVenda'],
            'numOrdemCompra' => 'OrdemDeCompra',
            'nmArquivo' => null,
        ]);

        $order->updated_at = Carbon::now();
        $order->save();
    }
}
