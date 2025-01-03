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

<header x-data="{ open: false }" class="flex justify-between items-center px-[30px] xl:px-[70px] pt-8 pb-6 bg-white laptop:bg-transparent">

    <x-modal-panel title="{{ __('Edit user') }}" name="edit-profile">
        <livewire:edit-profile />
    </x-modal-panel>

    <!-- Ícone da Aplicação -->
    <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="w-auto h-8 laptop:h-12" alt="Logo da Roque">

    <!-- Menu do usuário -->
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="h-[46px] laptop:h-[52px] laptop:min-w-[231px] inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-small rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">

                <div class="flex flex-row items-center">
                    <!-- Avatar do usuário -->
                    <img src="{{ asset('build/assets/imgs/user.svg') }}" class="size-6 rounded-md" alt="Avatar do usuário">

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

            @if (app()->isLocal() || auth()->user()->email === 'lucaslemodev@gmail.com')
                <x-dropdown-link :href="url('/horizon')">
                    {{ __('Horizon') }}
                </x-dropdown-link>
            @endif

            <!-- Authentication -->
            <button wire:click="logout" class="w-full text-start">
                <x-dropdown-link>
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </button>
        </x-slot>
    </x-dropdown>
</header>
