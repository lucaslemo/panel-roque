<?php

namespace App\Listeners;

use App\Jobs\Query\SyncDataOnLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserDataLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ((int) optional($event->user)->type !== 1) {
            SyncDataOnLogin::dispatch($event->user);
        }
    }
}
