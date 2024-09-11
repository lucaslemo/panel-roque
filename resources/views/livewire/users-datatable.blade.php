<div>
    <div class="relative hidden laptop:block overflow-x-auto bg-white shadow-card rounded-lg p-4">

        <!-- Loading Overlay -->
        <div wire:loading.flex class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center text-white">
            <p class="bg-white rounded-lg shadow-card font-medium text-h5 text-black px-12 py-6">{{ __('Loading...') }}</p>
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
                        <div class="flex justify-between">
                            {{ __('Type') }}
                            <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                            </svg>
                        </div>
                    </th>
                    <th class="table-head">
                        <div class="flex justify-between">
                            {{ __('Status') }}
                            <svg class="fill-current size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0929 2.57912C1.25675 2.22596 1.61069 2 2.00001 2H22C22.3893 2 22.7433 2.22596 22.9071 2.57912C23.071 2.93229 23.015 3.34845 22.7636 3.64573L15 12.8261V21C15 21.3466 14.8206 21.6684 14.5257 21.8507C14.2309 22.0329 13.8628 22.0494 13.5528 21.8944L9.5528 19.8944C9.21402 19.725 9.00001 19.3788 9.00001 19V12.8261L1.23644 3.64573C0.985046 3.34845 0.929037 2.93229 1.0929 2.57912ZM4.15532 4L10.7636 11.8143C10.9162 11.9948 11 12.2236 11 12.46V18.382L13 19.382V12.46C13 12.2236 13.0838 11.9948 13.2364 11.8143L19.8447 4H4.15532Z" />
                            </svg>
                        </div>
                    </th>
                    <th class="px-6 py-3 border-b">&nbsp;</th>
                </tr>
            </thead>

            <!-- Body da tabela -->
            <tbody>
                @foreach ($data as $key => $item)
                    <tr class="{{ $key % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="table-body text-center border-t border-e text-small 2xl:text-normal">{{ $item->id }}</td>
                        <td class="table-body border-t border-e text-small 2xl:text-normal ">{{ $item->name }}</td>
                        <td class="table-body border-t border-e text-small">{{ $item->email }}</td>
                        <td class="table-body border-t border-e text-small">{{ formatCnpjCpf($item->cpf) }}</td>
                        <td class="table-body border-t border-e text-small">
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
                        <td class="table-body border-t border-e text-small">{{ $item->getTypeName() }}</td>
                        <td class="table-body border-t border-e text-small">
                            <div class="flex justify-start items-center">
                                @if ((bool) $item->active === true)
                                    <!-- Status Ativo -->
                                    <div class="green-circle"></div>
                                    <span>{{ __('Active') }}</span>
                                @elseif ((bool) $item->active === false && is_null($item->last_login_at))
                                    <!-- Status Pendente -->
                                    <div class="yellow-circle"></div>
                                    <span>{{ __('Pending') }}</span>
                                @else
                                    <!-- Status inativo -->
                                    <div class="stone-circle"></div>
                                    <span>{{ __('Inactive') }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Botões de ação -->
                        <td class="table-body border-t text-small">
                            <div class="flex flex-row itens-center">
                                <button type="button" class="flex justify-center items-center size-10 2xl:size-[48px] shadow-button border rounded-lg border-border-color me-2">
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 20C11 19.4477 11.4477 19 12 19H21C21.5523 19 22 19.4477 22 20C22 20.5523 21.5523 21 21 21H12C11.4477 21 11 20.5523 11 20Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 3.87866C17.7026 3.87866 17.4174 3.9968 17.2071 4.20709L4.90296 16.5112L4.37437 18.6256L6.48875 18.097L18.7929 5.79288C18.897 5.68875 18.9796 5.56514 19.036 5.42909C19.0923 5.29305 19.1213 5.14724 19.1213 4.99998C19.1213 4.85273 19.0923 4.70692 19.036 4.57087C18.9796 4.43483 18.897 4.31121 18.7929 4.20709C18.6888 4.10296 18.5652 4.02037 18.4291 3.96402C18.2931 3.90767 18.1473 3.87866 18 3.87866ZM15.7929 2.79288C16.3783 2.20751 17.1722 1.87866 18 1.87866C18.4099 1.87866 18.8158 1.9594 19.1945 2.11626C19.5732 2.27312 19.9173 2.50303 20.2071 2.79288C20.4969 3.08272 20.7269 3.42681 20.8837 3.8055C21.0406 4.1842 21.1213 4.59008 21.1213 4.99998C21.1213 5.40988 21.0406 5.81576 20.8837 6.19446C20.7269 6.57316 20.4969 6.91725 20.2071 7.20709L7.7071 19.7071C7.57895 19.8352 7.41837 19.9262 7.24253 19.9701L3.24253 20.9701C2.90176 21.0553 2.54127 20.9555 2.29289 20.7071C2.04451 20.4587 1.94466 20.0982 2.02986 19.7574L3.02986 15.7574C3.07381 15.5816 3.16473 15.421 3.29289 15.2929L15.7929 2.79288Z" />
                                    </svg>
                                </button>
                                <button type="button" class="flex justify-center items-center size-10 2xl:size-[48px] shadow-button border rounded-lg border-border-color">
                                    <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 5.44772 2.44772 5 3 5H21C21.5523 5 22 5.44772 22 6C22 6.55228 21.5523 7 21 7H3C2.44772 7 2 6.55228 2 6Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3C9.73478 3 9.48043 3.10536 9.29289 3.29289C9.10536 3.48043 9 3.73478 9 4V5H15V4C15 3.73478 14.8946 3.48043 14.7071 3.29289C14.5196 3.10536 14.2652 3 14 3H10ZM17 5V4C17 3.20435 16.6839 2.44129 16.1213 1.87868C15.5587 1.31607 14.7956 1 14 1H10C9.20435 1 8.44129 1.31607 7.87868 1.87868C7.31607 2.44129 7 3.20435 7 4V5H5C4.44772 5 4 5.44772 4 6V20C4 20.7957 4.31607 21.5587 4.87868 22.1213C5.44129 22.6839 6.20435 23 7 23H17C17.7957 23 18.5587 22.6839 19.1213 22.1213C19.6839 21.5587 20 20.7957 20 20V6C20 5.44772 19.5523 5 19 5H17ZM6 7V20C6 20.2652 6.10536 20.5196 6.29289 20.7071C6.48043 20.8946 6.73478 21 7 21H17C17.2652 21 17.5196 20.8946 17.7071 20.7071C17.8946 20.5196 18 20.2652 18 20V7H6Z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
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

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border border-subtitle-color text-subtitle-color rounded-lg {{ (int) $page === ((int) $totalPages - 1) ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === ((int) $totalPages - 1) ? 'disabled' : '' }}>
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
                            <x-dropdown-link wire:click="changePageSize({{ $value }})">
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
    <div class="block laptop:hidden">
        <div class="bg-white shadow-card rounded-lg p-4 mb-4">
            <!-- Botões de paginação -->
            <div class="flex flex-row itens-center justify-center space-x-2 ">
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

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border border-subtitle-color text-subtitle-color rounded-lg {{ (int) $page === ((int) $totalPages - 1) ? 'bg-disabled border-disabled' : 'border-subtitle-color' }}" {{ (int) $page === ((int) $totalPages - 1) ? 'disabled' : '' }}>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 5.29289C8.68342 4.90237 9.31658 4.90237 9.70711 5.29289L15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L13.5858 12L8.29289 6.70711C7.90237 6.31658 7.90237 5.68342 8.29289 5.29289Z" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-row itens-center  max-w-80 mt-4">
                <!-- Quantidade de itens por página -->
                <div class="w-3/5">
                    <div class="flex items-center">
                        <x-dropdown align="right" full="true" width="24">
                            <x-slot name="trigger">
                                <button class="h-10 w-full inline-flex items-center justify-between px-3 py-2 bg-white border border-border-color text-black font-normal text-normal rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                    {{ $perPage }}
                                    <!-- Ícone -->
                                    <svg class="fill-current size-2" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($perPageOptions as $value)
                                    <x-dropdown-link wire:click="changePageSize({{ $value }})">
                                        {{ $value }}
                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                        </x-dropdown>

                        <span class="font-normal text-normal text-black text-nowrap mx-2">/ {{ __('pages') }}</span>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="w-2/5">
                    <x-dropdown align="right" width="24">
                        <x-slot name="trigger">
                            <button class="h-10 w-full inline-flex items-center justify-center px-3 py-2 bg-white border border-border-color text-black font-normal text-normal rounded-md leading-4 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                <!-- Ícone -->
                                <svg class="fill-current size-2" viewBox="0 0 14 8" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach ($perPageOptions as $value)
                                <x-dropdown-link wire:click="changePageSize({{ $value }})">
                                    {{ $value }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>
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
                        <button type="button" class="flex justify-center items-center size-12 shadow-button border rounded-lg border-border-color my-2">
                            <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 20C11 19.4477 11.4477 19 12 19H21C21.5523 19 22 19.4477 22 20C22 20.5523 21.5523 21 21 21H12C11.4477 21 11 20.5523 11 20Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18 3.87866C17.7026 3.87866 17.4174 3.9968 17.2071 4.20709L4.90296 16.5112L4.37437 18.6256L6.48875 18.097L18.7929 5.79288C18.897 5.68875 18.9796 5.56514 19.036 5.42909C19.0923 5.29305 19.1213 5.14724 19.1213 4.99998C19.1213 4.85273 19.0923 4.70692 19.036 4.57087C18.9796 4.43483 18.897 4.31121 18.7929 4.20709C18.6888 4.10296 18.5652 4.02037 18.4291 3.96402C18.2931 3.90767 18.1473 3.87866 18 3.87866ZM15.7929 2.79288C16.3783 2.20751 17.1722 1.87866 18 1.87866C18.4099 1.87866 18.8158 1.9594 19.1945 2.11626C19.5732 2.27312 19.9173 2.50303 20.2071 2.79288C20.4969 3.08272 20.7269 3.42681 20.8837 3.8055C21.0406 4.1842 21.1213 4.59008 21.1213 4.99998C21.1213 5.40988 21.0406 5.81576 20.8837 6.19446C20.7269 6.57316 20.4969 6.91725 20.2071 7.20709L7.7071 19.7071C7.57895 19.8352 7.41837 19.9262 7.24253 19.9701L3.24253 20.9701C2.90176 21.0553 2.54127 20.9555 2.29289 20.7071C2.04451 20.4587 1.94466 20.0982 2.02986 19.7574L3.02986 15.7574C3.07381 15.5816 3.16473 15.421 3.29289 15.2929L15.7929 2.79288Z" />
                            </svg>
                        </button>
                        <button type="button" class="flex justify-center items-center size-12 shadow-button border rounded-lg border-border-color">
                            <svg class="size-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 5.44772 2.44772 5 3 5H21C21.5523 5 22 5.44772 22 6C22 6.55228 21.5523 7 21 7H3C2.44772 7 2 6.55228 2 6Z" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3C9.73478 3 9.48043 3.10536 9.29289 3.29289C9.10536 3.48043 9 3.73478 9 4V5H15V4C15 3.73478 14.8946 3.48043 14.7071 3.29289C14.5196 3.10536 14.2652 3 14 3H10ZM17 5V4C17 3.20435 16.6839 2.44129 16.1213 1.87868C15.5587 1.31607 14.7956 1 14 1H10C9.20435 1 8.44129 1.31607 7.87868 1.87868C7.31607 2.44129 7 3.20435 7 4V5H5C4.44772 5 4 5.44772 4 6V20C4 20.7957 4.31607 21.5587 4.87868 22.1213C5.44129 22.6839 6.20435 23 7 23H17C17.7957 23 18.5587 22.6839 19.1213 22.1213C19.6839 21.5587 20 20.7957 20 20V6C20 5.44772 19.5523 5 19 5H17ZM6 7V20C6 20.2652 6.10536 20.5196 6.29289 20.7071C6.48043 20.8946 6.73478 21 7 21H17C17.2652 21 17.5196 20.8946 17.7071 20.7071C17.8946 20.5196 18 20.2652 18 20V7H6Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

