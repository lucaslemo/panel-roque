<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class OrdersTable extends DataTableComponent
{
    protected $model = Order::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return Order::whereHas('customer.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('idPedidoCabecalho ');
        $this->setPageName('orders');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'idPedidoCabecalho ')
                ->sortable(),
            Column::make(__('Branch'), 'branch.nmFilial')
                ->searchable()
                ->sortable(),
            Column::make(__('Delivery Type'), 'tpEntrega')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Order Date'), 'dtPedido')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make('RCA', 'nmVendedor')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Billing Date'), 'dtFaturamento')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Value'), 'vrTotal')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Charge'), 'tpCobranca')
                ->searchable()
                ->sortable(),
            Column::make(__('Status'), 'statusPedido')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Delivery Date'), 'dtEntrega')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Purchase Order'), 'numOrdemCompra')
                ->searchable()
                ->sortable(),
        ];
    }
}
