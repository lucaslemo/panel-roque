<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class EditCustomerDefaultModal extends Component
{
    public bool $showModal = false;

    #[On('openEditCustomerDefaultModal')]
    public function openModal(int $id)
    {
        $this->showModal = true;
        $this->dispatch('fillFormEditCustomerDefaultForm', $id)->to(EditCustomerDefaultForm::class);
    }

    #[On('closeEditCustomerDefaultModal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('clearEditCustomerDefaultForm')->to(EditCustomerDefaultForm::class);
    }

    public function render()
    {
        return view('livewire.edit-customer-default-modal');
    }
}
