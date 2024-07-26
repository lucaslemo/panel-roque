<?php

namespace App\Utilities;

use App\Jobs\InsertCustomer;
use App\Jobs\InsertInvoice;
use App\Jobs\InsertOrder;
use App\Jobs\LinkInvoices;
use App\Jobs\LinkOrders;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Synchronization;
use App\Models\SynchronizationDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class FetchQueryApi {

    private string $url;
    private string $model;
    private string|null $key;
    private string|null $job;
    private int $perPage;
    private int $start;
    private int $end;
    private int $total;
    private int $indexStart;

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
        $this->indexStart = 0;
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
        $this->indexStart++;

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

        SynchronizationDetail::create([
            'idSincronizacao' => $synchronization->idSincronizacao,
            'nmEntidade' => $this->model,
            'numDadosAtualizados' => 0,
            'numDadosAtualizar' => $this->total,
        ]);
    }

    public function linkData(Synchronization $synchronization): void
    {
        $index = 0;
        do {
            $queue = App::make('queue.connection');
            $size = $queue->size('default');

            sleep(5);
            $index++;
        } while ($size > 0 && $index < 120);

        Customer::where('updated_at', '<', $synchronization->created_at)
            ->update(['deleted_at' => Carbon::now()]);

        $syncDetail = $synchronization->syncDetails()->where('nmEntidade', Customer::class)->first();

        Customer::chunk(100, function($customers) use($synchronization, $syncDetail) {
            $jobs = [];

            foreach($customers as $customer) {
                $jobs[] = new LinkOrders($synchronization, $customer);
                $jobs[] = new LinkInvoices($synchronization, $customer);
            }

            Bus::batch($jobs)->name('Batch Linking Database')->dispatch();

            $syncDetail->numDadosAtualizados += count($customers);
            $syncDetail->save();
        });
    }
}
