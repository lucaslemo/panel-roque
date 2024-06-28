<?php

namespace App\Livewire;

use App\Models\BillToReceive;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class BillsToReceiveDashboardTable extends DataTableComponent
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
        })
        ->whereNull('bills_to_receive.payment_date')
        ->orderBy('bills_to_receive.expiry_date', 'ASC');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('billsToReceive');
        $this->setPerPageAccepted([5, 15, 30]);
        $this->setPerPage(5);
    }

    public function columns(): array
    {
        return [
            DateColumn::make(__('Portion Date'), 'portion_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Updated Total'), 'updated_total')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            DateColumn::make(__('Expiry Date'), 'expiry_date')
                ->inputFormat('Y-m-d')
                ->outputFormat('d/m/Y')
                ->sortable(),
            Column::make(__('Status'), 'status')
                ->searchable()
                ->sortable(),
            Column::make(__('Organization'), 'organization.name')
                ->searchable()
                ->sortable(),
        ];
    }
}
