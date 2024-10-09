<div class="bg-white rounded-lg shadow-card p-4 md:p-6">
    <div class="flex justify-between items-center">

        <!-- Título -->
        <p class="text-lg font-medium text-black">{{ __('Your latest orders') }}</p>

        <!-- Botão -->
        <x-dropdown align="right" width="72">
            <x-slot name="trigger">
                <button class="flex flex-between items-center bg-white border border-black rounded-lg text-black text-normal font-normal py-4 px-8 hover:bg-primary-100 active:bg-primary-200 active:outline-none">

                    <span class="max-w-xs truncate">
                        @if (in_array(false, $selectedCustomers))
                            @foreach (array_keys($this->selectedCustomers, true) as $customerId)
                                {{  $customers->where('idCliente', $customerId)->first()->nmCliente . (!$loop->last ? ', ' : '') }}
                            @endforeach
                        @else
                            {{ __('All registered branches') }}
                        @endif
                    </span>

                    <!-- Ícone -->
                    <svg class="size-4 fill-black ms-8" viewBox="0 0 20 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.25 9C11.25 8.30964 10.6904 7.75 10 7.75C9.30964 7.75 8.75 8.30964 8.75 9H11.25ZM9.11612 10.8839C9.60427 11.372 10.3957 11.372 10.8839 10.8839L18.8388 2.92893C19.327 2.44078 19.327 1.64932 18.8388 1.16117C18.3507 0.67301 17.5592 0.67301 17.0711 1.16117L10 8.23223L2.92893 1.16117C2.44078 0.67301 1.64932 0.67301 1.16117 1.16117C0.67301 1.64932 0.67301 2.44078 1.16117 2.92893L9.11612 10.8839ZM8.75 9V10H11.25V9H8.75Z" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                @foreach ($customers as $customer)
                    <button wire:click="toggleCustomer({{ $customer->idCliente }})" class="w-full text-start">
                        <x-dropdown-link class="flex items-center cursor-pointer {{ isset($selectedCustomers[$customer->idCliente]) && $selectedCustomers[$customer->idCliente] ? 'text-primary' : '' }} text-small font-medium">
                            <!-- Ícone de caixinha -->
                            @if (isset($selectedCustomers[$customer->idCliente]) && $selectedCustomers[$customer->idCliente])
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif
                            {{ $customer->nmCliente }}
                        </x-dropdown-link>
                    </button>
                @endforeach
            </x-slot>
        </x-dropdown>
    </div>
</div>
