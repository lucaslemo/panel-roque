<div class="grid grid-cols-3 gap-8 w-full">
    <x-card title="{{ __('Users online') }}">{{ $usersOnline }}</x-card>
    <x-card title="{{ __('Users active') }}">{{ $usersActive }}</x-card>
    <x-card title="{{ __('Users total') }}">{{ $usersTotal }}</x-card>
</div>
