<?php

namespace App\Livewire;

use App\Models\CreditLimit;
use Livewire\Component;

class CreditLimitCards extends Component
{
    public $creditLimits = [];

    public function mount()
    {
        try {
            $this->creditLimits = CreditLimit::with('customer')->whereHas('customer.users', function($query) {
                $query->where('idUsuario', auth()->user()->id);
            })
            ->get();
        } catch (\Throwable $th) {
            report($th);
            $this->creditLimits = [0 => null];
            $this->dispatch('showAlert', __('Error when fetching card data.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.credit-limit-cards');
    }
}
