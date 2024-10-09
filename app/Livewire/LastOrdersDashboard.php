<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Livewire\Component;

class LastOrdersDashboard extends Component
{
    public array|Collection $customers = [];
    public array $selectedCustomers = [];

    public function toggleCustomer(int $id)
    {
        if (array_key_exists($id, $this->selectedCustomers)) {
            $this->selectedCustomers[$id] = !$this->selectedCustomers[$id];
        }

        // Se nenhuma filial for selecionada todas serão
        if (!in_array(true, $this->selectedCustomers)) {
            $this->selectedCustomers = array_map(function() { return true; }, $this->selectedCustomers);
        }

        $this->dispatch('update-cards', array_keys($this->selectedCustomers, true))->to(CreditLimitCards::class);
    }

    public function mount()
    {
        try {
            $this->customers = Customer::whereHas('users', function($query) {
                $query->where('users.id', auth()->user()->id);
            })
            ->get();

            foreach($this->customers as $customer) {
                $this->selectedCustomers[$customer->idCliente] = true;
            }

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching customer data.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.last-orders-dashboard');
    }
}
