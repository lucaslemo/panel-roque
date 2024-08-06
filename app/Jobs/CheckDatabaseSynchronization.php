<?php

namespace App\Jobs;

use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

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
        public string $customersBatchId,
        public string $ordersBatchId,
        public string $invoicesBatchId,
        public int $attempt
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customersBatch = Bus::findBatch($this->customersBatchId);
        $ordersBatch = Bus::findBatch($this->ordersBatchId);
        $invoicesBatch = Bus::findBatch($this->invoicesBatchId);

        $batchesExist = !is_null($customersBatch) && !is_null($ordersBatch) && !is_null($invoicesBatch);

        $batchesFinished = optional($customersBatch)->finished()
            && optional($ordersBatch)->finished()
            && optional($invoicesBatch)->finished();

        $batchesCancelled = optional($customersBatch)->cancelled()
            || optional($ordersBatch)->cancelled()
            || optional($invoicesBatch)->cancelled();

        if ($batchesCancelled) {
            throw new \Exception('One or more batches were cancelled');
        }

        if (!$batchesExist && $this->attempt >= 100) {
            throw new \Exception('After 100 attempts, one or more batches were not found');
        }

        if ($batchesFinished) {
            $synchronization = Synchronization::findOrFail($this->synchronizationId);
            $synchronization->dtFinalBusca = now();
            $synchronization->save();
            LinkCustomer::dispatch($this->synchronizationId);
            return;
        }

        CheckDatabaseSynchronization::dispatch(
            $this->synchronizationId,
            $this->customersBatchId,
            $this->ordersBatchId,
            $this->invoicesBatchId,
            $this->attempt + 1
        )
        ->delay(now()->addSeconds(30));
    }
}
