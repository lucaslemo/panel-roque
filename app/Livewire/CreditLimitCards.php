<?php

namespace App\Livewire;

use App\Jobs\Query\SyncDataOnLogin;
use App\Models\CreditLimit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
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
            $customersUniqueId = Session::get('customers_unique_id', '');
            $synced = Cache::get('customers' . $customersUniqueId, false);

            if (!$synced) {
                Cache::put('customers' . $customersUniqueId, true, now()->addMinutes(10));
                SyncDataOnLogin::dispatchSync(auth()->user());
            }

            $creditLimits = CreditLimit::with('customer')
                ->whereHas('customer.users', function($query) {
                    $query->where('idUsuario', auth()->user()->id);
                })
                ->when(count($ids) > 0, function($query) use($ids) {
                    $query->whereIn('credit_limits.idCliente', $ids);
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
        $this->dispatch('upload-orders-reserved', $ids)->to(ModalOrdersReserved::class);
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
