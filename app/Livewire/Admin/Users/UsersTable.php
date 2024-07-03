<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('users');
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')->sortable(),
            Column::make(__('Name'), 'name')->searchable()->sortable(),
            Column::make(__('Email'), 'email')->searchable()->sortable(),
            BooleanColumn::make(__('Status'), 'active')->sortable()->setView('livewire.tables.active-user-status'),
        ];
    }
}
