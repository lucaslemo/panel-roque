<?php
 
namespace App\Livewire;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class SalesTable extends DataTableComponent
{
    protected $model = Sale::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return Sale::whereHas('organization.users', function($query) {
            $query->where('users.id', auth()->user()->id);
        });
    }
 
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('sales');
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
            Column::make(__('Delivery Type'), 'delivery_type')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Order Date'), 'order_date')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make('RCA', 'rca')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Billing Date'), 'billing_date')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Value'), 'value')
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => 'R$ ' . number_format($value, 2, ',', '.')
                ),
            Column::make(__('Charge'), 'cob')
                ->searchable()
                ->sortable(),
            Column::make(__('Status'), 'status')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Delivery Date'), 'delivery_date')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Type'), 'type')
                ->searchable()
                ->sortable(),
            Column::make(__('Delivery Status'), 'delivery_status')
                ->searchable()
                ->sortable(),
            DateColumn::make(__('Creation Date'), 'creation_date')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Purchase Order'), 'purchase_order')
                ->searchable()
                ->sortable(),
        ];
    }
}