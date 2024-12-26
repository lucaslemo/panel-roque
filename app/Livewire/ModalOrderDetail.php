<?php

namespace App\Livewire;

use App\Jobs\Query\SyncOrdersLogs;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
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
            $synced = Cache::get('order_detail_' . $id, false);

            if (!$synced || true) {
                Cache::put('order_detail_' . $id, true, now()->addMinutes(10));
                SyncOrdersLogs::dispatchSync($id, 1);
            }

            $this->order = Order::select(['orders.*', 'customers.nmCliente'])
                ->with(['orderHistories' => function($query) {
                    $query->orderBy('dtStatusPedido', 'DESC');
                }])
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
