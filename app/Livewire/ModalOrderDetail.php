<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalOrderDetail extends Component
{
    public Order|null $order = null;

    /**
     * Reload user default info.
     */
    #[On('set-order-detail')]
    public function setOrderDetail(int $id): void
    {
        try {
            $this->order = Order::select(['orders.*', 'customers.nmCliente'])
                ->with('orderHistories')
                ->join('customers', 'customers.idCliente', '=', 'orders.idCliente')
                ->join('users_has_customers', 'users_has_customers.idCliente', '=', 'customers.idCliente')
                ->where('users_has_customers.idUsuario', auth()->user()->id)
                ->findOrFail($id);

            $this->dispatch('open-modal', 'product-detail');

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching data.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.modal-order-detail');
    }
}
