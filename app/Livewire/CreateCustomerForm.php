<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\UserCreated;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCustomerForm extends Component
{
    public int $userId = 0;
    public int $currentPhase = 0;
    public array $customerIds = [];
    public array|Collection $customers = [];

    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string|cpf|unique:users,cpf')]
    public string $cpf = '';

    #[Validate('required|string|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|digits_between:10,11')]
    public string $phone = '';

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation($attributes): mixed
    {
        $attributes['cpf'] = preg_replace('/[\.-]/', '', $this->cpf);
        $attributes['phone'] = preg_replace('/[\s\(\)-]/', '', $this->phone);

        return $attributes;
    }

    #[On('open-modal-create-customer-form')]
    public function prepareForm()
    {
        $this->resetExcept('userId');
        $this->resetValidation();

        try {
            // Busca os clientes associados ao usuário
            $this->customers = User::with('customers')->findOrFail($this->userId)->customers;
            foreach($this->customers as $customer) {

                // Guardar os ids dos clientes em um vetor para definir quem será selecionado
                $this->customerIds[$customer->idCliente] = false;
            }

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('close-modal', 'create-customer-form');
            $this->dispatch('showAlert', __('Error fetching user data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Save a new user on database. openCreateCustomerModal
     */
    public function save()
    {
        $validated = $this->validate();

        try {
            $validated['name'] = Str::apa($validated['name']);
            $validated['password'] = Hash::make(Str::password());
            $validated['type'] = 3;
            $validated['register_token'] = Str::uuid();
            $validated['register_user_id'] = $this->userId;

            DB::beginTransaction();
            $user = new User;
            $user->fill($validated);
            $user->save();

            $user->assignRole('Customer Default');

            // A função array keys retorna as chaves de um array com valor true. Ex: [15 => true, 18 => false, 20 => true] -> [15, 20]
            $user->customers()->attach(array_keys($this->customerIds, true));
            DB::commit();

            $user->refresh();

            $this->dispatch('new-user', $user)->to(UserRegistrationChat::class);
            $this->dispatch('close-modal', 'create-customer-form');
            $user->notify(new UserCreated($user));

        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->dispatch('showAlert', __('Error registering new user.'), __($th->getMessage()), 'danger');
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
            $this->validate();
        }

        $this->currentPhase++;
    }

    /**
     * Close the model.
     */
    #[On('cancel-create-customer-form')]
    public function cancel()
    {
        $this->currentPhase = 0;
        $this->resetExcept('userId');
        $this->resetValidation();
    }

    public function mount(int $userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        return view('livewire.create-customer-form');
    }
}
