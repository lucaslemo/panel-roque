<div class="grid grid-cols-2 laptop:grid-cols-3 gap-y-4 gap-x-4 laptop:gap-x-8 w-full">
    <x-card title="{{ __('Users online') }}">{{ $usersOnline }}</x-card>
    <x-card title="{{ __('Users active') }}">{{ $usersActive }}</x-card>
    <x-card title="{{ __('Users total') }}" class="hidden laptop:block">{{ $usersTotal }}</x-card>
    <x-card title="{{ __('Total Users in the System') }}" class="block laptop:hidden col-span-2">{{ $usersTotal }}</x-card>
</div>
