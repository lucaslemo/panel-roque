<?php

namespace App\Jobs;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertInvoice implements ShouldQueue
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
    public function __construct(public mixed $invoice)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invoice = Invoice::where('extConta', $this->invoice['idCobrancaReceber'])
            ->first();

        if(is_null($invoice)) {
            $invoice = new Invoice;
        }

        $dtCompetencia = $this->invoice['dtCompetencia'] && $this->invoice['dtCompetencia'] != '00/00/0000'
            ? Carbon::createFromFormat('d/m/Y', $this->invoice['dtCompetencia'])->format('Y-m-d')
            : null;

        $dtVencimentoCobrancaReceber = $this->invoice['dtVencimentoCobrancaReceber'] && $this->invoice['dtVencimentoCobrancaReceber'] != '00/00/0000'
            ? Carbon::createFromFormat('d/m/Y', $this->invoice['dtVencimentoCobrancaReceber'])->format('Y-m-d')
            : null;

        $invoice->fill([
            'extCliente' => $this->invoice['idPessoa'],
            'extConta' => $this->invoice['idCobrancaReceber'],
            'idCliente' => null,
            'idPedidoCabecalho' => null,
            'idFilial' => null,
            'nmVendedor' => $this->invoice['idPessoaRca'],
            'statusConta' => $this->invoice['statusTransito'],
            'nmSituacao' => 'N/D',
            'tpCobranca' => $this->invoice['cdCobrancaTipo'],
            'dtParcela' => $dtCompetencia,
            'numDuplicata' => $this->invoice['nrDuplicata'],
            'dtEmissao' => $dtCompetencia,
            'dtVencimento' => $dtVencimentoCobrancaReceber,
            'dtPagamento' => null,
            'vrBruto' => $this->invoice['vrBruto'],
            'vrLiquido' => 0,
            'vrAtualizado' => 0,
            'vrPago' => null,
            'isBoleto' => false,
            'nmArquivo' => null,
            'numCheque' => null,
        ]);

        $invoice->updated_at = Carbon::now();
        $invoice->save();
    }
}
