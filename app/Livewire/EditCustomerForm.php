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

    #[On('open-modal-edit-customer-form')]
    public function prepareForm()
    {
        $this->resetExcept('userId');
        $this->resetValidation();

        try {
            $user = User::findOrFail($this->userId);

            $this->name = $user->name;
            $this->cpf = formatCnpjCpf($user->cpf);
            $this->email = $user->email;
            $this->phone = formatPhone($user->phone);

        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('close-modal', 'edit-customer-form');
            $this->dispatch('showAlert', __('Error fetching user data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Update the user on database.
     */
    public function save()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();
            $user = User::findOrFail($this->userId);

            $user->fill($validated);

            $updated = $user->isDirty();

            $user->save();
            DB::commit();

            if ($updated) {
                $this->dispatch('refresh-user')->to(UserRegistrationChat::class);
            }

            $this->dispatch('close-modal', 'edit-customer-form');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->dispatch('showAlert', __('Error updating user.'), __($th->getMessage()), 'danger');
        }
    }

    public function mount(int $userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        return view('livewire.edit-customer-form');
    }
}
