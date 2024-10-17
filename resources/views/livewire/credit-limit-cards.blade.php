<div class="grid grid-cols-2 laptop:grid-cols-4 gap-y-4 gap-x-4 laptop:gap-x-8 w-full">
    <!-- Card limite -->
    <x-card-money title="{{ __('Limit') }} ">{{ 'R$ ' . number_format($limit, 2, ',', '.') }}</x-card-money>

    <!-- Card pré venda -->
    <x-card-money class="cursor-pointer hover:bg-primary-100 active:bg-primary-200" title="{{ __('Pre Sale') }}"
        x-on:click="$dispatch('open-modal-reserved', { value: {{ $reserved }} })">

        {{ 'R$ ' . number_format($reserved, 2, ',', '.') }}
    </x-card-money>

    <!-- Card utilizado -->
    <x-card-money title="{{ __('Used') }} ">{{ 'R$ ' . number_format($used, 2, ',', '.') }}</x-card-money>

    <!-- Card disponível -->
    <x-card-money title="{{ __('Available') }}">{{ 'R$ ' . number_format($available, 2, ',', '.') }}</x-card-money>
</div>
