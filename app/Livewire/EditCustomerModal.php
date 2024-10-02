<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class EditCustomerModal extends Component
{
    public bool $showModal = false;

    #[On('openEditCustomerModal')]
    public function openModal(int $id)
    {
        $this->showModal = true;
        $this->dispatch('fillFormEditCustomerForm', $id)->to(EditCustomerForm::class);
    }

    #[On('closeEditCustomerModal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('clearEditCustomerForm')->to(EditCustomerForm::class);
    }

    public function render()
    {
        return view('livewire.edit-customer-modal');
    }
}
