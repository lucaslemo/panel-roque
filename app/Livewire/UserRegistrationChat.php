<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserRegistrationChat extends Component
{
    public User|null $user = null;
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

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
