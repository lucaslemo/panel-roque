<?php

use App\Jobs\StartSynchronization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::call(fn () => StartSynchronization::dispatch(50))
    ->name('Start of database synchronization')
    ->before(fn () => Log::channel('synchronization')->info('The database began to synchronize'))
    ->dailyAt('00:01');
