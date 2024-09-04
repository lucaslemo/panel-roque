<div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full">
    <x-card title="{{ __('Users online') }}">{{ $usersOnline }}</x-card>
    <x-card title="{{ __('Users active') }}">{{ $usersActive }}</x-card>
    <x-card title="{{ __('Users total') }}" class="hidden md:block">{{ $usersTotal }}</x-card>
    <x-card title="{{ __('Total Users in the System') }}" class="block col-span-2 md:hidden">{{ $usersTotal }}</x-card>
</div>
