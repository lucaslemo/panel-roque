<?php

use App\Jobs\Instagram\RefreshInstagramToken;
use App\Jobs\Query\SyncCustomersPeriodically;
use App\Models\Synchronization;
use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::call(fn () => SyncCustomersPeriodically::dispatch(now()->format('Y-m-d H:i:s'), 1))
    ->name('Sync customers')
    ->everyFiveMinutes();

Schedule::call(fn () => RefreshInstagramToken::dispatch())
    ->name('Refresh Instagram access token')
    ->monthlyOn(1, '01:00');
