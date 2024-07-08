<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\User;
use Livewire\Component;

class AddUserToCustomer extends Component
{
    public $customerId = 0;
    public $user = 0;
    public $users = [];

    public function mount($id)
    {
        try {
            $this->customerId = $id;
            $this->users = User::where('type', 'customer')->get();
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), $th->getMessage(), 'danger');
        }
    }

    public function addUser()
    {
        $validated = $this->validate([
            'user' => ['required', 'numeric', 'not_in:0']
        ]);

        try {
            $user = User::findOrFail($validated['user']);
            $customer = Customer::findOrFail($this->customerId);

            $user->customers()->sync($customer, false);

            $this->user = 0;
            $this->dispatch('refreshDatatable');
            $this->dispatch('add-user', name: $user->name);
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error adding user.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.add-user-to-customer');
    }
}
