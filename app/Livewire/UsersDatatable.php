<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UsersDatatable extends Component
{
    public $data = [];
    public $totalData = 0;
    public $perPages = 10;
    public $totalPages = 0;
    public $page = 0;

    public function nextPage()
    {
        $this->page++;
        $this->fetchData();
    }

    public function previousPage()
    {
        $this->page--;
        $this->fetchData();
    }

    public function fetchData()
    {
        $this->totalData = User::count();
        $this->totalPages = $this->totalData / $this->perPages;

        $this->data = User::with('customers')
            ->skip($this->page * $this->perPages)
            ->take($this->perPages)
            ->get();
    }

    public function mount()
    {
        try {
            $this->fetchData();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.users-datatable');
    }
}
