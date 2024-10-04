<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CreateCustomerModal extends Component
{
    public bool $showModal = false;

    #[On('openCreateCustomerModal')]
    public function openModal(int $id)
    {
        $this->showModal = true;
        $this->dispatch('fetchCustomersCreateCustomerForm', $id)->to(CreateCustomerForm::class);
    }

    #[On('closeCreateCustomerModal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('clearCreateCustomerForm')->to(CreateCustomerForm::class);
    }

    public function render()
    {
        return view('livewire.create-customer-modal');
    }
}
