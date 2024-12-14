<?php
 
 namespace App\Notifications\Channels;
 
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            throw new \Exception('toWhatsApp is not implemented on notification');
        }

        $data = $notification->toWhatsApp($notifiable);

        $instanceId = config('app.whatsapp_instance_id');
        $token = config('app.whatsapp_token');
        $clientToken = config('app.whatsapp_client_token');

        $urlZApi = "https://api.z-api.io/instances/{$instanceId}/token/{$token}/send-text";

        $response = Http::withHeaders([
            'cache-control' =>  'no-cache',
            'Content-Type' => 'application/json',
            'Client-Token' => $clientToken,
        ])->post($urlZApi, $data);

        Log::info($response);
        if ($response->failed() || $response->json('error', null)) {
            throw new \Exception('Error to send message to user');
        }
    }
}