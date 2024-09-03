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
                <div class="relative flex items-center justify-center">
                    <x-text-input id="search" type="text" class="w-full text-center text-subtitle-color border-subtitle-color font-light ps-8"
                        placeholder="{{ __('Search user') }}" />

                    <div class="absolute inset-y-0 left-0 flex items-center ps-12 pointer-events-none">
                        <svg class="fill-current size-4 me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 4C7.13401 4 4 7.13401 4 11C4 14.866 7.13401 18 11 18C14.866 18 18 14.866 18 11C18 7.13401 14.866 4 11 4ZM2 11C2 6.02944 6.02944 2 11 2C15.9706 2 20 6.02944 20 11C20 15.9706 15.9706 20 11 20C6.02944 20 2 15.9706 2 11Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9429 15.9428C16.3334 15.5523 16.9666 15.5523 17.3571 15.9428L21.7071 20.2928C22.0976 20.6833 22.0976 21.3165 21.7071 21.707C21.3166 22.0975 20.6834 22.0975 20.2929 21.707L15.9429 17.357C15.5524 16.9665 15.5524 16.3333 15.9429 15.9428Z" />
                        </svg>
                    </div>
                </div>
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
