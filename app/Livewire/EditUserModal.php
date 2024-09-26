<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class EditUserModal extends Component
{
    public bool $showModal = false;

    #[On('openEditUserModal')]
    public function openModal(int $id)
    {
        $this->showModal = true;
        $this->dispatch('fillFormEditUserForm', $id)->to(EditUserForm::class);
    }

    #[On('closeEditUserModal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('clearEditUserForm')->to(EditUserForm::class);
    }

    public function render()
    {
        return view('livewire.edit-user-modal');
    }
}
