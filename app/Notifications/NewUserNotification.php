<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'mail', 
            WhatsAppChannel::class,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $token = Crypt::encryptString($this->user->register_token);

        if ((int)$this->user->type === 2) {
            $url = route('customer.register', urlencode($token)) . '?email=' . urlencode($this->user->email);
        } else {
            $url = route('register', urlencode($token)) . '?email=' . urlencode($this->user->email);
        }

        return (new MailMessage)
            ->subject(Lang::get('Registration notification'))
            ->greeting(Lang::get('Hello, ') .  $this->user->name . '. ' . Lang::get('All good?'))
            ->line(Lang::get('We created the Customer Portal to make it even easier for you to track your orders!'))
            ->line(Lang::get('To complete your registration and gain access, click the button below:'))
            ->action(Lang::get('Continue registration'), $url)
            ->line(Lang::get('If you have any difficulties, ask us for help. We are here to help you!'));
    }

    /**
     * Get the whatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): array
    {
        $token = Crypt::encryptString($this->user->register_token);

        if ((int)$this->user->type === 2) {
            $url = route('customer.register', urlencode($token)) . '?email=' . urlencode($this->user->email);
        } else {
            $url = route('register', urlencode($token)) . '?email=' . urlencode($this->user->email);
        }

        $message = Lang::get('Hello, ') .  $this->user->name . '. ' . Lang::get('All good?') . "\n\n";
        $message .= Lang::get('We created the Customer Portal to make it even easier for you to track your orders!') . "\n\n";
        $message .= Lang::get('To complete your registration and gain access, click the button below:') . "\n\n";
        $message .= $url . "\n\n";
        $message .= Lang::get('If you have any difficulties, ask us for help. We are here to help you!');

        return [
            'phone' => $this->user->phone,
            'message' => $message,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
