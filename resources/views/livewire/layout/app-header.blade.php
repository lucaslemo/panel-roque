<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/login', navigate: true);
    }
}; ?>

<header x-data="{ open: false }" class="bg-white">

    <!-- Modal para editar o perfil -->
    <x-modal-panel title="{{ __('Edit user') }}" name="edit-profile">
        <livewire:edit-profile />
    </x-modal-panel>

    @can('Can register a new user customer default')
        <!-- Modal para criar um usuário -->
        <x-modal-panel :title="__('Register new user')" name="create-customer-form">
            <livewire:create-customer-form :userId="auth()->user()->id" />
        </x-modal-panel>
    @endcan

    <div class="px-[30px] xl:px-[70px] pt-8 pb-6">
        <div class="flex justify-between items-center">
            <!-- Ícone da Aplicação -->
            <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="w-auto h-8 laptop:h-12" alt="Logo da Roque">

            <!-- Menu -->
            <nav class="space-x-2 hidden laptop:block">
                <x-nav-app-link :href="route('app.dashboard')" :active="request()->routeIs('app.dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-nav-app-link>

                <x-nav-app-link :href="route('app.invoices')" :active="request()->routeIs('app.invoices')" wire:navigate>
                    {{ __('Financial') }}
                </x-nav-app-link>

                <x-nav-app-link :href="route('app.orders')" :active="request()->routeIs('app.orders')" wire:navigate>
                    {{ __('Requests') }}
                </x-nav-app-link>

                <x-nav-app-link :href="route('app.invoicesHistory')" :active="request()->routeIs('app.invoicesHistory')" wire:navigate>
                    {{ __('History') }}
                </x-nav-app-link>
            </nav>

            <!-- Menu do usuário -->
            <div class="hidden laptop:block">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="h-[46px] laptop:h-[52px] laptop:min-w-[231px] inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-small rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">

                            <div class="flex flex-row items-center">
                                <!-- Nome do usuário -->
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name" class="hidden laptop:block ms-2"></div>
                            </div>

                            <!-- Ícone -->
                            <svg class="fill-current ms-4" width="15" height="8" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link class="cursor-pointer" x-on:click="$dispatch('open-modal-edit-profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @can('Can register a new user customer default')
                            <x-dropdown-link class="cursor-pointer" x-on:click="$dispatch('open-modal-create-customer-form') || $dispatch('open-modal', 'create-customer-form')">
                                {{ __('New user') }}
                            </x-dropdown-link>
                        @endcan

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center block laptop:hidden">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Hamburger -->
                        <button class="inline-flex items-center justify-center p-2 rounded-md text-primary focus:outline-none active:bg-primary-100 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :active="request()->routeIs('app.dashboard')" class="text-small font-medium" :href="route('app.dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </x-dropdown-link>
                        <x-dropdown-link :active="request()->routeIs('app.invoices')" class="text-small font-medium" :href="route('app.invoices')" wire:navigate>
                            {{ __('Financial') }}
                        </x-dropdown-link>
                        <x-dropdown-link :active="request()->routeIs('app.orders')" class="text-small font-medium" :href="route('app.orders')" wire:navigate>
                            {{ __('Requests') }}
                        </x-dropdown-link>
                        <x-dropdown-link :active="request()->routeIs('app.invoicesHistory')" class="text-small font-medium" :href="route('app.invoicesHistory')" wire:navigate>
                            {{ __('History') }}
                        </x-dropdown-link>

                        <x-dropdown-link class="cursor-pointer" x-on:click="$dispatch('open-modal-edit-profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="text-small font-medium">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>
