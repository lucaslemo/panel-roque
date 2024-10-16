<div>
    <div class="bg-white rounded-lg shadow-card p-4 md:p-6">
        <!-- Modal para visualizar um pedido -->
        <x-modal-panel title="" name="product-detail" width='large'>
            @if (!is_null($order))
                <div class="flex justify-end -mt-2 laptop:-mt-8 mb-2">
                    <button class="bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                        x-on:click="$dispatch('close-modal', 'product-detail')">
                        <svg class="size-4 laptop:size-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.43884 0.418419C1.88095 -0.139473 0.976437 -0.139473 0.418549 0.418418C-0.139339 0.97631 -0.139339 1.88083 0.418549 2.43872L7.9797 9.99993L0.418416 17.5613C-0.139472 18.1192 -0.139472 19.0237 0.418416 19.5816C0.976304 20.1395 1.88082 20.1395 2.43871 19.5816L9.99999 12.0202L17.5613 19.5816C18.1192 20.1395 19.0237 20.1395 19.5816 19.5816C20.1395 19.0237 20.1395 18.1192 19.5816 17.5613L12.0203 9.99993L19.5814 2.43872C20.1393 1.88083 20.1393 0.976312 19.5814 0.41842C19.0236 -0.139471 18.119 -0.139471 17.5612 0.41842L10 7.97962L2.43884 0.418419Z" fill="#022266"/>
                        </svg>
                    </button>
                </div>
                <div class="hidden laptop:flex flex-row justify-between items-center rounded-lg bg-background px-8 py-4">
                    <div class="text-lg font-medium text-black">{{ $order->dtPedido->format('d/m/Y | H:i:s') }}</div>
                    <div class="text-lg font-normal text-black xl:w-[377px] 2xl:w-[453px] truncate">{{ $order->nmCliente }}</div>
                    <div class="flex flex-row justify-center items-center text-lg font-normal text-black leading-none">
                        <div class="{{ $order->getStatusColor() }}-circle"></div>
                        {{ $order->statusEntrega }}
                    </div>
                    <div class="text-lg font-medium text-black">{{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}</div>
                </div>
                <div class="block laptop:hidden rounded-lg bg-background p-4">
                    <div class="text-small md:text-lg font-medium text-black mb-4">{{ $order->dtPedido->format('d/m/Y | H:i:s') }}</div>
                    <div class="text-small  md:text-lg font-normal text-black mb-4">{{ $order->nmCliente }}</div>
                    <div class="flex justify-start space-x-8">
                        <div class="text-small  md:text-lg font-medium text-black">{{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}</div>
                        <div class="flex flex-row justify-center items-center text-subtitle md:text-small font-normal text-black leading-none">
                            <div class="{{ $order->getStatusColor() }}-circle"></div>
                            {{ $order->statusEntrega }}
                        </div>
                    </div>
                </div>
                <div class="flex flex-col laptop:flex-row mb-6">
                    <div class="w-full ms-4 laptop:ms-12 overflow-y-auto hide-scrollbar max-h-[210px] laptop:max-h-[420px]">
                        <div class="flex flex-col">
                            @foreach ($order->orderHistories as $orderHistory)
                                <div class="grid grid-rows-2 grid-flow-col justify-items-center gap-x-2 w-max">

                                    <!-- Linha em cima do círculo -->
                                    <div class="w-0.5 h-full bg-background"></div>

                                    <!-- Círculo e linha inferior -->
                                    <div class="flex flex-col w-min items-center">
                                        @if ($order->statusEntrega === $orderHistory->nmStatusPedido)
                                            @if ($order->statusEntrega === 'Em trânsito')
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-yellow-500/50 ring-1 ring-inset ring-yellow-600/20 shadow-sm hover:bg-yellow-500/80"></div>
                                            @elseif ($order->statusEntrega === 'Montado')
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-primary/80 ring-1 ring-inset ring-primary/20 shadow-sm hover:bg-primary"></div>
                                            @elseif ($order->statusEntrega === 'Reservado' || $order->statusEntrega === 'Devolvido')
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-red-500/80 ring-1 ring-inset ring-red-500/20 shadow-sm hover:bg-red-500"></div>
                                            @elseif ($order->statusEntrega === 'Cancelado')
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-stone-500/80 ring-1 ring-inset ring-stone-500/20 shadow-sm hover:bg-stone-500"></div>
                                            @elseif ($order->statusEntrega === 'Entregue')
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-green-500/50 ring-1 ring-inset ring-green-600/20 shadow-sm hover:bg-green-500/80"></div>
                                            @else
                                                <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-stone-500/80 ring-1 ring-inset ring-stone-500/20 shadow-sm hover:bg-stone-500"></div>
                                            @endif
                                        @else
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-stone-500/80 ring-1 ring-inset ring-stone-500/20 shadow-sm hover:bg-stone-500"></div>
                                        @endif
                                        @if (!$loop->last)
                                            <div class="w-0.5 h-full bg-background"></div>
                                        @endif
                                    </div>

                                    <!-- Status e data -->
                                    <div class="row-start-2">
                                        <div class="text-small md:text-lg md:leading-none font-normal mb-2">
                                            {{ $orderHistory->nmStatusPedido }}.
                                        </div>
                                        <div class="text-subtitle md:text-normal font-light leading-none">
                                            {{ $orderHistory->dtStatusPedido->format('d/m/Y | H:i:s') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="w-full space-y-4 mt-4">
                        <!-- Vendedor -->
                        <div class="text-small md:text-lg font-normal text-black bg-background rounded-lg p-4 laptop:p-8">
                            <span class="font-medium">{{ __('Seller') }}:</span> {{ $order->nmVendedor }}
                        </div>

                        <!-- Empresa -->
                        <div class="text-small md:text-lg font-normal text-black bg-background rounded-lg p-4 laptop:p-8">
                            <span class="font-medium">{{ __('Enterprise') }}:</span> {{ $order->nmCliente }}
                        </div>

                        <!-- Tipo de entrega -->
                        <div class="text-small md:text-lg font-normal text-black bg-background rounded-lg p-4 laptop:p-8">
                            <span class="font-medium">{{ __('Delivery Type') }}:</span> {{ __($order->tpEntrega) }}
                        </div>

                        <!-- Data do faturamento -->
                        <div class="text-small md:text-lg font-normal text-black bg-background rounded-lg p-4 laptop:p-8">
                            <span class="font-medium">{{ __('Billing Date') }}:</span> {{ $order->dtFaturamento->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2 md:space-x-4 justify-end">
                    <a href="{{ $order->nmArquivoDetalhes }}" download class="flex justify-between items-center w-72 border border-primary bg-transparent rounded-lg text-normal font-medium text-primary leading-none py-2 px-2 md:px-4 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">

                        <svg class="w-[24px] h-[27px]" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="24" height="27" fill="url(#pattern0_2623_4482_b)"/>
                            <defs>
                            <pattern id="pattern0_2623_4482_b" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_2623_4482_b" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                            </pattern>
                            <image id="image0_2623_4482_b" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>

                        <span class="hidden md:block">{{ __('Download order details') }}</span>
                        <span class="block md:hidden">{{ __('Order Details') }}</span>
                    </a>
                    <a href="{{ $order->nmArquivoNotaFiscal }}" download class="flex justify-center items-center w-20 border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-[24px] h-[27px]" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="24" height="27" fill="url(#pattern0_2625_4499)"/>
                            <defs>
                            <pattern id="pattern0_2625_4499" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_2625_4499" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                            </pattern>
                            <image id="image0_2625_4499" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
                    </a>
                </div>
            @endif
        </x-modal-panel>

        <div class="flex flex-col sm:flex-row justify-between items-start md:items-center mb-6">

            <!-- Título -->
            <p class="text-normal md:text-lg font-medium text-black mb-4 md:mb-0">{{ __('Your latest orders') }}</p>

            <!-- Botão -->
            <x-dropdown align="right" width="72">
                <x-slot name="trigger">
                    <button class="flex flex-between items-center h-12 grow bg-white border border-black rounded-lg text-black text-normal font-normal py-4 px-4 md:px-8 hover:bg-primary-100 active:bg-primary-200 focus:outline-none">

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
                        <svg class="size-4 fill-black ms-2 md:ms-8" viewBox="0 0 20 12" xmlns="http://www.w3.org/2000/svg">
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
                                    <svg class="size-6 min-w-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711L12.7071 14.7071C12.3166 15.0976 11.6834 15.0976 11.2929 14.7071L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L21.2929 3.29289C21.6834 2.90237 22.3166 2.90237 22.7071 3.29289Z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C4.73478 4 4.48043 4.10536 4.29289 4.29289C4.10536 4.48043 4 4.73478 4 5V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H19C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19V12C20 11.4477 20.4477 11 21 11C21.5523 11 22 11.4477 22 12V19C22 19.7957 21.6839 20.5587 21.1213 21.1213C20.5587 21.6839 19.7957 22 19 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V5C2 4.20435 2.31607 3.44129 2.87868 2.87868C3.44129 2.31607 4.20435 2 5 2H16C16.5523 2 17 2.44772 17 3C17 3.55228 16.5523 4 16 4H5Z" />
                                    </svg>
                                @else
                                    <svg class="size-6 min-w-6 fill-current me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

        <div class="relative space-y-3 md:space-y-6 mb-6">
            @foreach ($lastOrders as $lastOrder)
                <!-- Desktop version -->
                <div class="hidden md:grid grid-cols-5 sub-middle:grid-cols-6 laptop:grid-cols-5 middle:grid-cols-6 gap-x-1 bg-background rounded-lg items-center px-4 xl:px-8 py-4">
                    <!-- Data do pedido -->
                    <div class="col-span-1 text-base xl:text-lg font-medium text-black w-full truncate">
                        {{ \Carbon\Carbon::parse($lastOrder->dtPedido)->format('d/m/Y') }}
                    </div>

                    <!-- Nome do cliente -->
                    <div class="col-span-1 sub-middle:col-span-2 laptop:col-span-1 middle:col-span-2 text-base xl:text-lg font-normal text-black w-full truncate">
                        {{ $lastOrder->nmCliente }}
                    </div>

                    <!-- Status do pedido -->
                    <div class="flex flex-row items-center justify-center sub-middle:justify-start laptop:justify-center middle:justify-start col-span-1 text-base xl:text-lg font-normal text-black w-full truncate">
                        @if ($lastOrder->statusEntrega === 'Em trânsito')
                            <div class="yellow-circle"></div>
                        @elseif ($lastOrder->statusEntrega === 'Montado')
                            <div class="primary-circle"></div>
                        @elseif ($lastOrder->statusEntrega === 'Reservado' || $lastOrder->statusEntrega === 'Devolvido')
                            <div class="red-circle"></div>
                        @elseif ($lastOrder->statusEntrega === 'Cancelado')
                            <div class="stone-circle"></div>
                        @elseif ($lastOrder->statusEntrega === 'Entregue')
                            <div class="green-circle"></div>
                        @else
                            <div class="stone-circle"></div>
                        @endif

                        {{ $lastOrder->statusEntrega }}
                    </div>

                    <!-- Valor -->
                    <div class="col-span-1 text-base xl:text-lg font-medium text-black text-center sub-middle:text-start laptop:text-center middle:text-start w-full truncate">
                        {{ 'R$ ' . number_format($lastOrder->vrTotal, 2, ',', '.') }}
                    </div>

                    <!-- Botões de ação -->
                    <div class="flex flex-row col-span-1 space-x-2">
                        <button class="flex justify-center items-center border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="$dispatch('set-order-detail', { id: {{ $lastOrder->idPedidoCabecalho }} })">

                            <svg class="w-auto h-[22px] xl:w-[24px] xl:h-[27px]" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2623_4481_a)"/>
                                <defs>
                                <pattern id="pattern0_2623_4481_a" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2623_4481_a" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2623_4481_a" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </button>
                        <a href="{{ $lastOrder->nmArquivoDetalhes }}" download class="flex justify-center items-center border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">

                            <svg class="w-auto h-[22px] xl:w-[24px] xl:h-[27px]" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2623_4482_a)"/>
                                <defs>
                                <pattern id="pattern0_2623_4482_a" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2623_4482_a" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2623_4482_a" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </a>
                        <a href="{{ $lastOrder->nmArquivoNotaFiscal }}" download class="flex justify-center items-center border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">
                            <svg class="w-auto h-[22px] xl:w-[24px] xl:h-[27px]" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2625_4499_a)"/>
                                <defs>
                                <pattern id="pattern0_2625_4499_a" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2625_4499_a" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2625_4499_a" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>

                 <!-- Mobile version -->
                 <div class="block md:hidden bg-background rounded-lg p-4">
                    <div class="flex justify-between mb-2">
                        <!-- Data -->
                        <div class="text-small font-medium">
                            {{ \Carbon\Carbon::parse($lastOrder->dtPedido)->format('d/m/Y') }}
                        </div>

                        <!-- Status -->
                        <div class="flex flex-row items-center justify-center text-subtitle font-normal">
                            @if ($lastOrder->statusEntrega === 'Em trânsito')
                                <div class="yellow-circle"></div>
                            @elseif ($lastOrder->statusEntrega === 'Montado')
                                <div class="primary-circle"></div>
                            @elseif ($lastOrder->statusEntrega === 'Reservado' || $lastOrder->statusEntrega === 'Devolvido')
                                <div class="red-circle"></div>
                            @elseif ($lastOrder->statusEntrega === 'Cancelado')
                                <div class="stone-circle"></div>
                            @elseif ($lastOrder->statusEntrega === 'Entregue')
                                <div class="green-circle"></div>
                            @else
                                <div class="stone-circle"></div>
                            @endif

                            {{ $lastOrder->statusEntrega }}
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="text-small font-normal mb-4">
                        {{ $lastOrder->nmCliente }}
                    </div>

                    <!-- Valor -->
                    <div class="text-small font-medium mb-4">
                        {{ 'R$ ' . number_format($lastOrder->vrTotal, 2, ',', '.') }}
                    </div>

                    <div class="flex flex-row justify-center space-x-3">
                        <button class="flex justify-center items-center w-20 border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                            x-on:click="$dispatch('set-order-detail', { id: {{ $lastOrder->idPedidoCabecalho }} })">

                            <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2623_4481)"/>
                                <defs>
                                <pattern id="pattern0_2623_4481" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2623_4481" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2623_4481" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </button>
                        <a href="{{ $lastOrder->nmArquivoDetalhes }}" download class="flex justify-center items-center w-20 border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">

                            <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2623_4482)"/>
                                <defs>
                                <pattern id="pattern0_2623_4482" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2623_4482" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2623_4482" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </a>
                        <a href="{{ $lastOrder->nmArquivoNotaFiscal }}" download class="flex justify-center items-center w-20 border border-primary bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150">
                            <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="24" height="27" fill="url(#pattern0_2625_4499)"/>
                                <defs>
                                <pattern id="pattern0_2625_4499" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2625_4499" transform="matrix(0.00878906 0 0 0.0078125 -0.0625 0)"/>
                                </pattern>
                                <image id="image0_2625_4499" width="128" height="128" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </a>
                    </div>
                 </div>
            @endforeach
            @if (count($lastOrders) === 0)
                <div class="text-small sm:text-base xl:text-lg font-medium text-black text-center w-full mt-10">
                    {{ __('There are no registered orders yet') }}.
                </div>
            @endif
        </div>

        @if (count($lastOrders) > 0)
            <div class="flex justify-center md:justify-end">
                <div class="w-44">
                    <x-secondary-button href="{{ route('app.orders') }}" class="text-normal font-semibold focus:outline-none" wire:navigate>
                        {{ __('View more') }}
                    </x-secondary-button>
                </div>
            </div>
        @endif

    </div>
    <div class="text-subtitle md:text-small font-medium mt-8">
        *{{ __('Account and order history is for the last 90 days.') }}
    </div>
</div>

