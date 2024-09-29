<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class UserRegistrationChat extends Component
{
    public User|null $user = null;
    public array $messages = [];
    public bool $showPassword = false;
    public bool $buttonDisabled = false;
    public string $password = '';
    public int $currentPhase = 0;

    /**
     * Toggle visibility of password input.
     */
    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
        $this->dispatch('focus-password');
    }

    /**
     * Add a message to the messages array.
     */
    public function addMessage(): void
    {
        
    }

    /**
     * Each request made update the animation trigger for every message on screen.
     */
    public function hydrate()
    {
        $messages = [];
        foreach($this->messages as $message) {
            if ((int)$message['phase'] <= $this->currentPhase) {
                $message['animation'] = false;
            }
            $messages[] = $message;
        }
        $this->messages = $messages;
    }


    public function mount(User $user)
    {
        $this->user = $user;
        $this->messages = [
            [
                'message' => Lang::get("For your security, let's first create a login password for future access to the site, ok?"),
                'animation' => true,
                'time' => 1000,
                'phase' => 0,
            ],
            [
                'message' => Lang::get('Your password must contain at least 8 characters, including letters and numbers.'),
                'animation' => true,
                'time' => 2000,
                'phase' => 0,
            ],
            [
                'message' => Lang::get('Here we go. Enter the password you want.'),
                'animation' => true,
                'time' => 3000,
                'phase' => 0,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
