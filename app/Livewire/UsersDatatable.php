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

    public function goToPage(int $page)
    {
        if ($page >= 0 && $page < $this->totalPages) {
            $this->page = $page;
            $this->fetchData();
        }
    }

    public function nextPage()
    {
        if ($this->page < $this->totalPages - 1) {
            $this->page++;
            $this->fetchData();
        }
    }

    public function previousPage()
    {
        if ($this->page > 0) {
            $this->page--;
            $this->fetchData();
        }
    }

    private function fetchData()
    {
        $this->totalData = User::whereNot('type', 1)->count(); // Exclui o tipo super admin
        $this->totalPages = ceil($this->totalData / $this->perPages);

        $this->data = User::with('customers')
            ->whereNot('type', 1) // Exclui o tipo super admin
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
