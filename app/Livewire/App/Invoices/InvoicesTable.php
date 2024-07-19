<?php

namespace App\Livewire\App\Invoices;

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
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('idConta');
        $this->setPageName('invoices');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'idConta')
                ->sortable(),
            Column::make(__('Branch'), 'branch.nmFilial')
                ->searchable()
                ->sortable(),
            Column::make(__('Charge'), 'tpCobranca')
                ->searchable()
                ->sortable(),
            Column::make(__('Duplicate'), 'numDuplicado')
                ->sortable(),
            DateColumn::make(__('Portion Date'), 'dtParcela')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Total Gross'), 'vrBruto')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Net Total'), 'vrLiquido')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Updated Total'), 'vrAtualizado')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Amount Paid'), 'vrPago')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $value ? 'R$ ' . number_format($value, 2, ',', '.') : null
                ),
            DateColumn::make(__('Emission Date'), 'dtEmissao')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            DateColumn::make(__('Expiry Date'), 'dtVencimento')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            DateColumn::make(__('Payment Date'), 'dtPagamento')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Status'), 'statusConta')
                ->searchable()
                ->sortable(),
            Column::make(__('Situation'), 'nmSituacao')
                ->searchable()
                ->sortable(),
            Column::make(__('RCA'), 'nmVendedor')
                ->searchable()
                ->sortable(),
            Column::make(__('Check'), 'numCheque')
                ->searchable()
                ->sortable(),
        ];
    }
}
