<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CreateUserForm extends Component
{
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
    #[On('clearCreateUserForm')]
    public function clearForm()
    {
        $this->currentPhase = 0;
        $this->customerIds = [];
        $this->customers = [];
        $this->reset();
        $this->resetValidation();
    }

    /**
     * Search customers data from given email.
     */
    private function fetchCustomers()
    {
        try {
            // Busca os clientes associados ao E-mail do usuário
            $this->customers = Customer::where('emailCliente', $this->email)->get();
            foreach($this->customers as $customer) {

                // Guardar os ids dos clientes em um vetor para definir quem será selecionado
                $this->customerIds[$customer->idCliente] = true;
            }

        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', __('Error loading company data.'), __($e->getMessage()), 'danger');
        }
    }

    /**
     * Save a new user on database.
     */
    public function save()
    {
        try {
            if (! optional(auth()->user())->isAdmin()) {
                throw new UnauthorizedException('403', __("Oops! You don't have the required authorization."));
            }

            $validated = $this->validate();

            $validated['name'] = Str::apa($validated['name']);
            $validated['password'] = Hash::make(Str::password());
            $validated['register_token'] = Str::uuid();
            $validated['register_user_id'] = auth()->id();

            DB::beginTransaction();
            $user = new User;
            $user->fill($validated);
            $user->save();

            $user->assignRole('Customer Admin');

            // A função array keys retorna as chaves de um array com valor true. Ex: [15 => true, 18 => false, 20 => true] -> [15, 20]
            $user->customers()->attach(array_keys($this->customerIds, true));
            DB::commit();

            $this->dispatch('closeCreateUserModal')->to(CreateUserModal::class);
            $this->dispatch('updateDataUsersCards')->to(UsersCards::class);
            $this->dispatch('updateDataUsersDatatable')->to(UsersDatatable::class);

            $user->refresh();

            $user->notify(new NewUserNotification($user));

            $this->dispatch('showAlert', __('Completed'), __('A new user has been registered. He will soon receive a registration link.'), 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            $this->dispatch('showAlert', __('Error registering new user.'), __($e->getMessage()), 'danger');
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
     * Close the model.
     */
    public function cancel()
    {
        $this->dispatch('closeCreateUserModal')->to(CreateUserModal::class);
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
        $this->fetchCustomers();
    }

    public function render()
    {
        return view('livewire.create-user-form');
    }
}
