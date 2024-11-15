<div>
    <div class="relative hidden laptop:block overflow-x-auto bg-white shadow-card rounded-lg p-4">

        <!-- Loading Overlay -->
        <div wire:loading.flex class="absolute inset-0 flex items-center justify-center bg-trasparent z-100">
            <p class="bg-white rounded-lg shadow-hight-card font-medium text-h5 text-black px-12 py-6">{{ __('Loading...') }}</p>
        </div>

        <table class="table-auto min-w-full">
            <!-- Header da tabela -->
            <thead>
                <tr>
                    <th class="table-head text-center">#</th>
                    <th class="table-head text-center">{{ __('Username') }}</th>
                    <th class="table-head text-center">{{ __('Email') }}</th>
                    <th class="table-head text-center">{{ __('CPF') }}</th>
                    <th class="table-head text-center">{{ __('Trading name') }}</th>
                    <th class="table-head">
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger">
                                <button class="flex flex-row justify-between {{ count($filteredUserTypeValues) === 0 ? 'text-subtitle-color' : 'text-primary' }} w-full p-2">
                                    {{ __('Type') }}

                                    <!-- Ícone de filtro -->
                                    <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link class="flex items-center cursor-pointer {{ in_array(2, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(2)">

                                    <!-- Ícone de caixinha -->
                                    @if (in_array(2, $filteredUserTypeValues))
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                        </svg>
                                    @else
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                        </svg>
                                    @endif

                                    {{ __('Customer administrator') }}

                                </x-dropdown-link>
                                <x-dropdown-link class="flex items-center cursor-pointer {{ in_array(3, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(3)">

                                    <!-- Ícone de caixinha -->
                                    @if (in_array(3, $filteredUserTypeValues))
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                        </svg>
                                    @else
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                        </svg>
                                    @endif

                                    {{ __('Customer default') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </th>
                    <th class="table-head">
                        <x-dropdown align="right" width="40">
                            <x-slot name="trigger">
                                <button class="flex flex-row justify-between {{ count($filteredUserActiveValues) === 0 ? 'text-subtitle-color' : 'text-primary' }} w-full p-2">
                                    {{ __('Status') }}

                                    <!-- Ícone de filtro -->
                                    <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link class="flex items-center cursor-pointer {{ in_array(1, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(1)">

                                    <!-- Ícone de caixinha -->
                                    @if (in_array(1, $filteredUserActiveValues))
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                        </svg>
                                    @else
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                        </svg>
                                    @endif

                                    <div class="green-circle"></div>
                                    <span class="leading-none">{{ __('Active') }}</span>
                                </x-dropdown-link>
                                <x-dropdown-link class="flex items-center cursor-pointer {{ in_array(2, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(2)">

                                    <!-- Ícone de caixinha -->
                                    @if (in_array(2, $filteredUserActiveValues))
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                        </svg>
                                    @else
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                        </svg>
                                    @endif

                                    <div class="yellow-circle"></div>
                                    <span class="leading-none">{{ __('Pending') }}</span>
                                </x-dropdown-link>
                                <x-dropdown-link class="flex items-center cursor-pointer {{ in_array(3, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(3)">

                                    <!-- Ícone de caixinha -->
                                    @if (in_array(3, $filteredUserActiveValues))
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                        </svg>
                                    @else
                                        <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                        </svg>
                                    @endif

                                    <div class="stone-circle"></div>
                                    <span class="leading-none">{{ __('Inactive') }}</span>
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </th>
                    <th class="px-6 py-3 border-b border-t">&nbsp;</th>
                </tr>
            </thead>

            <!-- Body da tabela -->
            <tbody>
                @foreach ($data as $key => $item)
                    <tr class="{{ $key % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="table-body text-center border-b border-e text-small 2xl:text-normal">{{ $item->id }}</td>
                        <td class="table-body border-b border-e text-small 2xl:text-normal ">{{ $item->name }}</td>
                        <td class="table-body border-b border-e text-small">{{ $item->email }}</td>
                        <td class="table-body border-b border-e text-small">{{ formatCnpjCpf($item->cpf) }}</td>
                        <td class="table-body border-b border-e text-small">
                            @if (count($item->customers) === 0)
                                {{ __('Does not have') }}

                            @elseif (count($item->customers) === 1)
                                {{ $item->customers[0]->nmCliente }}

                            @else
                                @foreach ($item->customers as $key => $customer)
                                    <div>
                                        {{ ($key + 1) . '. ' . $customer->nmCliente }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td class="table-body border-b border-e text-small">{{ $item->getTypeName() }}</td>
                        <td class="table-body border-b border-e text-small">
                            <div class="flex justify-start items-center">
                                @if ((bool) $item->active === true)
                                    <!-- Status Ativo -->
                                    <div class="green-circle"></div>
                                    <span class="leading-none">{{ __('Active') }}</span>

                                @elseif ((bool) $item->active === false && is_null($item->last_login_at))
                                    <!-- Status Pendente -->
                                    <div class="yellow-circle"></div>
                                    <span class="leading-none">{{ __('Pending') }}</span>

                                @else
                                    <!-- Status inativo -->
                                    <div class="stone-circle"></div>
                                    <span class="leading-none">{{ __('Inactive') }}</span>

                                @endif
                            </div>
                        </td>

                        <!-- Botões de ação -->
                        <td class="table-body border-b text-small">
                            <div class="flex flex-row itens-center">
                                <button wire:click="$dispatch('openEditUserModal', { id: {{ $item->id }} })" type="button" class="flex justify-center items-center size-10 2xl:size-[48px] shadow-button border rounded-lg border-border-color focus:outline-none me-2">
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 20C11 19.4477 11.4477 19 12 19H21C21.5523 19 22 19.4477 22 20C22 20.5523 21.5523 21 21 21H12C11.4477 21 11 20.5523 11 20Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 3.87866C17.7026 3.87866 17.4174 3.9968 17.2071 4.20709L4.90296 16.5112L4.37437 18.6256L6.48875 18.097L18.7929 5.79288C18.897 5.68875 18.9796 5.56514 19.036 5.42909C19.0923 5.29305 19.1213 5.14724 19.1213 4.99998C19.1213 4.85273 19.0923 4.70692 19.036 4.57087C18.9796 4.43483 18.897 4.31121 18.7929 4.20709C18.6888 4.10296 18.5652 4.02037 18.4291 3.96402C18.2931 3.90767 18.1473 3.87866 18 3.87866ZM15.7929 2.79288C16.3783 2.20751 17.1722 1.87866 18 1.87866C18.4099 1.87866 18.8158 1.9594 19.1945 2.11626C19.5732 2.27312 19.9173 2.50303 20.2071 2.79288C20.4969 3.08272 20.7269 3.42681 20.8837 3.8055C21.0406 4.1842 21.1213 4.59008 21.1213 4.99998C21.1213 5.40988 21.0406 5.81576 20.8837 6.19446C20.7269 6.57316 20.4969 6.91725 20.2071 7.20709L7.7071 19.7071C7.57895 19.8352 7.41837 19.9262 7.24253 19.9701L3.24253 20.9701C2.90176 21.0553 2.54127 20.9555 2.29289 20.7071C2.04451 20.4587 1.94466 20.0982 2.02986 19.7574L3.02986 15.7574C3.07381 15.5816 3.16473 15.421 3.29289 15.2929L15.7929 2.79288Z" />
                                    </svg>
                                </button>
                                @if ($item->active)
                                    <button wire:click="deactivateUser({{ $item->id }})" type="button" class="flex justify-center items-center size-10 2xl:size-[48px] shadow-button border rounded-lg border-border-color focus:outline-none">
                                        <svg class="size-5 fill-black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2929 7.29289C17.6834 6.90237 18.3166 6.90237 18.7071 7.29289L23.7071 12.2929C24.0976 12.6834 24.0976 13.3166 23.7071 13.7071C23.3166 14.0976 22.6834 14.0976 22.2929 13.7071L17.2929 8.70711C16.9024 8.31658 16.9024 7.68342 17.2929 7.29289Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 7.29289C24.0976 7.68342 24.0976 8.31658 23.7071 8.70711L18.7071 13.7071C18.3166 14.0976 17.6834 14.0976 17.2929 13.7071C16.9024 13.3166 16.9024 12.6834 17.2929 12.2929L22.2929 7.29289C22.6834 6.90237 23.3166 6.90237 23.7071 7.29289Z" />
                                        </svg>
                                    </button>
                                @else
                                    @if (is_null($item->last_login_at))
                                        <button type="button" class="flex justify-center items-center size-10 2xl:size-[48px] border rounded-lg bg-disabled border-disabled" disabled>
                                            <svg class="size-5 fill-black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 8.29289C24.0976 8.68342 24.0976 9.31658 23.7071 9.70711L19.7071 13.7071C19.3166 14.0976 18.6834 14.0976 18.2929 13.7071L16.2929 11.7071C15.9024 11.3166 15.9024 10.6834 16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929L19 11.5858L22.2929 8.29289C22.6834 7.90237 23.3166 7.90237 23.7071 8.29289Z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button wire:click="activateUser({{ $item->id }})" type="button" class="flex justify-center items-center size-10 2xl:size-[48px] shadow-button border rounded-lg border-border-color focus:outline-none">
                                            <svg class="size-5 fill-black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 8.29289C24.0976 8.68342 24.0976 9.31658 23.7071 9.70711L19.7071 13.7071C19.3166 14.0976 18.6834 14.0976 18.2929 13.7071L16.2929 11.7071C15.9024 11.3166 15.9024 10.6834 16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929L19 11.5858L22.2929 8.29289C22.6834 7.90237 23.3166 7.90237 23.7071 8.29289Z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if (count($data) === 0)
                    <tr>
                        <td colspan="8">
                            <div class="flex justify-center font-medium text-h5 text-black pb-12 pt-24">
                                {{ __('No items found') }}.
                            </div>
                        </td>
                    </tr>
                @endif
            <tbody>
        </table>

        <!-- Botões de paginação e quantidade de itens por página -->
        <div class="flex flex-row justify-end mt-4">
            <!-- Quantidade de itens por página -->
            <div class="flex flex-row space-x-2">
                <button wire:click="previousPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === 0 ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289Z" />
                    </svg>
                </button>

                @for ($i = 0, $dots = true; $i < $totalPages; $i++)
                    @if (($i === 0 || $i === (int) ($totalPages - 1)) || (((int) $page < 4 && $i < 4) || ((int) $page > (int) ($totalPages - 6) && $i > (int) ($totalPages - 6))) || ((int) $page - 2 < $i && $i < (int) $page + 2))
                        <button wire:click="goToPage({{ $i }})" type="button" class="table-page-button {{ $i === $page ? 'border-primary text-primary' : 'border-subtitle-color text-subtitle-color' }}">
                            {{ $i + 1 }}
                        </button>
                        @php
                            $dots = true;
                        @endphp
                    @else
                        @if ($dots)
                            <button type="button" class="table-page-button border-subtitle-color text-subtitle-color" disabled>
                                . . .
                            </button>
                            @php
                                $dots = false;
                            @endphp
                        @endif
                    @endif
                @endfor

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0  ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 5.29289C8.68342 4.90237 9.31658 4.90237 9.70711 5.29289L15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L13.5858 12L8.29289 6.70711C7.90237 6.31658 7.90237 5.68342 8.29289 5.29289Z" />
                    </svg>
                </button>
            </div>

            <!-- Quantidade de itens por página -->
            <div class="flex items-center ms-8">
                <x-dropdown align="top" width="24">
                    <x-slot name="trigger">
                        <button class="h-10 w-36 inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-normal rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                            {{ $perPage }}
                            <!-- Ícone -->
                            <svg class="fill-current size-2" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($perPageOptions as $value)
                            <x-dropdown-link class="text-small font-medium" wire:click="changePageSize({{ $value }})">
                                {{ $value }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>

                <span class="font-normal text-normal text-black ms-2">/ {{ __('pages') }}</span>
            </div>
        </div>
    </div>

    <!-- Parte Mobile -->
    <div x-data="{ bottomFilterVisible: false }" class="block laptop:hidden">
        <div
            x-intersect:enter="bottomFilterVisible = false"
            x-intersect:leave="bottomFilterVisible = true"
            class="flex flex-col md:flex-row gap-4 justify-center bg-white shadow-card rounded-lg p-4 mb-4">

            <!-- Botões de paginação -->
            <div class="flex flex-row itens-center justify-center space-x-2 sm:space-x-3">
                <button wire:click="previousPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === 0 ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289Z" />
                    </svg>
                </button>

                @for ($i = 0; $i < $totalPages; $i++)
                    @if (((int) $page === 0 && $i < 4) || ((int) $page + 3 > $i && $i > (int) $page - 2) || ((int) $page === ((int) $totalPages - 2) && (int) $page + 2 > $i && $i > (int) $page - 3) || ((int) $page === ((int) $totalPages - 1) && $i > ((int) $totalPages - 5)))
                        <button wire:click="goToPage({{ $i }})" type="button" class="table-page-button {{ $i === $page ? 'border-primary text-primary' : 'border-subtitle-color text-subtitle-color' }}">
                            {{ $i + 1 }}
                        </button>
                    @endif
                @endfor

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0 ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 5.29289C8.68342 4.90237 9.31658 4.90237 9.70711 5.29289L15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L13.5858 12L8.29289 6.70711C7.90237 6.31658 7.90237 5.68342 8.29289 5.29289Z" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-row items-center mx-auto mt-4 md:mt-0 md:mx-0">
                <!-- Quantidade de itens por página -->
                <x-dropdown :align="count($data) === 0 ? 'top' : 'right'" width="24" :full="true">
                    <x-slot name="trigger">
                        <button class="h-10 w-24 inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-normal rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                            {{ $perPage }}
                            <!-- Ícone seta para baixo -->
                            <svg class="fill-current size-2" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($perPageOptions as $value)
                            <x-dropdown-link class="text-small font-medium" wire:click="changePageSize({{ $value }})">
                                {{ $value }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
                <span class="font-normal text-normal text-black text-nowrap mx-2">/ {{ __('pages') }}</span>
                <!-- Filtros -->
                <x-dropdown :align="count($data) === 0 ? 'top-right' : 'right'" width="56" :full="true">
                    <x-slot name="trigger">
                        <button class="h-10 w-24 sm:w-28 inline-flex items-center justify-center px-3 py-2 bg-white border border-border-color text-black rounded-md leading-4 {{ count($filteredUserTypeValues) === 0 && count($filteredUserActiveValues) === 0 ? 'text-black' : 'text-primary' }}">
                            <!-- Ícone de filtro -->
                            <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <p class="text-small font-normal p-4">{{ __('User type')}}</p>

                        <x-dropdown-link class="flex items-center {{ in_array(2, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(2)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(2, $filteredUserTypeValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            {{ __('Customer administrator') }}
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(3, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(3)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(3, $filteredUserTypeValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            {{ __('Customer default') }}
                        </x-dropdown-link>
                        <hr>

                        <p class="text-small font-normal p-4">{{ __('User status')}}</p>

                        <x-dropdown-link class="flex items-center {{ in_array(1, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(1)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(1, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            <div class="green-circle"></div>
                            <span class="leading-none">{{ __('Active') }}</span>
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(2, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(2)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(2, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif
                            <div class="yellow-circle"></div>
                            <span class="leading-none">{{ __('Pending') }}</span>
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(3, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(3)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(3, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif
                            <div class="stone-circle"></div>
                            <span class="leading-none">{{ __('Inactive') }}</span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <!-- Lista dos usuários -->
        @foreach ($data as $key => $item)
            <div class="bg-white shadow-card rounded-lg p-4 mb-4">
                <div class="flex justify-between items-center">
                    <h5 class="font-medium text-normal">#{{ $item->id }}</h5>
                    <div class="flex justify-center items-center text-small">
                        @if ((bool) $item->active === true)
                            <!-- Status Ativo -->
                            <div class="green-circle"></div>
                            {{ __('Active') }}

                        @elseif ((bool) $item->active === false && is_null($item->last_login_at))
                            <!-- Status Pendente -->
                            <div class="yellow-circle"></div>
                            {{ __('Pending') }}

                        @else
                            <!-- Status inativo -->
                            <div class="stone-circle"></div>
                            {{ __('Inactive') }}

                        @endif
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <div><span class="text-black font-medium text-small">{{ __('Username') }}:</span> <span class="text-black font-light text-small">{{ $item->name }}</span></div>
                        <div><span class="text-black font-medium text-small">{{ __('Email') }}:</span> <span class="text-black font-light text-small">{{ $item->email }}</span></div>
                        <div><span class="text-black font-medium text-small">{{ __('CPF') }}:</span> <span class="text-black font-light text-small">{{ formatCnpjCpf($item->cpf) }}</span></div>
                        <div>
                            <div class="text-black font-medium text-small">{{ __('Trading name') }}:</div>
                            <div class="text-black font-light text-small ms-2">
                                @if (count($item->customers) === 0)
                                        {{ __('Does not have') }}
                                    @endif
                                    @foreach ($item->customers as $key => $customer)
                                        <div>
                                            {{ ($key + 1) . '. ' . $customer->nmCliente }}
                                        </div>
                                @endforeach
                            </div>
                        </div>
                        <div><span class="text-black font-medium text-small">{{ __('Type') }}:</span> <span class="text-black font-light text-small">{{ $item->getTypeName() }}</span></div>
                    </div>

                    <!-- Botões de ação -->
                    <div class="flex flex-col itens-center">
                        <button wire:click="$dispatch('openEditUserModal', { id: {{ $item->id }} })" type="button" class="flex justify-center items-center size-12 shadow-button border rounded-lg border-border-color focus:outline-none my-2">
                            <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 20C11 19.4477 11.4477 19 12 19H21C21.5523 19 22 19.4477 22 20C22 20.5523 21.5523 21 21 21H12C11.4477 21 11 20.5523 11 20Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 3.87866C17.7026 3.87866 17.4174 3.9968 17.2071 4.20709L4.90296 16.5112L4.37437 18.6256L6.48875 18.097L18.7929 5.79288C18.897 5.68875 18.9796 5.56514 19.036 5.42909C19.0923 5.29305 19.1213 5.14724 19.1213 4.99998C19.1213 4.85273 19.0923 4.70692 19.036 4.57087C18.9796 4.43483 18.897 4.31121 18.7929 4.20709C18.6888 4.10296 18.5652 4.02037 18.4291 3.96402C18.2931 3.90767 18.1473 3.87866 18 3.87866ZM15.7929 2.79288C16.3783 2.20751 17.1722 1.87866 18 1.87866C18.4099 1.87866 18.8158 1.9594 19.1945 2.11626C19.5732 2.27312 19.9173 2.50303 20.2071 2.79288C20.4969 3.08272 20.7269 3.42681 20.8837 3.8055C21.0406 4.1842 21.1213 4.59008 21.1213 4.99998C21.1213 5.40988 21.0406 5.81576 20.8837 6.19446C20.7269 6.57316 20.4969 6.91725 20.2071 7.20709L7.7071 19.7071C7.57895 19.8352 7.41837 19.9262 7.24253 19.9701L3.24253 20.9701C2.90176 21.0553 2.54127 20.9555 2.29289 20.7071C2.04451 20.4587 1.94466 20.0982 2.02986 19.7574L3.02986 15.7574C3.07381 15.5816 3.16473 15.421 3.29289 15.2929L15.7929 2.79288Z" />
                            </svg>
                        </button>

                        @if ($item->active)
                            <button wire:click="deactivateUser({{ $item->id }})" type="button" class="flex justify-center items-center size-12 shadow-button border rounded-lg border-border-color focus:outline-none">
                                <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2929 7.29289C17.6834 6.90237 18.3166 6.90237 18.7071 7.29289L23.7071 12.2929C24.0976 12.6834 24.0976 13.3166 23.7071 13.7071C23.3166 14.0976 22.6834 14.0976 22.2929 13.7071L17.2929 8.70711C16.9024 8.31658 16.9024 7.68342 17.2929 7.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 7.29289C24.0976 7.68342 24.0976 8.31658 23.7071 8.70711L18.7071 13.7071C18.3166 14.0976 17.6834 14.0976 17.2929 13.7071C16.9024 13.3166 16.9024 12.6834 17.2929 12.2929L22.2929 7.29289C22.6834 6.90237 23.3166 6.90237 23.7071 7.29289Z" />
                                </svg>
                            </button>
                        @else
                            @if (is_null($item->last_login_at))
                                <button type="button" class="flex justify-center items-center size-12 border rounded-lg bg-disabled border-disabled" disabled>
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 8.29289C24.0976 8.68342 24.0976 9.31658 23.7071 9.70711L19.7071 13.7071C19.3166 14.0976 18.6834 14.0976 18.2929 13.7071L16.2929 11.7071C15.9024 11.3166 15.9024 10.6834 16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929L19 11.5858L22.2929 8.29289C22.6834 7.90237 23.3166 7.90237 23.7071 8.29289Z" />
                                    </svg>
                                </button>
                            @else
                                <button wire:click="activateUser({{ $item->id }})" type="button" class="flex justify-center items-center size-12 shadow-button border rounded-lg border-border-color focus:outline-none">
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.46447 15.4645C2.40215 14.5268 3.67392 14 5 14H12C13.3261 14 14.5979 14.5268 15.5355 15.4645C16.4732 16.4021 17 17.6739 17 19V21C17 21.5523 16.5523 22 16 22C15.4477 22 15 21.5523 15 21V19C15 18.2044 14.6839 17.4413 14.1213 16.8787C13.5587 16.3161 12.7956 16 12 16H5C4.20435 16 3.44129 16.3161 2.87868 16.8787C2.31607 17.4413 2 18.2044 2 19V21C2 21.5523 1.55228 22 1 22C0.447715 22 0 21.5523 0 21V19C0 17.6739 0.526784 16.4021 1.46447 15.4645Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 4C6.84315 4 5.5 5.34315 5.5 7C5.5 8.65685 6.84315 10 8.5 10C10.1569 10 11.5 8.65685 11.5 7C11.5 5.34315 10.1569 4 8.5 4ZM3.5 7C3.5 4.23858 5.73858 2 8.5 2C11.2614 2 13.5 4.23858 13.5 7C13.5 9.76142 11.2614 12 8.5 12C5.73858 12 3.5 9.76142 3.5 7Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.7071 8.29289C24.0976 8.68342 24.0976 9.31658 23.7071 9.70711L19.7071 13.7071C19.3166 14.0976 18.6834 14.0976 18.2929 13.7071L16.2929 11.7071C15.9024 11.3166 15.9024 10.6834 16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929L19 11.5858L22.2929 8.29289C22.6834 7.90237 23.3166 7.90237 23.7071 8.29289Z" />
                                    </svg>
                                </button>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

        @if (count($data) == 0)
            <div class="flex justify-center font-medium text-h5 text-black pt-8">
                {{ __('No items found') }}.
            </div>
        @endif

        <div x-show="bottomFilterVisible" class="flex flex-col md:flex-row gap-4 justify-center bg-white shadow-card rounded-lg p-4 mb-4">
            <!-- Botões de paginação -->
            <div class="flex flex-row itens-center justify-center space-x-2 sm:space-x-3">
                <button wire:click="previousPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === 0 ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289Z" />
                    </svg>
                </button>

                @for ($i = 0; $i < $totalPages; $i++)
                    @if (((int) $page === 0 && $i < 4) || ((int) $page + 3 > $i && $i > (int) $page - 2) || ((int) $page === ((int) $totalPages - 2) && (int) $page + 2 > $i && $i > (int) $page - 3) || ((int) $page === ((int) $totalPages - 1) && $i > ((int) $totalPages - 5)))
                        <button wire:click="goToPage({{ $i }})" type="button" class="table-page-button {{ $i === $page ? 'border-primary text-primary' : 'border-subtitle-color text-subtitle-color' }}">
                            {{ $i + 1 }}
                        </button>
                    @endif
                @endfor

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border text-subtitle-color rounded-lg {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0 ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === ((int) $totalPages - 1) || (int) $totalPages === 0 ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 5.29289C8.68342 4.90237 9.31658 4.90237 9.70711 5.29289L15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L13.5858 12L8.29289 6.70711C7.90237 6.31658 7.90237 5.68342 8.29289 5.29289Z" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-row items-center mx-auto mt-4 md:mt-0 md:mx-0">
                <!-- Quantidade de itens por página -->
                <x-dropdown align="top" width="24" :full="true">
                    <x-slot name="trigger">
                        <button class="h-10 w-24 inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-normal rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                            {{ $perPage }}
                            <!-- Ícone seta para baixo -->
                            <svg class="fill-current size-2" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($perPageOptions as $value)
                            <x-dropdown-link class="text-small font-medium" wire:click="changePageSize({{ $value }})">
                                {{ $value }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
                <span class="font-normal text-normal text-black text-nowrap mx-2">/ {{ __('pages') }}</span>
                <!-- Filtros -->
                <x-dropdown align="top-right" width="48" :full="true">
                    <x-slot name="trigger">
                        <button class="h-10 w-24 sm:w-28 inline-flex items-center justify-center px-3 py-2 bg-white border border-border-color text-black rounded-md leading-4 {{ count($filteredUserTypeValues) === 0 && count($filteredUserActiveValues) === 0 ? 'text-black' : 'text-primary' }}">
                            <!-- Ícone de filtro -->
                            <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <p class="text-small font-normal p-4">{{ __('User type')}}</p>

                        <x-dropdown-link class="flex items-center {{ in_array(2, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(2)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(2, $filteredUserTypeValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            {{ __('Customer administrator') }}
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(3, $filteredUserTypeValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserType(3)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(3, $filteredUserTypeValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            {{ __('Customer default') }}
                        </x-dropdown-link>
                        <hr>

                        <p class="text-small font-normal p-4">{{ __('User status')}}</p>

                        <x-dropdown-link class="flex items-center {{ in_array(1, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(1)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(1, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif

                            <div class="green-circle"></div>
                            <span class="leading-none">{{ __('Active') }}</span>
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(2, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(2)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(2, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif
                            <div class="yellow-circle"></div>
                            <span class="leading-none">{{ __('Pending') }}</span>
                        </x-dropdown-link>
                        <x-dropdown-link class="flex items-center {{ in_array(3, $filteredUserActiveValues) ? 'text-primary' : '' }} text-small font-medium" wire:click="filterUserActive(3)">

                            <!-- Ícone de caixinha -->
                            @if (in_array(3, $filteredUserActiveValues))
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                </svg>
                            @else
                                <svg class="size-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.44772 4 4 4.44772 4 5V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V5C20 4.44772 19.5523 4 19 4H5ZM2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5Z" />
                                </svg>
                            @endif
                            <div class="stone-circle"></div>
                            <span class="leading-none">{{ __('Inactive') }}</span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</div>

