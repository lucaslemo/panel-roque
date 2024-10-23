<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class EditProfile extends Component
{
    public string $name = '';
    public string $cpf = '';
    public string $email = '';
    public string $phone = '';

    public string $readOnlyCpf = '';
    public string $readOnlyEmail = '';

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

    public function save()
    {
        $validated = [];
        if (optional(auth()->user())->isAdmin()) {
            $validated = $this->validate([
                'name' => 'required|string',
                'cpf' => 'required|string|cpf|unique:users,cpf,' . auth()->id() . ',id',
                'email' => 'required|string|email|unique:users,email,' . auth()->id() . ',id',
                'phone' => 'required|string|digits_between:10,11',
            ]);
        } else  {
            $validated = $this->validate([
                'name' => 'required|string',
                'phone' => 'required|string|digits_between:10,11',
            ]);
        }

        try {
            DB::beginTransaction();
            $user = User::findOrFail(auth()->user()->id);

            $user->fill($validated);

            $user->save();

            DB::commit();

            $this->dispatch('profile-updated', name: $user->name);
            $this->dispatch('close-modal', 'edit-profile');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->dispatch('showAlert', __('Error updating user.'), __($th->getMessage()), 'danger');
        }
    }

    #[On('open-modal-edit-profile')]
    public function prepareForm()
    {
        $this->reset();
        $this->resetValidation();

        try {
            $user = User::findOrFail(auth()->user()->id);

            $this->name = $user->name;
            $this->cpf = formatCnpjCpf($user->cpf);
            $this->email = $user->email;
            $this->phone = formatPhone($user->phone);

            $this->readOnlyCpf = formatCnpjCpf($user->cpf);
            $this->readOnlyEmail = formatPhone($user->phone);

            $this->dispatch('open-modal', 'edit-profile');
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('close-modal', 'edit-profile');
            $this->dispatch('showAlert', __('Error fetching user data.'), __($th->getMessage()), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
