<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class LastOrdersDashboard extends Component
{
    public array|Collection $lastOrders = [];
    public array|Collection $customers = [];
    public array $selectedCustomers = [];
    public Order|null $order = null;

    private function fetchOrders()
    {
        try {
            $this->lastOrders = DB::table('orders')
                ->select(['orders.*', 'customers.nmCliente'])
                ->join('customers', 'customers.idCliente', '=', 'orders.idCliente')
                ->whereIn('customers.idCliente', array_keys($this->selectedCustomers, true))
                ->whereNull('orders.deleted_at')
                ->whereNull('customers.deleted_at')
                ->orderByRaw("CASE WHEN statusEntrega = 'Entregue' THEN 2 ELSE 1 END")
                ->orderBy('dtPedido', 'DESC')
                ->take(5)
                ->get();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching customer data.'), $th->getMessage(), 'danger');
        }
    }

    public function toggleCustomer(int $id)
    {
        if (array_key_exists($id, $this->selectedCustomers)) {
            $this->selectedCustomers[$id] = !$this->selectedCustomers[$id];
        }

        // Se nenhuma filial for selecionada todas serão
        if (!in_array(true, $this->selectedCustomers)) {
            $this->selectedCustomers = array_map(function() { return true; }, $this->selectedCustomers);
        }

        $this->fetchOrders();

        $this->dispatch('update-cards', array_keys($this->selectedCustomers, true))->to(CreditLimitCards::class);
    }

    /**
     * Reload user default info.
     */
    #[On('set-order-detail')]
    public function setOrderDetail(int $id): void
    {
        $this->order = Order::select(['orders.*', 'customers.nmCliente'])
            ->with('orderHistories')
            ->join('customers', 'customers.idCliente', '=', 'orders.idCliente')
            ->whereIn('orders.idCliente', array_keys($this->selectedCustomers, true))
            ->findOrFail($id);

        $this->dispatch('open-modal', 'product-detail');
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

            $this->fetchOrders();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching data.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.last-orders-dashboard');
    }
}
