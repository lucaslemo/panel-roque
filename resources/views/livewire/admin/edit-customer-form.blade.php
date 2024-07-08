<?php

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public int $id = 0;
    public string $name = '';
    public string $type = '';

    /**
     * Mount the component.
     */
    public function mount($id): void
    {
        try {
            $customer = Customer::findOrFail($id);
            $this->id = $customer->idCliente;
            $this->name = $customer->nmCliente;
            $this->type = $customer->tpCliente;
        } catch (\Throwable $th) {
            $this->dispatch('showAlert', __('Error fetching customer data.'), $th->getMessage(), 'danger');
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateCustomer(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['Pessoa Física', 'Pessoa Jurídica'])],
        ]);

        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($this->id);

            $customer->nmCliente = $validated['name'];
            $customer->tpCliente = $validated['type'];

            $customer->save();

            DB::commit();

            $this->dispatch('user-updated', name: $customer->nmCliente);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('showAlert', __('Error updating customer.'), $th->getMessage(), 'danger');
        }
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Updating') }}: <span class="font-bold">{{ $name }}</span>
        </h2>
    </header>

    <form wire:submit="updateCustomer" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="type" :value="__('Type')" />
            <select wire:model="type" name="type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option value="Pessoa Física">{{ __('Individual') }}</option>
                <option value="Pessoa Jurídica">{{ __('Corporation') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3 font-semibold text-green-500" on="user-updated">
                {{ __('Updated successfully!') }}
            </x-action-message>
        </div>
    </form>
</section>
