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
                <div class="red-circle"></div>
                {{ __('Open accounts') }}
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

                    <!-- Vencimento -->
                    <div class="flex items-center text-base xl:text-lg font-medium leading-none text-nowrap w-max middle:w-1/6 xl:w-1/5">
                        @if(\Carbon\Carbon::parse($invoice->dtVencimento)->lt(now()->startOfDay()))
                            <div class="red-circle"></div>
                            <span class="text-red-500">{{ __('Overdue') }}</span>
                        @else
                            <div class="yellow-circle"></div>
                            <span class="text-yellow-500">{{ __('Due') }}</span>
                        @endif
                    </div>

                    <!-- Numero da duplicata -->
                    <div class="text-base xl:text-lg truncate w-full middle:w-1/3">
                        <span class="font-medium">{{ $invoice->numDuplicata }}</span>
                        <span class="font-light"> | {{ __('Payments') }} {{ 1 }}/{{ 5 }}</span>
                    </div>

                    <!-- Data da parcela -->
                    <div class="text-base xl:text-lg text-nowrap font-medium w-max middle:w-1/2 2xl:w-1/3">
                        {{ __('Payment date') }}: {{ \Carbon\Carbon::parse($invoice->dtParcela)->format('d/m/Y') }}
                    </div>

                    <!-- Valor -->
                    <div class="text-base xl:text-lg font-medium w-max middle:w-1/6 2xl:w-1/5 text-nowrap">
                        {{ 'R$ ' . number_format($invoice->vrAtualizado, 2, ',', '.') }}
                    </div>

                    <div class="flex justify-end items-center relative w-max"
                        x-data="{ content: '{{ $invoice->codBoleto }}',
                            showPopup: false,
                            iframe: null,
                            copy() {
                                const textarea = document.createElement('textarea');
                                textarea.value = this.content;
                                document.body.appendChild(textarea);
                                textarea.select();
                                textarea.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(textarea.value)
                                    .then(() => this.triggerPopup())
                                    .catch(() => console.log('Falha ao copiar.'));
                                document.body.removeChild(textarea);
                                this.triggerPopup();
                            },
                            triggerPopup() {
                                this.showPopup = true;
                                setTimeout(() => this.showPopup = false, 1000);
                            },
                            printPDF(url) {
                                if (this.iframe) {
                                    document.body.removeChild(this.iframe);
                                    this.iframe = null;
                                }

                                this.iframe = document.createElement('iframe');
                                this.iframe.src = url;
                                this.iframe.style.display = 'none';
                                document.body.appendChild(this.iframe);

                                this.iframe.onload = () => {
                                    this.iframe.contentWindow.focus();
                                    this.iframe.contentWindow.print();
                                };

                                window.addEventListener('afterprint', () => {
                                    document.body.removeChild(this.iframe);
                                    this.iframe = null;
                                });
                            }
                        }">

                        <!-- Popup de Sucesso -->
                        <div class="absolute -left-32 -top-6 bg-green-500/90 text-subtitle text-white text-nowrap p-2 rounded-md shadow-md"
                            x-show="showPopup"
                            x-transition.duration.500ms>

                            Código do boleto copiado!
                        </div>

                        <!-- Copiar código de barras -->
                        <button class="flex justify-center items-center border border-black bg-transparent rounded-lg me-2 h-12 min-w-20 p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="copy()">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="24" fill="url(#pattern0_2627_4885)"/>
                                <defs>
                                <pattern id="pattern0_2627_4885" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2627_4885" transform="scale(0.0078125)"/>
                                </pattern>
                                <image id="image0_2627_4885" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </button>

                        <!-- Imprimir -->
                        <button class="flex justify-center items-center border border-black bg-transparent rounded-lg h-12 min-w-20 p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="printPDF('{{ $invoice->nmArquivoConta }}')">

                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2625_4811)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.58337 1.83268C4.58337 1.32642 4.99378 0.916016 5.50004 0.916016H16.5C17.0063 0.916016 17.4167 1.32642 17.4167 1.83268V8.24935C17.4167 8.75561 17.0063 9.16602 16.5 9.16602C15.9938 9.16602 15.5834 8.75561 15.5834 8.24935V2.74935H6.41671V8.24935C6.41671 8.75561 6.0063 9.16602 5.50004 9.16602C4.99378 9.16602 4.58337 8.75561 4.58337 8.24935V1.83268Z" fill="#494949"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.66663 9.16732C3.42351 9.16732 3.19035 9.26389 3.01845 9.4358C2.84654 9.60771 2.74996 9.84087 2.74996 10.084V14.6673C2.74996 14.9104 2.84654 15.1436 3.01845 15.3155C3.19035 15.4874 3.42351 15.584 3.66663 15.584H5.49996C6.00622 15.584 6.41663 15.9944 6.41663 16.5007C6.41663 17.0069 6.00622 17.4173 5.49996 17.4173H3.66663C2.93728 17.4173 2.23781 17.1276 1.72208 16.6119C1.20636 16.0961 0.916626 15.3967 0.916626 14.6673V10.084C0.916626 9.35464 1.20636 8.65517 1.72208 8.13944C2.23781 7.62372 2.93728 7.33398 3.66663 7.33398H18.3333C19.0626 7.33398 19.7621 7.62372 20.2778 8.13944C20.7936 8.65517 21.0833 9.35464 21.0833 10.084V14.6673C21.0833 15.3967 20.7936 16.0961 20.2778 16.6119C19.7621 17.1276 19.0626 17.4173 18.3333 17.4173H16.5C15.9937 17.4173 15.5833 17.0069 15.5833 16.5007C15.5833 15.9944 15.9937 15.584 16.5 15.584H18.3333C18.5764 15.584 18.8096 15.4874 18.9815 15.3155C19.1534 15.1436 19.25 14.9104 19.25 14.6673V10.084C19.25 9.84087 19.1534 9.60771 18.9815 9.4358C18.8096 9.26389 18.5764 9.16732 18.3333 9.16732H3.66663Z" fill="#494949"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.58337 12.8327C4.58337 12.3264 4.99378 11.916 5.50004 11.916H16.5C17.0063 11.916 17.4167 12.3264 17.4167 12.8327V20.166C17.4167 20.6723 17.0063 21.0827 16.5 21.0827H5.50004C4.99378 21.0827 4.58337 20.6723 4.58337 20.166V12.8327ZM6.41671 13.7493V19.2493H15.5834V13.7493H6.41671Z" fill="#494949"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_2625_4811">
                                <rect width="22" height="22" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="block laptop:hidden bg-background shadow-card rounded-lg p-4">

                    <!-- Vencimento -->
                    <div class="flex items-center leading-none text-subtitle font-medium mb-4">
                        @if(\Carbon\Carbon::parse($invoice->dtVencimento)->lt(now()->startOfDay()))
                            <div class="red-circle"></div>
                            <span class="text-red-500">{{ __('Overdue') }}</span>
                        @else
                            <div class="yellow-circle"></div>
                            <span class="text-yellow-500">{{ __('Due') }}</span>
                        @endif
                    </div>

                    <!-- Numero da duplicata -->
                    <div class="flex justify-between text-small mb-4">
                        <div>
                            <div class="font-medium">{{ $invoice->numDuplicata }}</div>
                            <div class="font-light"> | {{ __('Payments') }} {{ 1 }}/{{ 5 }}</div>
                        </div>

                        <!-- Data -->
                        <div class="text-small font-medium mb-4">
                            {{ \Carbon\Carbon::parse($invoice->dtParcela)->format('d/m/Y') }}
                        </div>
                    </div>

                    <!-- Valor -->
                    <div class="text-small font-medium mb-4">
                        {{ 'R$ ' . number_format($invoice->vrAtualizado, 2, ',', '.') }}
                    </div>

                    <!-- Botões -->
                    <div class="flex w-full relative"
                        x-data="{ content: '{{ $invoice->codBoleto }}',
                            showPopup: false,
                            iframe: null,
                            copy() {
                                const textarea = document.createElement('textarea');
                                textarea.value = this.content;
                                document.body.appendChild(textarea);
                                textarea.select();
                                textarea.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(textarea.value)
                                    .then(() => this.triggerPopup())
                                    .catch(() => console.log('Falha ao copiar.'));
                                document.body.removeChild(textarea);
                                this.triggerPopup();
                            },
                            triggerPopup() {
                                this.showPopup = true;
                                setTimeout(() => this.showPopup = false, 1000);
                            },
                            printPDF(url) {
                                window.open(url, '_blank');
                            }
                        }">

                        <!-- Popup de Sucesso -->
                        <div class="absolute left-0 -top-6 bg-green-500/90 text-subtitle text-white text-nowrap p-2 rounded-md shadow-md"
                            x-show="showPopup"
                            x-transition.duration.500ms>

                            Código do boleto copiado!
                        </div>

                        <!-- Copiar código de barras -->
                        <button class="flex justify-center items-center border border-black bg-transparent rounded-lg me-2 h-12 w-1/2 p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="copy()">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="24" fill="url(#pattern0_2627_4885_m)"/>
                                <defs>
                                <pattern id="pattern0_2627_4885_m" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2627_4885_m" transform="scale(0.0078125)"/>
                                </pattern>
                                <image id="image0_2627_4885_m" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </button>

                        <!-- Imprimir -->
                        <button class="flex justify-center items-center border border-black bg-transparent rounded-lg h-12 w-1/2 p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="printPDF('{{ $invoice->nmArquivoConta }}')">

                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2625_4811_m)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.58337 1.83268C4.58337 1.32642 4.99378 0.916016 5.50004 0.916016H16.5C17.0063 0.916016 17.4167 1.32642 17.4167 1.83268V8.24935C17.4167 8.75561 17.0063 9.16602 16.5 9.16602C15.9938 9.16602 15.5834 8.75561 15.5834 8.24935V2.74935H6.41671V8.24935C6.41671 8.75561 6.0063 9.16602 5.50004 9.16602C4.99378 9.16602 4.58337 8.75561 4.58337 8.24935V1.83268Z" fill="#494949"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.66663 9.16732C3.42351 9.16732 3.19035 9.26389 3.01845 9.4358C2.84654 9.60771 2.74996 9.84087 2.74996 10.084V14.6673C2.74996 14.9104 2.84654 15.1436 3.01845 15.3155C3.19035 15.4874 3.42351 15.584 3.66663 15.584H5.49996C6.00622 15.584 6.41663 15.9944 6.41663 16.5007C6.41663 17.0069 6.00622 17.4173 5.49996 17.4173H3.66663C2.93728 17.4173 2.23781 17.1276 1.72208 16.6119C1.20636 16.0961 0.916626 15.3967 0.916626 14.6673V10.084C0.916626 9.35464 1.20636 8.65517 1.72208 8.13944C2.23781 7.62372 2.93728 7.33398 3.66663 7.33398H18.3333C19.0626 7.33398 19.7621 7.62372 20.2778 8.13944C20.7936 8.65517 21.0833 9.35464 21.0833 10.084V14.6673C21.0833 15.3967 20.7936 16.0961 20.2778 16.6119C19.7621 17.1276 19.0626 17.4173 18.3333 17.4173H16.5C15.9937 17.4173 15.5833 17.0069 15.5833 16.5007C15.5833 15.9944 15.9937 15.584 16.5 15.584H18.3333C18.5764 15.584 18.8096 15.4874 18.9815 15.3155C19.1534 15.1436 19.25 14.9104 19.25 14.6673V10.084C19.25 9.84087 19.1534 9.60771 18.9815 9.4358C18.8096 9.26389 18.5764 9.16732 18.3333 9.16732H3.66663Z" fill="#494949"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.58337 12.8327C4.58337 12.3264 4.99378 11.916 5.50004 11.916H16.5C17.0063 11.916 17.4167 12.3264 17.4167 12.8327V20.166C17.4167 20.6723 17.0063 21.0827 16.5 21.0827H5.50004C4.99378 21.0827 4.58337 20.6723 4.58337 20.166V12.8327ZM6.41671 13.7493V19.2493H15.5834V13.7493H6.41671Z" fill="#494949"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_2625_4811_m">
                                <rect width="22" height="22" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </button>

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
</div>
