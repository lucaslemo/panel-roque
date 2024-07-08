<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:admin.edit-customer-form :id="$id" />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-6">{{ __('Add users to the customer') }}</h2>
                <livewire:add-user-to-customer :id="$id" />
                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                <h2 class="text-lg font-medium text-gray-900 mb-6">{{ __('Users associated with the customer') }}</h2>
                <livewire:admin.customers.users-for-customer-table :id="$id" />
            </div>
        </div>
    </div>
</x-app-layout>
