<?php

namespace App\Livewire;

use App\Models\CreditLimit;
use Livewire\Component;

class CreditLimitDashboard extends Component
{
    public $creditLimits = [];

    public function mount()
    {
        $this->creditLimits = CreditLimit::with('organization')->whereHas('organization.users', function($query) {
            $query->where('get_user_id', auth()->user()->id);
        })
        ->get();
    }

    public function render()
    {
        return view('livewire.credit-limit-dashboard');
    }
}
