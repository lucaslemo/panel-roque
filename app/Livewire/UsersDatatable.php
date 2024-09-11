<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UsersDatatable extends Component
{
    public $data = [];
    public $perPageOptions = [10, 25, 50, 100];
    public $totalData = 0;
    public $perPage = 10;
    public $totalPages = 0;
    public $page = 0;

    protected $listeners = ['searchUser' => 'search'];

    public function search($value)
    {
        $this->fetchData($value);
    }

    public function goToPage(int $page)
    {
        if ($page >= 0 && $page < $this->totalPages) {
            $this->page = $page;
            $this->fetchData();
        }
    }

    public function changePageSize($perPage)
    {
        if (in_array($perPage, $this->perPageOptions)) {
            $this->perPage = $perPage;
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

    private function fetchData($searchUser = null)
    {
        try {
            // Conta quantidade de elementos
            $this->totalData = User::whereNot('type', 1) // Exclui o tipo super admin
                ->when($searchUser, function($query) use($searchUser) {
                    $query->where(function($query) use($searchUser) {
                        $query->orWhere('name', 'LIKE', '%' . $searchUser . '%'); // Nome do usuário
                        $query->orWhere('email', 'LIKE', '%' . $searchUser . '%'); // Email do usuário do usuário
                        $query->orWhere('cpf', 'LIKE', '%' . $searchUser . '%'); // Cpf do usuário do usuário
                        $query->orWhereHas('customers', function($query) use($searchUser) {
                            $query->where('nmCliente', 'LIKE', '%' . $searchUser . '%'); // Alguma filial com o nome pesquisado
                        });
                    });
                })
                ->count();

            // Conta o total de páginas
            $this->totalPages = ceil($this->totalData / $this->perPage);

            // Verifica se a página inicial está fora do novo range
            while ($this->page > $this->totalPages - 1) {
                $this->page--;
            }

            // Busca os usuários
            $this->data = User::with('customers')
                ->when($searchUser, function($query) use($searchUser) {
                    $query->where(function($query) use($searchUser) {
                        $query->orWhere('name', 'LIKE', '%' . $searchUser . '%'); // Nome do usuário
                        $query->orWhere('email', 'LIKE', '%' . $searchUser . '%'); // Email do usuário do usuário
                        $query->orWhere('cpf', 'LIKE', '%' . $searchUser . '%'); // Cpf do usuário do usuário
                        $query->orWhereHas('customers', function($query) use($searchUser) {
                            $query->where('nmCliente', 'LIKE', '%' . $searchUser . '%'); // Alguma filial com o nome pesquisado
                        });
                    });
                })
                ->whereNot('type', 1) // Exclui o tipo super admin
                ->skip($this->page * $this->perPage)
                ->take($this->perPage)
                ->get();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), $th->getMessage(), 'danger');
        }
    }

    public function mount()
    {
        $this->fetchData();
    }

    public function placeholder()
    {
        return view('components.spinner');
    }

    public function render()
    {
        return view('livewire.users-datatable');
    }
}
