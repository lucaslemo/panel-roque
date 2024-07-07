<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public string $type = '';
    public bool $active = false;

    /**
     * Mount the component.
     */
    public function mount($id): void
    {
        try {
            $user = User::findOrFail($id);
            $this->id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->type = $user->type;
            $this->active = $user->active;
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', __('Error fetching user data.'), $th->getMessage(), 'danger');
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateUser(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->id)],
            'type' => ['required', Rule::in(['administrator', 'customer'])],
            'active' => ['required', 'boolean'],
        ]);

        try {
            DB::beginTransaction();
            $user = User::findOrFail($this->id);

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            if ($user->isDirty('type')) {
                $user->roles()->detach();

                if ($validated['type'] === 'administrator') {
                    $user->assignRole('Super Admin');
                } else {
                    $user->assignRole('Customer');
                }
            }

            $user->save();

            DB::commit();

            $this->dispatch('user-updated', name: $user->name);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('showAlert', __('Error updating user.'), $th->getMessage(), 'danger');
        }
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Updating') }}: <span class="font-bold">{{ $name }}</span>
        </h2>
    </header>

    <form wire:submit="updateUser" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="type" :value="__('Type')" />
            <select wire:model="type" name="type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option value="administrator">{{ __('Administrator') }}</option>
                <option value="customer">{{ __('Customer') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
        </div>

        <div>
            <label class="inline-flex items-center me-5 cursor-pointer">
                <input wire:model.live="active" id="active" name="active" type="checkbox" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $active ? __("Activated") : __("Disabled") }}</span>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('active')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3 font-semibold text-green-500" on="user-updated">
                {{ __('Updated successfully!') }}
            </x-action-message>
        </div>
    </form>
</section>
