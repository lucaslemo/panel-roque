<x-admin-layout>
    <div class="py-12">

        <!-- Cards -->
        <section class="flex justify-between">
            <livewire:users-cards />
            <div class="flex flex-col justify-between w-80 ms-4">

                <!-- Botão novo usuário -->
                <x-secondary-button type="button" class="w-full font-medium">
                    <svg class="fill-current size-4 me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C12.5523 4 13 4.44772 13 5V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V5C11 4.44772 11.4477 4 12 4Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12Z" />
                    </svg>
                    {{ __('Register new user') }}
                </x-secondary-button>

                <!-- Busca de usuários -->
                <livewire:input-search />
            </div>
        </section>

        {{--  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h2 class="font-semibold text-xl">{{ __('Active users') }}:</h2>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:admin.dashboard.users-last-activity-table />
            </div>
        </div> --}}
    </div>
</x-admin-layout>
