<?php

namespace App\Utilities;

use App\Jobs\CustomersStore;
use App\Jobs\InvoicesStore;
use App\Jobs\OrdersStore;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Update;
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
            $this->job = CustomersStore::class;

        } else if ($this->model === Order::class) {
            $this->key = 'pedidos';
            $this->job = OrdersStore::class;

        } else if ($this->model === Invoice::class) {
            $this->key = 'duplicatas';
            $this->job = InvoicesStore::class;

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
    public function start(): void
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
                $jobs[] = new $this->job($chunk);
            }

            Bus::batch($jobs)->name("Batch {$this->model}")->dispatch();

            $morePages = $this->nextStep($data->count());
        }

        Update::create([
            'nmEntidade' => $this->model,
            'numTotalDados' => $this->total,
        ]);
    }
}
