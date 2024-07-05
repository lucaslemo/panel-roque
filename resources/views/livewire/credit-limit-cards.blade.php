<div class="max-w-7xl mx-auto mb-7 sm:px-6 lg:px-8 space-y-4">
    <h2 class="font-semibold text-xl">{{ __('Credit Limits') }}:</h2>
    @foreach ($creditLimits as $key => $creditLimit)
        <div wire:key="{{ $creditLimit->id ?? $key }}">
            <h3 class="font-semibold text-lg">
                {{ optional($creditLimit)->customer->nmCliente ?? __('Customer not found') }}
            </h3>
            <div class="flex flex-row justify-between space-x-2">
                <x-card title="{{ __('Limit') }} ">{{ 'R$ ' . number_format(optional($creditLimit)->vrLimite, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Used') }} ">{{ 'R$ ' . number_format(optional($creditLimit)->vrUtilizado, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Reserved') }}">{{ 'R$ ' . number_format(optional($creditLimit)->vrReservado, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Available') }}">{{ 'R$ ' . number_format(optional($creditLimit)->vrDisponivel, 2, ',', '.') }}</x-card>
            </div>
        </div>
    @endforeach
</div>
