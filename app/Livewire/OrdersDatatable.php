<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class OrdersDatatable extends Component
{
    public array|Collection $orders = [];
    public array|Collection $customers = [];
    public Order|null $order = null;
    public array $selectedCustomers = [];
    public int $totalData = 0;
    public int $perPage = 7;
    public int $totalPages = 0;
    public int $page = 0;

    /**
     * Go to the specific page.
     */
    public function goToPage(int $page)
    {
        if ($page >= 0 && $page < $this->totalPages) {
            $this->page = $page;
            $this->fetchOrders();
        }
    }

    /**
     * Go to the next page.
     */
    public function nextPage()
    {
        if ($this->page < $this->totalPages - 1) {
            $this->page++;
            $this->fetchOrders();
        }
    }

    /**
     * Go to the previous page.
     */
    public function previousPage()
    {
        if ($this->page > 0) {
            $this->page--;
            $this->fetchOrders();
        }
    }

    private function fetchOrders()
    {
        try {
            $this->totalData = DB::table('orders')
                ->join('customers', 'customers.idCliente', '=', 'orders.idCliente')
                ->whereIn('orders.idCliente', array_keys($this->selectedCustomers, true))
                ->whereNull('orders.deleted_at')
                ->whereNull('customers.deleted_at')
                ->count();

            // Conta o total de páginas
            $this->totalPages = ceil($this->totalData / $this->perPage);

            $this->orders = DB::table('orders')
                ->select(['orders.*', 'customers.nmCliente'])
                ->join('customers', 'customers.idCliente', '=', 'orders.idCliente')
                ->whereIn('customers.idCliente', array_keys($this->selectedCustomers, true))
                ->whereNull('orders.deleted_at')
                ->whereNull('customers.deleted_at')
                ->orderByRaw("CASE WHEN statusEntrega = 'Entregue' THEN 2 ELSE 1 END")
                ->orderBy('dtPedido', 'DESC')
                ->skip($this->page * $this->perPage)
                ->take($this->perPage)
                ->get();

            // Verifica se a página inicial está fora do novo range
            while ($this->page > $this->totalPages - 1 && $this->totalPages > 0) {
                $this->page--;
            }

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
                ->whereIn('orders.idCliente', array_keys($this->selectedCustomers, true))
                ->findOrFail($id);

            $this->dispatch('open-modal', 'product-detail');

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error fetching data.'), $th->getMessage(), 'danger');
        }
    }

    /**
     * Placeholder when table is not loaded.
     */
    public function placeholder()
    {
        return view('components.spinner');
    }

    public function render()
    {
        return view('livewire.orders-datatable');
    }
}
