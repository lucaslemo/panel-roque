<?php

namespace App\Jobs\Query;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customers = Customer::with('invoices')
            ->whereHas('users', function($query) {
                $query->where('users.id', $this->user->id);
            })
            ->get();

        foreach ($customers as $customer) {
            $customer->invoices()->delete();
            FetchCustomersInvoices::dispatchSync($customer, 1);
            FetchCustomersHistory::dispatchSync($customer, 1);
        }
    }
}
