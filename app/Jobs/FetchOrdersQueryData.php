<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchOrdersQueryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $urlBase = config('app.query_orders');

            DB::beginTransaction();

            DB::table('orders')->delete();

            $response = Http::get($urlBase);

            foreach($response['pedidos']['id'] as $order) {

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
