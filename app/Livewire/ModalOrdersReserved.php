<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalOrdersReserved extends Component
{
    public float $reservedValue = 0;
    public array|Collection $orders = [];

    #[On('upload-orders-reserved')]
    public function fetchData(array $ids = [])
    {
        try {
            $this->orders = Order::with('customer')
            ->where('orders.statusPedido', 'Prevenda') // Filtro dos pedidos em pré venda
            ->whereHas('customer.users', function($query) {
                $query->where('idUsuario', auth()->user()->id);
            })
            ->when(count($ids) > 0, function($query) use($ids) {
                $query->whereIn('orders.idCliente', $ids);
            })
            ->get();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching data.'), $th->getMessage(), 'danger');
        }
    }

    #[On('open-modal-reserved')]
    public function openModal(float $value): void
    {
        $this->reservedValue = $value;
        $this->dispatch('open-modal', 'pre-order');
    }

    public function mount()
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.modal-orders-reserved');
    }
}
