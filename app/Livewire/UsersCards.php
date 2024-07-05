<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UsersCards extends Component
{
    public $usersOnline = 0;
    public $usersActive = 0;
    public $usersTotal = 0;

    public function mount()
    {
        try {
            $this->usersOnline = DB::table('users')
                ->join('sessions', 'sessions.user_id', '=', 'users.id')
                ->whereNull('users.deleted_at')
                ->distinct('users.id')
                ->count('users.id');

            $this->usersActive = DB::table('users')
                ->whereNull('users.deleted_at')
                ->whereNotNull('users.last_login_at')
                ->distinct('users.id')
                ->count('users.id');

            $this->usersTotal = DB::table('users')
                ->whereNull('users.deleted_at')
                ->distinct('users.id')
                ->count('users.id');
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching card data.'), $th->getMessage(), 'danger');
        }

    }

    public function render()
    {
        return view('livewire.users-cards');
    }
}
