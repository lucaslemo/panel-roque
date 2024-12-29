<div class="relative mt-4 laptop:mt-8">

    <!-- Loading Overlay -->
    <div wire:loading.flex class="absolute inset-0 flex items-center justify-center bg-trasparent z-100">
        <p class="bg-white rounded-lg shadow-hight-card font-medium text-h5 text-black px-12 py-6">{{ __('Loading...') }}</p>
    </div>

    <!-- Card -->
    <div class="bg-white shadow-card rounded-lg px-4 md:px-6 py-8">

        <!-- Header -->
        <div class="flex justify-between">
            <div class="flex items-center text-lg font-semibold leading-none text-black">
                <div class="green-circle"></div>
                {{ __('Payment history') }}
            </div>

            <!-- Paginação -->
            <div class="hidden laptop:flex flex-row space-x-2">
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
        </div>

        <!-- Itens -->
        <div class="flex flex-col space-y-4 laptop:space-y-6 mt-4 laptop:mt-6">
            @foreach ($invoices as $invoice)

                <!-- Desktop -->
                <div class="hidden laptop:flex space-x-4 items-center bg-background shadow-card rounded-lg p-4 md:p-6">

                    <!-- Pagamento concluído -->
                    <div class="text-base xl:text-lg w-1/4">
                        <div class="flex items-center font-medium leading-none">
                            <div class="green-circle"></div>
                            <span class="text-green-500">{{ __('Payment completed') }}</span>
                        </div>
                        <div class="font-normal text-black leading-none mt-2 ms-4 2xl:ms-5">
                            {{ __('Emission') }}: {{ \Carbon\Carbon::parse($invoice->dtEmissao)->format('d/m/Y') }}
                        </div>
                    </div>

                    <!-- Numero da duplicata -->
                    <div class="text-base xl:text-lg text-black w-1/4">
                        <div class="font-medium leading-none">#{{ $invoice->extConta }}</div>
                        <div class="font-normal leading-none mt-2">{{ __('Due date') }}: {{ \Carbon\Carbon::parse($invoice->dtVencimento)->format('d/m/Y') }}</div>
                    </div>

                    <!-- Valor original -->
                    <div class="text-base xl:text-lg text-black text-nowrap w-1/4">
                        <div class="font-medium leading-none">{{ __('Original value') }}: {{ 'R$ ' . number_format($invoice->vrBruto, 2, ',', '.') }}</div>
                        <div class="font-normal leading-none mt-2">{{ __('Payment') }}: {{ \Carbon\Carbon::parse($invoice->dtPagamento)->format('d/m/Y') }}</div>
                    </div>

                    <!-- Valor total -->
                    <div class="text-base xl:text-lg text-black w-1/4">
                        <div class="font-medium leading-none">{{ __('Total value') }}: {{ 'R$ ' . number_format($invoice->vrPago, 2, ',', '.') }}</div>
                        <div class="font-normal leading-none mt-2">{{ __('Fees') }}: {{ 'R$ ' . number_format(($invoice->vrPago - $invoice->vrBruto), 2, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="block laptop:hidden bg-background shadow-card rounded-lg p-4">

                    <!-- Vencimento -->
                    <div class="flex items-center leading-none text-subtitle md:text-small font-medium mb-4">
                        <div class="green-circle"></div>
                        <span class="text-green-500">{{ __('Payment completed') }}</span>
                    </div>

                    <!-- Numero da duplicata -->
                    <div class="text-small md:text-base text-black mb-4">
                        <div class="font-medium">{{ $invoice->numDuplicata }}</div>
                        <div class="font-light">| {{ __('Payments') }} {{ $invoice->numParcela }}/{{ $invoice->numTotalParcela }}</div>
                    </div>

                    <!-- Valor -->
                    <div class="text-small md:text-base font-medium text-black mb-4">
                        {{ 'R$ ' . number_format($invoice->vrPago, 2, ',', '.') }}
                    </div>

                    <!-- Data do pagamento -->
                    <div class="text-small md:text-base font-medium text-black mb-2">
                        {{ __('Payment') }}: {{ \Carbon\Carbon::parse($invoice->dtPagamento)->format('d/m/Y') }}
                    </div>

                    <!-- Data do vencinento -->
                    <div class="text-small md:text-base font-normal text-black mb-2">
                        {{ __('Due date') }}: {{ \Carbon\Carbon::parse($invoice->dtVencimento)->format('d/m/Y') }}
                    </div>

                    <!-- Data de emissão -->
                    <div class="text-small md:text-base font-normal text-black">
                        {{ __('Emission') }}: {{ \Carbon\Carbon::parse($invoice->dtEmissao)->format('d/m/Y') }}
                    </div>
                </div>
            @endforeach
            @if (count($invoices) === 0)
                <div class="text-small sm:text-base xl:text-lg font-medium text-black text-center w-full mt-10">
                    {{ __('There are no registered invoices yet') }}.
                </div>
            @endif

            <!-- Botões de paginação mobile -->
            <div class="flex laptop:hidden flex-row itens-center justify-center space-x-2 sm:space-x-3">
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
        </div>
    </div>

    <div class="text-subtitle md:text-small font-medium mt-8">
        *{{ __('Account and order history is for the last 90 days.') }}
    </div>
</div>
