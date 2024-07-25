<?php

namespace App\Utilities;

use App\Jobs\InsertCustomer;
use App\Jobs\InsertInvoice;
use App\Jobs\InsertOrder;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Synchronization;
use App\Models\SynchronizationDetail;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchQueryApi {

    private string $url;
    private string $model;
    private string|null $key;
    private string|null $job;
    private int $perPage;
    private int $start;
    private int $end;
    private int $total;
    private int $index;

    public function __construct($url, $model, int $perPage = 500, int $start = 0)
    {
        $this->url = $url;
        $this->model = $model;
        $this->key = null;
        $this->job = null;
        $this->perPage = $perPage;
        $this->start = $start;
        $this->end = $start + $perPage;
        $this->total = 0;
        $this->index = 0;
    }

    /**
     * Inicialize the key.
     */
    private function setup(): bool
    {
        if ($this->model === Customer::class) {
            $this->key = 'pessoas';
            $this->job = InsertCustomer::class;

        } else if ($this->model === Order::class) {
            $this->key = 'pedidos';
            $this->job = InsertOrder::class;

        } else if ($this->model === Invoice::class) {
            $this->key = 'duplicatas';
            $this->job = InsertInvoice::class;

        }

        return is_string($this->key);
    }

    /**
     * Verify if the loop health.
     */
    private function nextStep(int $count): bool
    {
        $this->start = $this->end;
        $this->end += $this->perPage;
        $this->total += $count;
        $this->index++;

        return $count >= $this->perPage;
    }

    /**
     * Handle.
     */
    public function start(Synchronization $synchronization): void
    {
        $morePages = $this->setup();
        while($morePages) {
            $response = Http::get($this->url . "&start={$this->start}&end={$this->end}");

            if($response->failed() || !isset($response[$this->key]['id']) || !is_array($response[$this->key]['id'])) {
                throw new \Exception("Error Processing data from API");
            }

            $data = collect($response[$this->key]['id']);
            $chunks = $data->chunk(100);

            foreach($chunks as $chunk) {
                $jobs = [];

                foreach($chunk as $item) {
                    $jobs[] = new $this->job($item);
                }

                Bus::batch($jobs)->name("Batch {$this->model}")->dispatch();
            }

            $morePages = $this->nextStep($data->count());
        }

        Log::info($synchronization);

        SynchronizationDetail::create([
            'idSincronizacao' => $synchronization->idSincronizacao,
            'nmEntidade' => $this->model,
            'numDadosAtualizados' => 0,
            'numDadosAtualizar' => $this->total,
        ]);
    }
}
