<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoicesStore implements ShouldQueue
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
    public function __construct(public mixed $invoices)
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

            foreach($this->invoices as $invoice) {
                $customer = Customer::where('extCliente', $invoice['idPessoa'])->first();

                $dtCompetencia = $invoice['dtCompetencia'] && $invoice['dtCompetencia'] != '00/00/0000'
                    ? Carbon::createFromFormat('d/m/Y', $invoice['dtCompetencia'])->format('Y-m-d')
                    : null;

                $dtVencimentoCobrancaReceber = $invoice['dtVencimentoCobrancaReceber'] && $invoice['dtVencimentoCobrancaReceber'] != '00/00/0000'
                    ? Carbon::createFromFormat('d/m/Y', $invoice['dtVencimentoCobrancaReceber'])->format('Y-m-d')
                    : null;

                if ($customer) {
                    Invoice::create([
                        'extConta' => $invoice['idCobrancaReceber'],
                        'idCliente' => $customer->idCliente,
                        'nmVendedor' => $invoice['idPessoaRca'],
                        'statusConta' => $invoice['statusTransito'],
                        'nmSituacao' => 'N/D',
                        'tpCobranca' => $invoice['cdCobrancaTipo'],
                        'dtParcela' => $dtCompetencia,
                        'numDuplicado' => $invoice['nrDuplicata'],
                        'dtEmissao' => $dtCompetencia,
                        'dtVencimento' => $dtVencimentoCobrancaReceber,
                        'dtPagamento' => null,
                        'vrBruto' => $invoice['vrBruto'],
                        'vrLiquido' => 0,
                        'vrAtualizado' => 0,
                        'vrPago' => null,
                        'numCheque' => null,
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
