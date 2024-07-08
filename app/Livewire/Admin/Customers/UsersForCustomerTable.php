<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsersForCustomerTable extends DataTableComponent
{
    public $customerId = 0;
    protected $model = User::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function mount($id)
    {
        $this->customerId = $id;
    }

    public function builder(): Builder
    {
        return User::whereHas('customers', function($query) {
            $query->where('usuariosPossuemClientes.idCliente', $this->customerId);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('users');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function removeUser($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->customers()->detach($this->customerId);

            $this->dispatch('refreshDatatable');
            $this->dispatch('add-user', name: $user->name);
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error removing user.'), $th->getMessage(), 'danger');
        }
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')->sortable(),
            Column::make(__('Name'), 'name')->searchable()->sortable(),
            Column::make(__('Email'), 'email')->searchable()->sortable(),
            Column::make(__('Status'), 'active')
                ->format(fn ($value, $row, Column $column) => view('livewire.tables.active-user-status', ['row' => $row]))
                ->sortable(),
            Column::make(__('Action'), 'active')
                ->format(fn ($value, $row, Column $column) => view('livewire.tables.remove-button-users-table', ['row' => $row])),
        ];
    }
}
