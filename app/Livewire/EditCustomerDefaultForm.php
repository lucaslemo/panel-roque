<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class EditCustomerDefaultForm extends Component
{
    public int $userId = 0;
    public int $userDefaultId = 0;
    public int $currentPhase = 0;
    public array $customerIds = [];
    public array|Collection $customers = [];
    public string $name = '';
    public string $cpf = '';
    public string $email = '';
    public string $phone = '';

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation($attributes): mixed
    {
        $attributes['name'] = Str::apa($this->name);
        $attributes['cpf'] = preg_replace('/[\.-]/', '', $this->cpf);
        $attributes['phone'] = preg_replace('/[\s\(\)-]/', '', $this->phone);

        return $attributes;
    }

    #[On('open-modal-edit-customer-default-form')]
    public function prepareForm(int $id)
    {
        $this->resetExcept('userId');
        $this->resetValidation();

        try {
            $user = User::with('customers')->where('register_user_id', $this->userId)->findOrFail($id);

            $this->userDefaultId = $user->id;
            $this->name = $user->name;
            $this->cpf = formatCnpjCpf($user->cpf);
            $this->email = $user->email;
            $this->phone = formatPhone($user->phone);

            $this->customers = User::with('customers')->findOrFail($this->userId)->customers;

            foreach($this->customers as $customer) {

                // Guardar os ids dos clientes em um vetor para definir quem será selecionado
                $this->customerIds[$customer->idCliente] = false;
            }

            foreach($user->customers as $customer) {

                // Marca como selecionado os clientes que o usuário já possui
                $this->customerIds[$customer->idCliente] = true;
            }

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('close-modal', 'edit-customer-default-form');
            $this->dispatch('showAlert', __('Error fetching user data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Save a new user on database.
     */
    public function save()
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string',
                'cpf' => 'required|string|cpf|unique:users,cpf,' . $this->userDefaultId . ',id',
                'email' => 'required|string|email|unique:users,email,' . $this->userDefaultId . ',id',
                'phone' => 'required|string|digits_between:10,11',
            ]);

            DB::beginTransaction();
            $user = User::where('register_user_id', $this->userId)->findOrFail($this->userDefaultId);

            $user->fill($validated);

            $user->save();

            // A função array keys retorna as chaves de um array com valor true. Ex: [15 => true, 18 => false, 20 => true] -> [15, 20]
            $user->customers()->sync(array_keys($this->customerIds, true), true);
            DB::commit();

            $this->dispatch('refresh-user-default', $user->id)->to(UserRegistrationChat::class);
            $this->dispatch('close-modal', 'edit-customer-default-form');

        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->dispatch('showAlert', __('Error registering new user.'), __($th->getMessage()), 'danger');
            $this->cancel();
        }
    }

    /**
     * Choose the customers that is selected.
     */
    public function toggleCustomer(int $id)
    {
        if (array_key_exists($id, $this->customerIds)) {
            $this->customerIds[$id] = !$this->customerIds[$id];
        }
    }

    /**
     * Pass for the next page.
     */
    public function nextPage()
    {
        if ($this->currentPhase == 0) {
            $this->validate([
                'name' => 'required|string',
                'cpf' => 'required|string|cpf|unique:users,cpf,' . $this->userDefaultId . ',id',
                'email' => 'required|string|email|unique:users,email,' . $this->userDefaultId . ',id',
                'phone' => 'required|string|digits_between:10,11',
            ]);
        }

        $this->currentPhase++;
    }

    public function mount(int $userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        return view('livewire.edit-customer-default-form');
    }
}
