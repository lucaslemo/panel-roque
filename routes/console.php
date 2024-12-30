<?php

use App\Jobs\Instagram\RefreshInstagramToken;
use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::call(fn () => RefreshInstagramToken::dispatch())
    ->name('Refresh Instagram access token')
    ->monthlyOn(1, '01:00');
