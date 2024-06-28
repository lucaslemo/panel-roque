<div class="max-w-7xl mx-auto mb-7 sm:px-6 lg:px-8 space-y-4">
    <h2 class="font-semibold text-xl">{{ __('Credit Limits') }}:</h2>
    @foreach ($creditLimits as $creditLimit)
        <div wire:key="{{ $creditLimit->id }}">
            <h3 class="font-semibold text-lg">
                {{ $creditLimit->organization->name }}
            </h3>
            <div class="flex flex-row justify-between space-x-2">
                <x-card-credit-limit title="Limit">{{ 'R$ ' . number_format($creditLimit->limit, 2, ',', '.') }}</x-card-credit-limit>
                <x-card-credit-limit title="Used">{{ 'R$ ' . number_format($creditLimit->used, 2, ',', '.') }}</x-card-credit-limit>
                <x-card-credit-limit title="Reserved">{{ 'R$ ' . number_format($creditLimit->reserved, 2, ',', '.') }}</x-card-credit-limit>
                <x-card-credit-limit title="Available">{{ 'R$ ' . number_format($creditLimit->available, 2, ',', '.') }}</x-card-credit-limit>
            </div>
        </div>
    @endforeach
</div>
