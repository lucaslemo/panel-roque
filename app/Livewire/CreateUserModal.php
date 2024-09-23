<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CreateUserModal extends Component
{
    public bool $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    #[On('closeCreateUserModal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('clearCreateUserForm')->to(CreateUserForm::class);
    }

    public function render()
    {
        return view('livewire.create-user-modal');
    }
}
