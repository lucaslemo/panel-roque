<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Exceptions\UnauthorizedException;

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

    public function activate($id)
    {
        try {
            if(!optional(auth()->user())->hasRole('Super Admin')){
                throw new UnauthorizedException(403, 'User does not have the right roles.');
            }

            $user = User::findOrFail($id);
            $user->active = true;
            $user->save();
        } catch (\Exception $e) {
            $this->dispatch('showAlert', __('Error activating the user.'), $e->getMessage(), 'danger');
        }
    }

    public function deactivate($id)
    {
        try {
            if(!optional(auth()->user())->hasRole('Super Admin')){
                throw new UnauthorizedException(403, 'User does not have the right roles.');
            }
            if (auth()->user()->id == $id) {
                throw new \Exception('For security reasons, you cannot deactivate your own account.');
            }

            $user = User::findOrFail($id);
            $user->active = false;
            $user->save();
        } catch (\Exception $e) {
            $this->dispatch('showAlert', __('Error deactivating the user.'), $e->getMessage(), 'danger');
        }
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')->sortable(),
            Column::make(__('Name'), 'name')
                ->format(
                    fn ($value, $row, Column $column) => view('livewire.tables.link-table', ['href' => route('admin.users.edit', $row->id), 'title' => $value])
                )
                ->searchable()
                ->sortable(),
            Column::make(__('Email'), 'email')->searchable()->sortable(),
            Column::make(__('Status'), 'type')
                ->format(fn ($value, $row, Column $column) => view('livewire.tables.active-user-status', ['row' => $row]))
                ->sortable(),
            Column::make(__('Action'), 'active')
                ->format(fn ($value, $row, Column $column) => view('livewire.tables.button-users-table', ['row' => $row])),
        ];
    }
}
