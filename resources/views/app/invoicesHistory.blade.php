<x-app-layout>
    <!-- Modal -->
    <x-modal-panel title="" name="pre-order" width='large'>
        <div class="flex justify-end -mt-2 laptop:-mt-8 mb-4">
            <button class="bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                x-on:click="$dispatch('close-modal', 'pre-order')">

                <!-- Ícone de X -->
                <svg class="size-4 laptop:size-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.43884 0.418419C1.88095 -0.139473 0.976437 -0.139473 0.418549 0.418418C-0.139339 0.97631 -0.139339 1.88083 0.418549 2.43872L7.9797 9.99993L0.418416 17.5613C-0.139472 18.1192 -0.139472 19.0237 0.418416 19.5816C0.976304 20.1395 1.88082 20.1395 2.43871 19.5816L9.99999 12.0202L17.5613 19.5816C18.1192 20.1395 19.0237 20.1395 19.5816 19.5816C20.1395 19.0237 20.1395 18.1192 19.5816 17.5613L12.0203 9.99993L19.5814 2.43872C20.1393 1.88083 20.1393 0.976312 19.5814 0.41842C19.0236 -0.139471 18.119 -0.139471 17.5612 0.41842L10 7.97962L2.43884 0.418419Z" fill="#022266"/>
                </svg>
            </button>
        </div>
        <livewire:modal-orders-reserved />
    </x-modal-panel>

    <!-- Cartões -->
    <livewire:credit-limit-cards />

    <!-- Tabela -->
    <livewire:history-datatable lazy="on-load" />
</x-app-layout>
