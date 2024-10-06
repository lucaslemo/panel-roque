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

    /**
     * Clear fields.
     */
    #[On('clearCreateCustomerForm')]
    public function clearForm()
    {
        $this->userId = 0;
        $this->currentPhase = 0;
        $this->customerIds = [];
        $this->customers = [];
        $this->reset();
        $this->resetValidation();
    }

    /**
     * Search customers data from given user.
     */
    #[On('fetchCustomersCreateCustomerForm')]
    public function fetchCustomers(int $id)
    {
        try {
            $this->userId = $id;

            // Busca os clientes associados ao E-mail do usuário
            $this->customers = User::with('customers')->findOrFail($id)->customers;
            foreach($this->customers as $customer) {

                // Guardar os ids dos clientes em um vetor para definir quem será selecionado
                $this->customerIds[$customer->idCliente] = false;
            }

        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', __('Error loading company data.'), __($e->getMessage()), 'danger');
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

            $this->dispatch('newUserUserRegistrationChat', $user)->to(UserRegistrationChat::class);
            $this->dispatch('closeCreateCustomerModal')->to(CreateCustomerModal::class);

            $user->notify(new UserCreated($user));

            // $this->dispatch('showAlert', __('Completed'), __('A new user has been registered. He will soon receive a registration link.'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            $this->dispatch('showAlert', __('Error registering new user.'), __($e->getMessage()), 'danger');
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
     * Close the model.
     */
    public function cancel()
    {
        $this->dispatch('closeCreateCustomerModal')->to(CreateCustomerModal::class);
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

    public function render()
    {
        return view('livewire.create-customer-form');
    }
}
