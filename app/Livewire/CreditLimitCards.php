<?php

namespace App\Livewire;

use App\Models\CreditLimit;
use Livewire\Component;

class CreditLimitCards extends Component
{
    public $creditLimits = [];

    public function mount()
    {
        $this->creditLimits = CreditLimit::with('customer')->whereHas('customer.users', function($query) {
            $query->where('idUsuario', auth()->user()->id);
        })
        ->get();
    }

    public function render()
    {
        return view('livewire.credit-limit-cards');
    }
}
