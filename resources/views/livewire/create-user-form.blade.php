<div>
    <!-- Breadcrumb do modal -->
    <x-breadcrumb-modal class="justify-between mb-8">
        <x-slot name="content">
            <x-breadcrumb-modal-item :active="$currentPhase >= 0 ? true : false" :tail="true" class="grow">
                {{ __('Personal data') }}
            </x-breadcrumb-modal-item>
            <x-breadcrumb-modal-item :active="$currentPhase >= 1 ? true : false" :tail="true" class="grow">
                {{ __('Company(s) details') }}
            </x-breadcrumb-modal-item>
            <x-breadcrumb-modal-item :active="$currentPhase >= 2 ? true : false" :tail="false">
                {{ __('Permissions') }}
            </x-breadcrumb-modal-item>

        </x-slot>
    </x-breadcrumb-modal>
    <p class="font-medium text-normal text-label-color">{{ __('Make sure you enter the correct information. To edit, simply click on the text box. After filling in the information, simply click on the “next step” button to select which companies this user will be able to view.') }}</p>

    <!-- Botões de ação -->
    <div class="mt-6 flex justify-end space-x-6">
        <div class="w-40">
            <x-secondary-button wire:click="cancel" type="button" class="text-base font-semibold">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
        <div class="w-40">
            <x-secondary-button wire:click="nextPage" type="button" class="text-base font-semibold">
                {{ __('Next Step') }}
            </x-secondary-button>
        </div>
    </div>
</div>
