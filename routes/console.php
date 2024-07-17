<?php

use App\Events\StartSyncDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(fn () => StartSyncDatabase::dispatch())
    ->name('Start the chain to update the database')
    ->before(fn() => Log::info('Starting to synchronize databases'))
    ->after(fn() => Log::info('Database updated successfully'))
    ->onFailure(fn() => Log::info('Error updating data'))
    ->dailyAt('00:00');
