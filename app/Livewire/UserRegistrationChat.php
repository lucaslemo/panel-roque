<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserRegistrationChat extends Component
{
    public User|null $user = null;
    public array $messages = [];
    public string $password = '';
    public string $password_confirmation = '';
    public int $stage = 0;

    /**
     * Add a message to the messages array.
     */
    public function addMessage(): void
    {
        $validated = Validator::make(
            ['password' => $this->password],
            ['password' => ['required', 'string', $this->stage === 1 ? 'confirmed' : '', Password::defaults()->uncompromised()->letters()->numbers()]],
        );

        $type = $validated->fails() ? 'error' : 'sent';

        $this->messages[] = [
            'message' => $this->password,
            'animation' => true,
            'time' => 0,
            'type' => $type,
        ];

        foreach ($validated->errors()->get('password') as $key => $error) {
            $this->messages[] = [
                'message' => $error,
                'animation' => true,
                'time' => ($key + 1) * 1000,
                'type' => 'received',
            ];
        }

        if ($type === 'sent' && $this->stage === 0) {
            $this->stage += 1;
            $this->password_confirmation = $this->password;
            $this->messages[] = [
                'message' => Lang::get('Please enter your password again.'),
                'animation' => true,
                'time' => 1000,
                'type' => 'received',
            ];
        } else if ($type === 'sent' && $this->stage === 1) {
            $this->stage += 1;
            $this->messages[] = [
                'message' => Lang::get('Password registered.'),
                'animation' => true,
                'time' => 1000,
                'type' => 'received',
            ];
            $this->messages[] = [
                'message' => Lang::get('We have some information about you in the system, such as your phone number and email address. Do you want to validate that your data is correct?'),
                'animation' => true,
                'time' => 2000,
                'type' => 'received',
            ];
        }

        $this->password = '';
    }

    /**
     * Each request made update the animation trigger for every message on screen.
     */
    public function hydrate()
    {
        $messages = [];
        foreach($this->messages as $message) {
            $message['animation'] = false;
            $messages[] = $message;
        }
        $this->messages = $messages;
    }


    /**
     * Mount the initial data for chat.
     */
    public function mount(User $user)
    {
        $this->user = $user;
        $this->messages = [
            [
                'message' => Lang::get("For your security, let's first create a login password for future access to the site, ok?"),
                'animation' => true,
                'time' => 1000,
                'type' => 'received',
            ],
            [
                'message' => Lang::get('Your password must contain at least 8 characters, including letters and numbers.'),
                'animation' => true,
                'time' => 2000,
                'type' => 'received',
            ],
            [
                'message' => Lang::get('Here we go. Enter the password you want.'),
                'animation' => true,
                'time' => 3000,
                'type' => 'received',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
