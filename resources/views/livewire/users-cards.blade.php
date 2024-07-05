<div class="max-w-7xl mx-auto mb-7 sm:px-6 lg:px-8 space-y-4">
    <h2 class="font-semibold text-xl">{{ __('Users details') }}:</h2>
    <div class="flex flex-row justify-between space-x-2">
        <x-card title="{{ __('Users online') }}">{{ $usersOnline }}</x-card>
        <x-card title="{{ __('Users active') }}">{{ $usersActive }}</x-card>
    </div>
</div>
