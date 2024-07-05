<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class UserLoginAt
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
        try {
            optional($event->user)->update([
                'last_login_at' => Carbon::now(),
            ]);
        } catch (\Throwable $th) {
            report($th);
        }

    }
}
