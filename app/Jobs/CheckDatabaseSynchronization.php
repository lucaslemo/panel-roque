<?php

namespace App\Jobs;

use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CheckDatabaseSynchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        public int $synchronizationId,
        public int $attempt
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->attempt >= 100) {
            throw new \Exception('After 100 attempts, one or more jobs did not finish');
        }

        $synchronization = Synchronization::with(['syncDetails' => function($query) {
            $query->where('isCompleto', true);
        }])->findOrFail($this->synchronizationId);

        if (count($synchronization->syncDetails) < 3) {
            CheckDatabaseSynchronization::dispatch($this->synchronizationId, $this->attempt + 1)->delay(now()->addSeconds(60));
            return;
        }

        $synchronization->dtFinalBusca = now();
        $synchronization->save();
        LinkCustomer::dispatch($this->synchronizationId);
    }
}
