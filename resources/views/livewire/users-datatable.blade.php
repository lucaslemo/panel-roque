<div>
    <div class="hidden laptop:block overflow-x-auto bg-white shadow-card rounded-lg p-4">
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
                        <td class="table-body text-center border-t border-e text-normal">{{ $item->id }}</td>
                        <td class="table-body border-t border-e text-normal ">{{ $item->name }}</td>
                        <td class="table-body border-t border-e text-small">{{ $item->email }}</td>
                        <td class="table-body border-t border-e text-small">{{ formatCnpjCpf($item->cpf) }}</td>
                        <td class="table-body border-t border-e text-small">
                            @if (count($item->customers) === 0)
                                {{ __('Does not have') }}
                            @endif
                            @foreach ($item->customers as $key => $customer)
                                <div>
                                    {{ ($key + 1) . '. ' . $customer->nmCliente }}
                                </div>
                            @endforeach
                        </td>
                        <td class="table-body border-t border-e text-small">{{ $item->getTypeName() }}</td>
                        <td class="table-body border-t border-e text-small">
                            <div class="flex justify-start items-center">
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
                        </td>
                        <td class="table-body border-t text-small">Action</td>
                    </tr>
                @endforeach
            <tbody>
        </table>

        <!-- Botões de ação -->
        <div class="flex flex-row space-x-2 justify-end mt-2">

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
    </div>
    <div class="block laptop:hidden">
        <div class="bg-white shadow-card rounded-lg p-4 mb-4">
            <div class="flex flex-row itens-center justify-center space-x-2">
                <button wire:click="previousPage" type="button" class="flex justify-center items-center size-10 shadow-button border border-subtitle-color text-subtitle-color rounded-lg" disabled>
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289Z" />
                    </svg>
                </button>

                @for ($i = 0; $i < $totalPages; $i++)
                    @if ($i < 4)
                        <button wire:click="goToPage({{ $i }})" type="button" class="table-page-button {{ $i === $page ? 'border-primary text-primary' : 'border-subtitle-color text-subtitle-color' }}">
                            {{ $i + 1 }}
                        </button>
                    @endif
                @endfor

                <button wire:click="nextPage" type="button" class="flex justify-center items-center size-10 shadow-button border border-subtitle-color text-subtitle-color rounded-lg">
                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.29289 5.29289C8.68342 4.90237 9.31658 4.90237 9.70711 5.29289L15.7071 11.2929C16.0976 11.6834 16.0976 12.3166 15.7071 12.7071L9.70711 18.7071C9.31658 19.0976 8.68342 19.0976 8.29289 18.7071C7.90237 18.3166 7.90237 17.6834 8.29289 17.2929L13.5858 12L8.29289 6.70711C7.90237 6.31658 7.90237 5.68342 8.29289 5.29289Z" />
                    </svg>
                </button>
            </div>
        </div>
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
        @endforeach
    </div>
</div>

