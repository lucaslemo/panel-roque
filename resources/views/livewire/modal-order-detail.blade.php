<div>
    @if (!is_null($order))
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
            @if (count($order->orderHistories) === 0)
                <div class="flex w-full justify-center items-center text-small md:text-lg font-normal p-4">
                    {{ __('There is no tracking history for this order.') }}
                </div>
            @else
                <div class="w-full ps-4 laptop:ps-12 overflow-y-auto hide-scrollbar max-h-[210px] laptop:max-h-[420px] shadow-inner-b">
                    <div class="flex flex-col">
                        @foreach ($order->orderHistories as $orderHistory)
                            <div class="grid grid-rows-2 grid-flow-col justify-items-center gap-x-2 w-max">

                                <!-- Linha em cima do círculo -->
                                <div class="w-0.5 h-full bg-background"></div>

                                <!-- Círculo e linha inferior -->
                                <div class="flex flex-col w-min items-center">
                                    @if ($loop->first)
                                        @if ($order->statusEntrega === 'Entregue')
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-green-500/50 ring-1 ring-inset ring-green-600/20 shadow-sm hover:bg-green-500/80"></div>
                                        @elseif ($order->statusEntrega === 'Separado' || $order->statusEntrega === 'Montado')
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-primary/80 ring-1 ring-inset ring-primary/20 shadow-sm hover:bg-primary"></div>
                                        @elseif ($order->statusEntrega === 'Em trânsito')
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-yellow-500/50 ring-1 ring-inset ring-yellow-600/20 shadow-sm hover:bg-yellow-500/80"></div>
                                        @elseif ($order->statusEntrega === 'Devolvido' || $order->statusEntrega === 'Reprogramado')
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-stone-500/80 ring-1 ring-inset ring-stone-500/20 shadow-sm hover:bg-stone-500"></div>
                                        @elseif ($order->statusEntrega === 'Reservado')
                                            <div class="size-3.5 min-h-3.5 md:size-4 md:min-h-4 rounded-full bg-red-500/80 ring-1 ring-inset ring-red-500/20 shadow-sm hover:bg-red-500"></div>
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
            @endif
            <div class="w-full space-y-4 mt-0 laptop:mt-4">
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
</div>
