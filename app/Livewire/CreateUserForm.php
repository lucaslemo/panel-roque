<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CreateUserForm extends Component
{
    public int $currentPhase = 0;

    public function cancel()
    {
        $this->dispatch('closeCreateUserModal')->to(CreateUserModal::class);
    }

    public function nextPage()
    {
        $this->currentPhase++;
    }

    #[On('clearCreateUserForm')]
    public function clearForm()
    {
        $this->currentPhase = 0;
    }

    public function render()
    {
        return view('livewire.create-user-form');
    }
}
