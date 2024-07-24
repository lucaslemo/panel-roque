<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrdersStore implements ShouldQueue
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
    public function __construct(public mixed $orders)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // throw new \Exception('Teste');
            DB::beginTransaction();

            foreach($this->orders as $order) {

                $customer = Customer::where('extCliente', $order['idPessoa'])->first();

                if ($customer) {

                    $dtEntrega = $order['dtEntrega'] && $order['dtEntrega'] != '00/00/0000'
                        ? Carbon::createFromFormat('d/m/Y', $order['dtEntrega'])->format('Y-m-d')
                        : null;

                    $dtVenda = $order['dtVenda'] && $order['dtVenda'] != '00/00/0000 00:00'
                        ?  Carbon::createFromFormat('d/m/Y H:i', $order['dtVenda'])->format('Y-m-d H:i')
                        : null;

                    $dtFaturamento = $order['dtFaturamento'] && $order['dtFaturamento'] != '00/00/0000 00:00'
                        ?  Carbon::createFromFormat('d/m/Y H:i', $order['dtFaturamento'])->format('Y-m-d H:i')
                        : null;

                    Order::create([
                        'extPedido' => $order['idVenda'],
                        'idCliente' => $customer->idCliente,
                        'nmVendedor' => $order['nmPessoaRca'],
                        'tpEntrega' => 'Entrega/Retirada',
                        'tpCobranca' => 'Dinheiro/Cheque/Cartão',
                        'statusPedido' => $order['status'],
                        'dtPedido' => $dtVenda,
                        'dtFaturamento' => $dtFaturamento,
                        'dtEntrega' => $dtEntrega,
                        'vrTotal' => $order['vrVenda'],
                        'numOrdemCompra' => 'OrdemDeCompra',
                        'nmArquivo' => null,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
