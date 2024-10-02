<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditCustomerForm extends Component
{
    public int $userId = 0;

    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string|digits_between:10,11')]
    public string $phone = '';

    public string $cpf = '';
    public string $email = '';

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation($attributes): mixed
    {
        $attributes['phone'] = preg_replace('/[\s\(\)-]/', '', $this->phone);

        return $attributes;
    }

    /**
     * Clear fields.
     */
    #[On('clearEditCustomerForm')]
    public function clearForm()
    {
        $this->userId = 0;
        $this->reset();
        $this->resetValidation();
    }

    /**
     * Fill form data.
     */
    #[On('fillFormEditCustomerForm')]
    public function fillFormData(int $id)
    {
        try {
            $user = User::findOrFail($id);

            $this->userId = $id;
            $this->name = $user->name;
            $this->cpf = formatCnpjCpf($user->cpf);
            $this->email = $user->email;
            $this->phone = formatPhone($user->phone);

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('closeEditCustomerModal')->to(EditCustomerModal::class);
            $this->dispatch('showAlert', __('Error fetching user data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Save a new user on database.
     */
    public function save()
    {
        try {
            $validated = $this->validate();

            DB::beginTransaction();
            $user = User::findOrFail($this->userId);

            $user->fill($validated);

            $shouldUpdate = $user->isDirty();

            $user->save();
            DB::commit();

            $this->dispatch('refreshUserUserRegistrationChat')->to(UserRegistrationChat::class);
            $this->dispatch('closeEditCustomerModal')->to(EditCustomerModal::class);

            if ($shouldUpdate) {
                $this->dispatch('showAlert', __('Completed'), __('The user has been updated successfully.'), 'success');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->dispatch('showAlert', __('Error registering new user.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Close the modal.
     */
    public function cancel()
    {
        $this->dispatch('closeEditCustomerModal')->to(EditCustomerModal::class);
    }

    public function render()
    {
        return view('livewire.edit-customer-form');
    }
}
