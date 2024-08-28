<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\SynchronizationDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class FetchCustomers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public $timeout = 3600;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 5;

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
        $url = config('app.query_customers');
        $response = Http::get($url . "&start={$this->start}&end={$this->end}&dtAtualizacao={$this->date}");

        if($response->failed() || !isset($response['pessoas']['id']) || !is_array($response['pessoas']['id'])) {
            $response->throw();
            throw new \Exception("Error processing data from API");
        }

        try {
            DB::beginTransaction();

            $data = $response['pessoas']['id'];
            $countData = count($data);

            foreach($data as $item) {
                $customer = Customer::where('extCliente', $item['idPessoa'])->first();

                if ($customer) {
                    $customer->delete();
                }

                $customer = new Customer;
                $customer->fill([
                    'nmCliente' => $item['nmPessoa'],
                    'extCliente' => $item['idPessoa'],
                    'tpCliente' => $item['tpPessoa'],
                    'emailCliente' => $item['emailPessoa'] ?? 'example' . $item['idPessoa'] . '@email.com',
                    'codCliente' => $item['tpPessoa'] === 'F' ? $item['nrCpf'] : $item['nrCnpj'],
                ]);
                $customer->save();
            }

            $syncDetail = SynchronizationDetail::findOrFail($this->synchronizationDetailId);
            $syncDetail->numDadosAtualizar += $countData;
            $syncDetail->save();

            DB::commit();

            $perPage = $this->end - $this->start;

            if($countData >= $perPage) {
                FetchCustomers::dispatch($this->synchronizationDetailId, $this->date, $this->start + $perPage, $this->end + $perPage);
                return;
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
