<?php

use App\Jobs\Instagram\RefreshInstagramToken;
use App\Jobs\Query\SyncCustomersPeriodically;
use App\Models\Synchronization;
use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::call(function () {
        $lastDate = Synchronization::orderBy('dtSincronizacao', 'DESC')->first()->dtSincronizacao;
        SyncCustomersPeriodically::dispatch($lastDate, 1);
        Synchronization::create([
            'dtSincronizacao' => now()->format('Y-m-d H:i:s')
        ]);
    })
    ->name('Sync customers')
    ->everyThirtyMinutes();

Schedule::call(fn () => RefreshInstagramToken::dispatch())
    ->name('Refresh Instagram access token')
    ->monthlyOn(1, '01:00');
