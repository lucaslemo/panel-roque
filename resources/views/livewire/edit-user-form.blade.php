<div>
    <!-- Breadcrumb -->
    <x-breadcrumb-modal class="justify-between mb-4 md:mb-8">
        <x-slot name="content">
            <x-breadcrumb-modal-item :active="$currentPhase >= 0 ? true : false" :tail="true" :end="false" class="grow">
                {{ __('Personal data') }}
            </x-breadcrumb-modal-item>
            <x-breadcrumb-modal-item :active="$currentPhase >= 1 ? true : false" :tail="true" :end="true" class="grow">
                {{ __('Permissions') }}
            </x-breadcrumb-modal-item>
        </x-slot>
    </x-breadcrumb-modal>

    @if ($currentPhase === 0)
        <p class="font-medium text-small md:text-normal text-label-color mb-4 md:mb-8 laptop:mb-12">
            {{ __('Make sure you enter the correct information. To edit, simply click on the text box. After filling in the information, simply click on the “next step” button to select which companies this user will be able to view.') }}
        </p>
    @elseif ($currentPhase === 1)
        <p class="font-medium text-small md:text-normal text-label-color mb-6 md:mb-8 laptop:mb-12">
            {{ __('To add permissions to the user, simply click on the branch box. After selecting all the permissions you want, simply click on the “Save data” button so that the user receives a link for registration and future access.') }}
        </p>
    @endif

    <!-- Formulário -->
    @if ($currentPhase === 0)
    <div class="grid grid-cols-1 laptop:grid-cols-2 gap-x-0 md:gap-x-6 laptop:gap-x-6 2xl:gap-x-12 gap-y-4 mb-6 md:mb-8 laptop:mb-12">
        <div class="group-label-input">
            <x-input-label for="name_edit" :value="__('Username')" />
            <x-text-input wire:model="name" id="name_edit" class="block w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="group-label-input">
            <x-input-label for="cpf_edit" :value="__('CPF')" />
            <x-text-input wire:model="cpf" id="cpf_edit" class="block w-full" type="text" name="cpf" x-mask="999.999.999-99" required autocomplete="cpf" />
            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
        </div>
        <div class="group-label-input">
            <x-input-label for="email_edit" :value="__('Email')" />
            <x-text-input wire:model="email" id="email_edit" class="block w-full" type="email" name="email" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="group-label-input">
            <x-input-label for="phone_edit" :value="__('Phone')" />
            <x-text-input wire:model="phone" id="phone_edit" class="block w-full" type="text" name="phone" x-mask:dynamic="$input.replace(/\D/g, '').length > 10 ? '(99) 99999-9999' : '(99) 9999-9999'" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
    </div>
    @elseif ($currentPhase === 1)
        @if (count($customers) > 0)
        <div class="grid grid-cols-1 laptop:grid-cols-2 gap-y-4 md:gap-y-8 mb-6 md:mb-8 laptop:mb-12">
            @foreach ($customers as $customer)
                <x-card-button
                    wire:click="toggleCustomer({{ $customer->idCliente }})"
                    :active="$customerIds[$customer->idCliente]"
                    :customer="$customer->nmCliente"
                    :code="formatCnpjCpf($customer->codCliente)" />
            @endforeach
        </div>

        @else
            <p class="font-medium text-small md:text-normal text-black mb-12">
                {{ __('There are no companies registered for this user yet. Check if the email is correct or if it has already been entered in the Query.') }}
            </p>
        @endif
    @endif

    <!-- Botões de ação -->
    <div class="flex justify-between md:justify-end space-x-3 md:space-x-4 laptop:space-x-6">
        <div class="w-32 md:w-40">
            <x-secondary-button wire:click="cancel" type="button" class="text-base font-semibold">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
        @if ($currentPhase === 0)
            <div class="w-40">
                <x-secondary-button wire:click="nextPage" type="button" class="text-base font-semibold">
                    {{ __('Next Step') }}
                </x-secondary-button>
            </div>
        @elseif ($currentPhase === 1)
            <div class="w-40">
                <x-secondary-button wire:click="save" type="button" class="text-base font-semibold">
                    {{ __('Save Data') }}
                </x-secondary-button>
            </div>
        @endif
    </div>
</div>
