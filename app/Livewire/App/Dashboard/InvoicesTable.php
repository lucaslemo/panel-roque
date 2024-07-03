<?php

namespace App\Livewire\App\Dashboard;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class InvoicesTable extends DataTableComponent
{
    protected $model = Invoice::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return Invoice::whereHas('customer.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        })
        ->whereNull('contas.dtPagamento')
        ->orderBy('contas.dtVencimento', 'ASC');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('idConta');
        $this->setPageName('invoices');
        $this->setPerPageAccepted([5, 15, 30]);
        $this->setPerPage(5);
    }

    public function columns(): array
    {
        return [
            DateColumn::make(__('Portion Date'), 'dtParcela')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Updated Total'), 'vrAtualizado')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            DateColumn::make(__('Expiry Date'), 'dtVencimento')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Status'), 'statusConta')
                ->searchable()
                ->sortable(),
            Column::make(__('Customer'), 'customer.nmCliente')
                ->searchable()
                ->sortable(),
        ];
    }
}
