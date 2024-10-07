<div class="max-w-7xl mx-auto mb-7 sm:px-6 lg:px-8 space-y-4">
    @foreach ($creditLimits as $key => $creditLimit)
        <div wire:key="{{ $creditLimit->id ?? $key }}">
            <div class="flex flex-col space-x-0 space-y-2 lg:flex-row lg:justify-between lg:space-x-2 lg:space-y-0">
                <x-card title="{{ __('Limit') }} ">{{ 'R$ ' . number_format(optional($creditLimit)->vrLimite, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Used') }} ">{{ 'R$ ' . number_format(optional($creditLimit)->vrUtilizado, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Reserved') }}">{{ 'R$ ' . number_format(optional($creditLimit)->vrReservado, 2, ',', '.') }}</x-card>
                <x-card title="{{ __('Available') }}">{{ 'R$ ' . number_format(optional($creditLimit)->vrDisponivel, 2, ',', '.') }}</x-card>
            </div>
        </div>
    @endforeach
</div>
