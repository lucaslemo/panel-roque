<div class="grid grid-cols-2 laptop:grid-cols-4 gap-y-4 gap-x-4 laptop:gap-x-8 w-full">
    <x-card-money title="{{ __('Limit') }} ">{{ 'R$ ' . number_format($limit, 2, ',', '.') }}</x-card-money>
    <x-card-money title="{{ __('Used') }} ">{{ 'R$ ' . number_format($used, 2, ',', '.') }}</x-card-money>
    <x-card-money title="{{ __('Reserved') }}">{{ 'R$ ' . number_format($reserved, 2, ',', '.') }}</x-card-money>
    <x-card-money title="{{ __('Available') }}">{{ 'R$ ' . number_format($available, 2, ',', '.') }}</x-card-money>
</div>
