<?php

namespace App\Livewire;

use App\Jobs\Query\SyncCustomersInvoices;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InvoicesDatatable extends Component
{
    public array|Collection $invoices = [];
    public int $totalData = 0;
    public int $perPage = 4;
    public int $totalPages = 0;
    public int $page = 0;

    /**
     * Go to the specific page.
     */
    public function goToPage(int $page)
    {
        if ($page >= 0 && $page < $this->totalPages) {
            $this->page = $page;
            $this->fetchInvoices();
        }
    }

    /**
     * Go to the next page.
     */
    public function nextPage()
    {
        if ($this->page < $this->totalPages - 1) {
            $this->page++;
            $this->fetchInvoices();
        }
    }

    /**
     * Go to the previous page.
     */
    public function previousPage()
    {
        if ($this->page > 0) {
            $this->page--;
            $this->fetchInvoices();
        }
    }

    private function fetchInvoices()
    {
        try {
            $customersUniqueId = Session::get('customers_unique_id', '');
            $synced = Cache::get('orders' . $customersUniqueId, false);

            if (!$synced) {
                Cache::put('orders' . $customersUniqueId, true, now()->addMinutes(10));
                SyncCustomersInvoices::dispatchSync(auth()->user(), 1);
            }
            
            $this->totalData = DB::table('invoices')
                ->join('customers', 'customers.idCliente', '=', 'invoices.idCliente')
                ->join('users_has_customers', 'users_has_customers.idCliente', '=', 'customers.idCliente')
                ->where('users_has_customers.idUsuario', auth()->user()->id)
                ->where('statusConta', 'Aberto')
                ->whereNull('invoices.deleted_at')
                ->whereNull('customers.deleted_at')
                ->count();

            // Conta o total de páginas
            $this->totalPages = ceil($this->totalData / $this->perPage);

            $this->invoices = DB::table('invoices')
                ->select(['invoices.*'])
                ->join('customers', 'customers.idCliente', '=', 'invoices.idCliente')
                ->join('users_has_customers', 'users_has_customers.idCliente', '=', 'customers.idCliente')
                ->where('users_has_customers.idUsuario', auth()->user()->id)
                ->where('statusConta', 'Aberto')
                ->whereNull('invoices.deleted_at')
                ->whereNull('customers.deleted_at')
                ->orderBy('dtVencimento', 'ASC')
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

    public function mount()
    {
        try {

            $this->fetchInvoices();

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
        return view('livewire.invoices-datatable');
    }
}
