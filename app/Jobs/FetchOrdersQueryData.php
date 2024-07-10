<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchOrdersQueryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $urlBase = config('app.query_orders');

            DB::beginTransaction();

            DB::table('orders')->delete();

            $response = Http::get($urlBase);

            foreach($response as $order) {
                
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
        }
    }
}
