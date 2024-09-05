<div>
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
                    <td class="table-body text-center border-t border-e">{{ $item->id }}</td>
                    <td class="table-body border-t border-e">{{ $item->name }}</td>
                    <td class="table-body border-t border-e">{{ $item->email }}</td>
                    <td class="table-body border-t border-e">{{ $item->cpf }}</td>
                    <td class="table-body border-t border-e">
                        @if (count($item->customers) === 0)
                            {{ __('Does not have') }}
                        @endif
                        @foreach ($item->customers as $key => $customer)
                            <div>
                                {{ ($key + 1) . '. ' . $customer->nmCliente }}
                            </div>
                        @endforeach
                    </td>
                    <td class="table-body border-t border-e">{{ $item->getTypeName() }}</td>
                    <td class="table-body border-t border-e flex justify-center items-center">
                        @if ($item->active === false)
                            <!-- Status inativo -->
                            <div class="stone-circle"></div>
                            {{ __('Inactive') }}
                        @elseif ($item->active === true && is_null($item->last_login_at))
                            <!-- Status Pendente -->
                            <div class="yellow-circle"></div>
                            {{ __('Pending') }}
                        @else
                            <!-- Status Ativo -->
                            <div class="green-circle"></div>
                            {{ __('Active') }}
                        @endif
                    </td>
                    <td class="table-body border-t">Action</td>
                </tr>
            @endforeach
        <tbody>
    </table>

    <!-- Botões de ação -->
    <div class="flex flex-row space-x-1 justify-end mt-2">

        <button wire:click="previousPage" type="button" class="flex justify-center items-center size-10 shadow-button border border-subtitle-color text-subtitle-color rounded-lg" disabled>
            <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.7071 5.29289C16.0976 5.68342 16.0976 6.31658 15.7071 6.70711L10.4142 12L15.7071 17.2929C16.0976 17.6834 16.0976 18.3166 15.7071 18.7071C15.3166 19.0976 14.6834 19.0976 14.2929 18.7071L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L14.2929 5.29289C14.6834 4.90237 15.3166 4.90237 15.7071 5.29289Z" />
            </svg>
        </button>

        @for ($i = 0; $i < $totalPages; $i++)
            @if ($i < 4 || $i === $page || $i > ($totalPages - 4))
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

