<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UsersDatatable extends Component
{
    public array|Collection $data = [];
    public array $perPageOptions = [10, 25, 50, 100];
    public int $totalData = 0;
    public int $perPage = 10;
    public int $totalPages = 0;
    public int $page = 0;
    public string|null $searchedValue = null;
    public array $filteredUserTypeValues = [];
    public array $filteredUserActiveValues = [];

    protected $listeners = ['searchUser' => 'search'];

    /**
     * Filter table for user type.
     */
    public function filterUserType(string $value)
    {
        if (in_array($value, $this->filteredUserTypeValues)) {
            $key = array_search($value, $this->filteredUserTypeValues);
            unset($this->filteredUserTypeValues[$key]);
        } else {
            $this->filteredUserTypeValues[] = $value;
        }
        $this->fetchData();
    }

    /**
     * Filter table for user active
     */
    public function filterUserActive(string $value)
    {
        if (in_array($value, $this->filteredUserActiveValues)) {
            $key = array_search($value, $this->filteredUserActiveValues);
            unset($this->filteredUserActiveValues[$key]);
        } else {
            $this->filteredUserActiveValues[] = $value;
        }
        $this->fetchData();
    }

    /**
     * Filter table for search filed.
     */
    public function search(string|null $value = null)
    {
        if ($value === '') {
            $this->searchedValue = null;
        } else {
            $this->searchedValue = $value;
        }
        $this->fetchData();
    }

    /**
     * Go to the specific page.
     */
    public function goToPage(int $page)
    {
        if ($page >= 0 && $page < $this->totalPages) {
            $this->page = $page;
            $this->fetchData();
        }
    }

    /**
     * Change the page size.
     */
    public function changePageSize(int $perPage)
    {
        if (in_array($perPage, $this->perPageOptions)) {
            $this->perPage = $perPage;
            $this->fetchData();
        }
    }

    /**
     * Go to the next page.
     */
    public function nextPage()
    {
        if ($this->page < $this->totalPages - 1) {
            $this->page++;
            $this->fetchData();
        }
    }

    /**
     * Go to the previous page.
     */
    public function previousPage()
    {
        if ($this->page > 0) {
            $this->page--;
            $this->fetchData();
        }
    }

    /**
     * Ative one user.
     */
    public function activateUser(int $id)
    {
        try {
            if(!optional(auth()->user())->hasRole('Super Admin')){
                throw new UnauthorizedException(403, 'User does not have the right roles.');
            }

            // Atualiza o status de atividade do usuário
            $user = User::findOrFail($id);

            // Usuários pendentes não pode ser ativados.
            if (is_null($user->last_login_at)) {
                return;
            }

            $user->active = true;
            $user->save();

            // Atualiza a tabela
            $this->fetchData();
            $this->dispatch('updateDataUsersCards')->to(UsersCards::class);
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', __('Error activating the user.'), __($e->getMessage()), 'danger');
        }
    }

    /**
     * Deactivate one user.
     */
    public function deactivateUser(int $id)
    {
        try {
            if(!optional(auth()->user())->hasRole('Super Admin')){
                throw new UnauthorizedException(403, 'User does not have the right roles.');
            }
            if (auth()->user()->id == $id) {
                throw new \Exception('For security reasons, you cannot deactivate your own account.');
            }

            // Atualiza o status de atividade do usuário
            $user = User::findOrFail($id);

            // Usuários pendentes não pode ser desativados.
            if (is_null($user->last_login_at)) {
                return;
            }

            $user->active = false;
            $user->save();

            // Atualiza a tabela
            $this->fetchData();
            $this->dispatch('updateDataUsersCards')->to(UsersCards::class);
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', __('Error deactivating the user.'), __($e->getMessage()), 'danger');
        }
    }

    /**
     * Get the data from table.
     */
    private function fetchData()
    {
        try {
            // Conta quantidade de elementos
            $this->totalData = User::whereNot('users.type', 1) // Exclui o tipo super admin
                ->when($this->searchedValue, function($query) {
                    $query->where(function($query) {
                        $query->orWhere('id', 'LIKE', '%' . $this->searchedValue . '%'); // Id do usuário
                        $query->orWhere('name', 'LIKE', '%' . $this->searchedValue . '%'); // Nome do usuário
                        $query->orWhere('email', 'LIKE', '%' . $this->searchedValue . '%'); // Email do usuário do usuário
                        $query->orWhere('cpf', 'LIKE', '%' . $this->searchedValue . '%'); // Cpf do usuário do usuário
                        $query->orWhereHas('customers', function($query) {
                            $query->where('nmCliente', 'LIKE', '%' . $this->searchedValue . '%'); // Alguma filial com o nome pesquisado
                        });
                    });
                })
                ->when(count($this->filteredUserTypeValues) > 0, function($query) {
                    $query->whereIn('users.type', $this->filteredUserTypeValues);
                })
                ->when(count($this->filteredUserActiveValues) > 0, function($query) {
                    $query->where(function($query) {
                        $query->when(in_array(1, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', true);
                        });
                        $query->when(in_array(2, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', false)->whereNull('last_login_at');
                        });
                        $query->when(in_array(3, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', false)->whereNotNull('last_login_at');
                        });
                    });
                })
                ->count();

            // Conta o total de páginas
            $this->totalPages = ceil($this->totalData / $this->perPage);

            // Verifica se a página inicial está fora do novo range
            while ($this->page > $this->totalPages - 1 && $this->totalPages > 0) {
                $this->page--;
            }

            // Busca os usuários
            $this->data = User::with('customers')
                ->when($this->searchedValue, function($query)  {
                    $query->where(function($query) {
                        $query->orWhere('id', 'LIKE', '%' . $this->searchedValue . '%'); // Id do usuário
                        $query->orWhere('name', 'LIKE', '%' . $this->searchedValue . '%'); // Nome do usuário
                        $query->orWhere('email', 'LIKE', '%' . $this->searchedValue . '%'); // Email do usuário do usuário
                        $query->orWhere('cpf', 'LIKE', '%' . $this->searchedValue . '%'); // Cpf do usuário do usuário
                        $query->orWhereHas('customers', function($query)  {
                            $query->where('nmCliente', 'LIKE', '%' .$this->searchedValue . '%'); // Alguma filial com o nome pesquisado
                        });
                    });
                })
                ->when(count($this->filteredUserTypeValues) > 0, function($query) {
                    $query->whereIn('users.type', $this->filteredUserTypeValues);
                })
                ->when(count($this->filteredUserActiveValues) > 0, function($query) {
                    $query->where(function($query) {
                        $query->when(in_array(1, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', true);
                        });
                        $query->when(in_array(2, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', false)->whereNull('last_login_at');
                        });
                        $query->when(in_array(3, $this->filteredUserActiveValues), function($query) {
                            $query->orWhere('active', false)->whereNotNull('last_login_at');
                        });
                    });
                })
                ->whereNot('users.type', 1) // Exclui o tipo super admin
                ->skip($this->page * $this->perPage)
                ->take($this->perPage)
                ->get();

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Update card details
     */
    #[On('updateDataUsersDatatable')]
    public function updateData()
    {
        $this->fetchData();
    }

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->fetchData();
    }

    /**
     * Placeholder when table is not loaded.
     */
    public function placeholder()
    {
        return view('components.spinner');
    }

    public function render()
    {
        return view('livewire.users-datatable');
    }
}
