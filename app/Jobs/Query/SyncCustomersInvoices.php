<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncCustomersInvoices implements ShouldQueue
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
        $url = "https://openapi.acessoquery.com/api/cobrancas_receber";
        $token = config('app.query_token');

        $customers = Customer::with('invoices')
            ->whereHas('users', function($query) {
                $query->where('users.id', $this->user->id);
            })
            ->get();

        foreach ($customers as $customer) {
            $params = [
                'idPessoa' => $customer->extCliente,
                'page' => $this->currentPage
            ];

            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($url, $params);

            $response->throw();

            $customer->invoices()->delete();

            foreach ($response->json()['data']['list'] as $item) {
                if ($item['statusCobranca'] === 'Aberto' || $item['statusCobranca'] === 'Pago') {
                    $invoice = new Invoice;
    
                    $invoice->fill([
                        'extCliente' => $customer->extCliente,
                        'extConta' => $item['idCobrancaReceber'],
                        'extPedido' => $item['idReferencia'],
                        'idCliente' => $customer->idCliente,
                        'idPedidoCabecalho' => null,
                        'idFilial' => null,
                        'nmVendedor' => null,
                        'statusConta' => $item['statusCobranca'],
                        'nmSituacao' => null,
                        'tpCobranca' => $item['nmCobrancaTipo'],
                        'dtParcela' => $this->formatDateTime($item['dtCompetencia']),
                        'numDuplicata' => null,
                        'numParcela' => $item['nrParcela'],
                        'numTotalParcela' => $item['qtdParcelas'],
                        'dtEmissao' => $this->formatDateTime($item['dtCompetencia']),
                        'dtVencimento' => $this->formatDateTime($item['dtVencimentoCobrancaReceber']),
                        'dtPagamento' => $this->formatDateTime($item['dtCobrancaReceberBaixa']),
                        'vrBruto' => $item['vrCobrancaReceber'],
                        'vrLiquido' => null,
                        'vrAtualizado' => null,
                        'vrPago' => $item['vrPago'],
                        'isBoleto' => $item['hasBoletoBancario'] === 'Sim',
                        'codBoleto' => $item['hasBoletoBancario'] === 'Sim' && $item['statusCobranca'] === 'Aberto' 
                            ? $item['linha_digitavel']
                            : null,
                        'nmArquivoConta' => $item['hasBoletoBancario'] === 'Sim' && $item['statusCobranca'] === 'Aberto'
                            ? route('app.ticket', $item['idCobrancaReceber']) 
                            : null,
                    ]);
    
                    $invoice->save();
                }
            }
        }

        $pagination = $response->json()['data']['pagination'];

        if ($pagination['total_pages'] > $pagination['current_page']) {
            SyncCustomersInvoices::dispatchSync($this->user, $this->currentPage++);
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
