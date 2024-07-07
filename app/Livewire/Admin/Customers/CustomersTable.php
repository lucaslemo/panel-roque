<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CustomersTable extends DataTableComponent
{
    protected $model = Customer::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function configure(): void
    {
        $this->setPrimaryKey('idCliente');
        $this->setPageName('customers');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'idCliente')->sortable(),
            Column::make(__('Name'), 'nmCliente')->searchable()->sortable(),
            Column::make(__('Type'), 'tpCliente')->searchable()->sortable(),
        ];
    }
}
