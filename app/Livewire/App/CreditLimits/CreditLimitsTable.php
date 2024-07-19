<?php

namespace App\Livewire\App\CreditLimits;

use App\Models\CreditLimit;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CreditLimitsTable extends DataTableComponent
{
    protected $model = CreditLimit::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return CreditLimit::whereHas('customer.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('idLimiteDeCredito');
        $this->setPageName('creditLimits');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'idLimiteDeCredito')
                ->sortable(),
            Column::make(__('Customer'), 'customer.nmCliente')
                ->searchable()
                ->sortable(),
            Column::make(__('Limit'), 'vrLimite')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Used'), 'vrUtilizado')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Reserved'), 'vrReservado')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Available'), 'vrDisponivel')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $value ? 'R$ ' . number_format($value, 2, ',', '.') : null
                ),
        ];
    }
}
