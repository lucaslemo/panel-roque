<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class UsersLastActivityTable extends DataTableComponent
{
    protected $model = User::class;

    public function setTableClass(): ?string
    {
        return 'table-auto';
    }

    public function builder(): Builder
    {
        return User::whereNotNull('users.last_login_at')
            ->leftJoin('sessions', 'sessions.user_id', '=', 'users.id')
            ->select('sessions.last_activity');
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
            Column::make(__('Type'), 'type')
                ->format(fn ($value, $row, Column $column) => view('livewire.tables.active-user-status', ['row' => $row]))
                ->sortable(),
            DateColumn::make(__('Last login at'), 'last_login_at')
                ->inputFormat('Y-m-d H:i:s')
                ->outputFormat('d/m/Y H:i:s')
                ->sortable(),
            Column::make(__('Online'))
                ->label(fn ($row, Column $column) => view('livewire.tables.online-user-status', ['row' => $row]))
        ];
    }
}
