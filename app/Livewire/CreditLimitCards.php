<?php

namespace App\Livewire;

use App\Models\CreditLimit;
use Livewire\Attributes\On;
use Livewire\Component;

class CreditLimitCards extends Component
{
    public float $limit = 0;
    public float $used = 0;
    public float $reserved = 0;
    public float $available = 0;

    private function fetchData(array $ids = [])
    {
        try {
            $creditLimits = CreditLimit::with('customer')
                ->whereHas('customer.users', function($query) {
                    $query->where('idUsuario', auth()->user()->id);
                })
                ->when(count($ids) > 0, function($query) use($ids) {
                    $query->whereIn('credit_limits.idLimiteDeCredito', $ids);
                })
                ->get();

            $this->limit = $creditLimits->sum('vrLimite');
            $this->used = $creditLimits->sum('vrUtilizado');
            $this->reserved = $creditLimits->sum('vrReservado');
            $this->available = $creditLimits->sum('vrDisponivel');
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching card data.'), $th->getMessage(), 'danger');
        }
    }

    #[On('update-cards')]
    public function update(array $ids)
    {
        $this->fetchData($ids);
    }

    public function mount()
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.credit-limit-cards');
    }
}
