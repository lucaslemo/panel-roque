<div>
    <p class="font-medium text-small md:text-normal text-label-color mb-4 md:mb-8 laptop:mb-12">
        {{ __('Check the data below. Make sure it is correct. To correct it, simply click on the information to be corrected. If the data is correct, simply click on the "Confirm Data" button.') }}
    </p>

    <form wire:submit="save">
        <!-- Formulário -->
        <div class="grid grid-cols-1 laptop:grid-cols-2 gap-x-0 md:gap-x-6 laptop:gap-x-6 2xl:gap-x-12 gap-y-4 mb-6 md:mb-8 laptop:mb-12">
            <div class="group-label-input">
                <x-input-label for="name_edit" :value="__('Username')" />
                <x-text-input wire:model="name" id="name_edit" class="block w-full" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="cpf_edit" :value="__('CPF')" />
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <x-text-input id="cpf_edit" class="block w-full" type="text" value="{{ $cpf }}" :disabled="true"/>
                    <button @click="open = ! open" type="button" class="absolute inset-y-0 right-3 focus:outline-none">
                        <svg class="fill-border-color hover:fill-primary size-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3ZM1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12.5523 7 13 7.44772 13 8V12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12V8C11 7.44772 11.4477 7 12 7Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 16C11 15.4477 11.4477 15 12 15H12.01C12.5623 15 13.01 15.4477 13.01 16C13.01 16.5523 12.5623 17 12.01 17H12C11.4477 17 11 16.5523 11 16Z" />
                        </svg>
                    </button>
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 mt-2 w-60 rounded-lg shadow-button bottom-full ltr:origin-top-right rtl:origin-top-left end-0 mb-2"
                        style="display: none;"
                        @click="open = false">

                        <div class="rounded-lg ring-1 ring-black ring-opacity-5 p-4 bg-white border border-primary font-medium text-small text-primary">
                            {{ __('CPF cannot be changed here. If you wish to change it, contact your sales consultant.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <x-input-label for="email_edit" :value="__('Email')" />
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <x-text-input id="email_edit" class="block w-full" type="email" value="{{ $email }}" :disabled="true"/>
                    <button @click="open = ! open" type="button" class="absolute inset-y-0 right-3 focus:outline-none">
                        <svg class="fill-border-color hover:fill-primary size-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3ZM1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C12.5523 7 13 7.44772 13 8V12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12V8C11 7.44772 11.4477 7 12 7Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 16C11 15.4477 11.4477 15 12 15H12.01C12.5623 15 13.01 15.4477 13.01 16C13.01 16.5523 12.5623 17 12.01 17H12C11.4477 17 11 16.5523 11 16Z" />
                        </svg>
                    </button>
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 mt-2 w-60 rounded-lg shadow-button bottom-full ltr:origin-top-right rtl:origin-top-left end-0 mb-2"
                        style="display: none;"
                        @click="open = false">

                        <div class="rounded-lg ring-1 ring-black ring-opacity-5 p-4 bg-white border border-primary font-medium text-small text-primary">
                            {{ __('E-mail cannot be changed here. If you want to change it, contact your sales consultant.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="group-label-input">
                <x-input-label for="phone_edit" :value="__('Phone')" />
                <x-text-input wire:model="phone" id="phone_edit" class="block w-full" type="text" name="phone" x-mask:dynamic="$input.replace(/\D/g, '').length > 10 ? '(99) 99999-9999' : '(99) 9999-9999'" required autocomplete="phone" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="flex justify-between md:justify-end space-x-3 md:space-x-4 laptop:space-x-6">
            <div class="w-24 md:w-40">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-customer-form')" type="button" class="text-base font-semibold">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
            <div class="w-40">
                <x-secondary-button type="submit" class="text-base font-semibold text-nowrap">
                    <span wire:loading wire:target="save" class="loading"></span>
                    <span wire:loading.remove wire:target="save">{{ __('Confirm Data') }}</span>
                </x-secondary-button>
            </div>
        </div>
    </form>
</div>
