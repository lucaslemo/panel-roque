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
            Column::make(__('Name'), 'nmCliente')
                ->format(
                    fn ($value, $row, Column $column) => view('livewire.tables.link-table', ['href' => route('admin.customers.edit', $row->idCliente), 'title' => $value])
                )
                ->searchable()
                ->sortable(),
            Column::make(__('CPF/CNPJ'), 'codCliente')
                ->format(
                    fn ($value, $row, Column $column) => formatCnpjCpf($value)
                )
                ->searchable()
                ->sortable(),
            Column::make(__('Email'), 'emailCliente')->searchable()->sortable(),
            Column::make(__('Type'), 'tpCliente')
                ->format(
                    fn ($value, $row, Column $column) => $value === 'F' ? 'Pessoa Física' : 'Pessoa Jurídica'
                )
                ->searchable()
                ->sortable(),
        ];
    }
}
