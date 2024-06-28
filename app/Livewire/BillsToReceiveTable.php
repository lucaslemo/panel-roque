<?php

namespace App\Livewire;

use App\Models\BillToReceive;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class BillsToReceiveTable extends DataTableComponent
{
    protected $model = BillToReceive::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return BillToReceive::whereHas('organization.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('billsToReceive');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),
            Column::make(__('Branch'), 'branch')
                ->searchable()
                ->sortable(),
            Column::make(__('Charge'), 'cob')
                ->searchable()
                ->sortable(),
            Column::make(__('Duplicate'), 'duplicate')
                ->sortable(),
            DateColumn::make(__('Portion Date'), 'portion_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Total Gross'), 'total_gross')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Net Total'), 'net_total')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Updated Total'), 'updated_total')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Amount Paid'), 'amount_paid')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $value ? 'R$ ' . number_format($value, 2, ',', '.') : null
                ),
            DateColumn::make(__('Emission Date'), 'emission_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            DateColumn::make(__('Expiry Date'), 'expiry_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            DateColumn::make(__('Payment Date'), 'payment_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Status'), 'status')
                ->searchable()
                ->sortable(),
            Column::make(__('Situation'), 'situation')
                ->searchable()
                ->sortable(),
            Column::make(__('RCA'), 'rca')
                ->searchable()
                ->sortable(),
            Column::make(__('Check'), 'check')
                ->searchable()
                ->sortable(),
        ];
    }
}
