<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\SynchronizationDetail;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchInvoices implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        if ($this->batch()->cancelled()) {
            return;
        }

        $url = config('app.query_invoices');
        $response = Http::get($url . "&start={$this->start}&end={$this->end}&dtAtualizacao={$this->date}");

        if($response->failed() || !isset($response['duplicatas']['id']) || !is_array($response['duplicatas']['id'])) {
            $response->throw();
            throw new \Exception("Error processing data from API");
        }

        try {
            DB::beginTransaction();

            $data = $response['duplicatas']['id'];
            $countData = count($data);

            foreach($data as $item) {
                $invoice = Invoice::where('extConta', $item['idCobrancaReceber'])->first();

                if ($invoice) {
                    $invoice->delete();
                }

                $dtCompetencia = $item['dtCompetencia'] && $item['dtCompetencia'] != '00/00/0000'
                    ? Carbon::createFromFormat('d/m/Y', $item['dtCompetencia'])->format('Y-m-d')
                    : null;

                $dtVencimentoCobrancaReceber = $item['dtVencimentoCobrancaReceber'] && $item['dtVencimentoCobrancaReceber'] != '00/00/0000'
                    ? Carbon::createFromFormat('d/m/Y', $item['dtVencimentoCobrancaReceber'])->format('Y-m-d')
                    : null;

                $invoice = new Invoice;
                $invoice->fill([
                    'extCliente' => $item['idPessoa'],
                    'extConta' => $item['idCobrancaReceber'],
                    'extPedido' => 1,
                    'idCliente' => null,
                    'idPedidoCabecalho' => null,
                    'idFilial' => null,
                    'nmVendedor' => $item['idPessoaRca'],
                    'statusConta' => $item['statusTransito'],
                    'nmSituacao' => 'N/D',
                    'tpCobranca' => $item['cdCobrancaTipo'],
                    'dtParcela' => $dtCompetencia,
                    'numDuplicata' => $item['nrDuplicata'],
                    'dtEmissao' => $dtCompetencia,
                    'dtVencimento' => $dtVencimentoCobrancaReceber,
                    'dtPagamento' => null,
                    'vrBruto' => $item['vrBruto'],
                    'vrLiquido' => 0,
                    'vrAtualizado' => 0,
                    'vrPago' => null,
                    'isBoleto' => false,
                    'nmArquivoConta' => null,
                ]);
                $invoice->save();

            }

            $syncDetail = SynchronizationDetail::findOrFail($this->synchronizationDetailId);
            $syncDetail->numDadosAtualizar += $countData;
            $syncDetail->save();

            DB::commit();

            $perPage = $this->end - $this->start;

            if($countData >= $perPage) {
                $this->batch()->add(
                    new FetchInvoices($this->synchronizationDetailId, $this->date, $this->start + $perPage, $this->end + $perPage)
                );
            }
        } catch (\Throwable $th) {
            Log::channel('synchronization')->error($th->getMessage());
            DB::rollBack();
            throw $th;
        }
    }
}
