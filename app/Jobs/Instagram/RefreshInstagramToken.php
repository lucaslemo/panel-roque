<?php

namespace App\Jobs\Instagram;

use App\Models\User;
use App\Notifications\InstagramTokenRefreshFailedNotification;
use App\Notifications\InstagramTokenUpdateSuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class RefreshInstagramToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        if (app()->isLocal()) {
            $this->user = User::find(1);
        } else {
            $this->user = User::where('email', 'lucaslemodev@gmail.com')->first();
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://graph.instagram.com/refresh_access_token";
        $token = config('app.instagram_access_token');
        $grantType = "ig_refresh_token";

        // Realiza a requisição para atualizar o token
        $response = Http::get($url, ['grant_type' => $grantType, 'access_token' => $token]);

        if($response->failed()) {
            $this->user ? $this->user->notify(new InstagramTokenRefreshFailedNotification($response->body())) : null;
        }

        if ($response->ok()) {
            $this->user ? $this->user->notify(new InstagramTokenUpdateSuccessNotification($response->json('expires_in', null))) : null;
        }

        $response->throw();
    }
}
