<?php

use App\Jobs\Instagram\RefreshInstagramToken;
use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

// Schedule::call(fn () => StartSynchronization::dispatch(50))
//     ->name('Start of database synchronization')
//     ->before(fn () => Log::channel('synchronization')->info('The database began to synchronize'))
//     ->dailyAt('00:01');

Schedule::call(fn () => RefreshInstagramToken::dispatch())
    ->name('Refresh Instagram access token')
    ->monthlyOn(1, '01:00');
