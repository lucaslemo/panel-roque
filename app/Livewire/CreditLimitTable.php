<?php

namespace App\Livewire;

use App\Models\CreditLimit;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CreditLimitTable extends DataTableComponent
{
    protected $model = CreditLimit::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return CreditLimit::whereHas('organization.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('creditLimits');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->sortable(),
            Column::make(__('Limit'), 'limit')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Used'), 'used')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Reserved'), 'reserved')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Available'), 'available')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $value ? 'R$ ' . number_format($value, 2, ',', '.') : null
                ),
            Column::make(__('Organization'), 'organization.name')
                ->searchable()
                ->sortable(),
        ];
    }
}
