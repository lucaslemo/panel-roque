<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <livewire:credit-limit-cards />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h2 class="font-semibold text-xl">{{ __('Bills Due') }}:</h2>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:app.dashboard.invoices-table />
            </div>
        </div>
    </div>
</x-app-layout>