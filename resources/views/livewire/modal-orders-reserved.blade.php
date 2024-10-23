<div>
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="text-normal laptop:text-lg font-medium text-black mb-4 md:mb-0">
            {{ __('Orders to be invoiced') }}
        </div>
        <div class="text-normal laptop:text-lg text-center w-full md:w-auto font-medium text-black rounded-lg bg-secondary/20 py-4 px-4 md:px-24">
            {{ __('Total') }}: {{ 'R$ ' . number_format($reservedValue, 2, ',', '.') }}
        </div>
    </div>

    @if (count($orders) === 0)
        <div class="text-small md:text-lg font-medium text-center mt-8">
            {{ __('There are no pre-sale orders.') }}
        </div>
    @else
        <div class="flex flex-col space-y-4 mt-0 md:mt-4">
            @foreach ($orders as $order)
                <div class="hidden laptop:grid grid-cols-4 sub-middle:grid-cols-6 laptop:grid-cols-4 middle:grid-cols-6 gap-x-1 bg-background rounded-lg items-center px-4 xl:px-8 py-4">
                    <!-- Data -->
                    <div class="col-span-1 sub-middle:col-span-2 laptop:col-span-1 middle:col-span-2 text-base xl:text-lg font-medium text-black w-full truncate">
                        {{ \Carbon\Carbon::parse($order->dtPedido)->format('d/m/Y | H:i:s') }}
                    </div>

                    <!-- Nome do cliente -->
                    <div class="col-span-1 sub-middle:col-span-2 laptop:col-span-1 middle:col-span-2 text-base xl:text-lg font-normal text-black w-full truncate">
                        {{ $order->customer->nmCliente }}
                    </div>

                    <!-- Status -->
                    <div class="flex flex-row items-center justify-center sub-middle:justify-start laptop:justify-center middle:justify-start col-span-1 text-base xl:text-lg font-normal text-black w-full truncate">
                        <div class="red-circle"></div>
                        {{ $order->statusPedido }}
                    </div>

                    <!-- Valor -->
                    <div class="col-span-1 text-base xl:text-lg font-medium text-black text-center sub-middle:text-start laptop:text-center middle:text-start w-full truncate">
                        {{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}
                    </div>
                </div>

                <div class="block laptop:hidden bg-background rounded-lg p-4">
                    <div class="flex justify-between mb-4">
                        <div class="text-small font-normal">{{ \Carbon\Carbon::parse($order->dtPedido)->format('d/m/Y | H:i:s') }}</div>
                        <div class="flex flex-row items-center justify-center text-subtitle font-normal">
                            <div class="red-circle"></div>
                            {{ $order->statusPedido }}
                        </div>
                    </div>
                    <div class="text-small font-normal mb-4">
                        {{ $order->customer->nmCliente }}
                    </div>
                    <div class="text-small font-medium">
                        {{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}
                    </div>
                </div>
            @endforeach

            @foreach ($orders as $order)
                <div class="hidden laptop:grid grid-cols-4 sub-middle:grid-cols-6 laptop:grid-cols-4 middle:grid-cols-6 gap-x-1 bg-background rounded-lg items-center px-4 xl:px-8 py-4">
                    <!-- Data -->
                    <div class="col-span-1 sub-middle:col-span-2 laptop:col-span-1 middle:col-span-2 text-base xl:text-lg font-medium text-black w-full truncate">
                        {{ \Carbon\Carbon::parse($order->dtPedido)->format('d/m/Y | H:i:s') }}
                    </div>

                    <!-- Nome do cliente -->
                    <div class="col-span-1 sub-middle:col-span-2 laptop:col-span-1 middle:col-span-2 text-base xl:text-lg font-normal text-black w-full truncate">
                        {{ $order->customer->nmCliente }}
                    </div>

                    <!-- Status -->
                    <div class="flex flex-row items-center justify-center sub-middle:justify-start laptop:justify-center middle:justify-start col-span-1 text-base xl:text-lg font-normal text-black w-full truncate">
                        <div class="red-circle"></div>
                        {{ $order->statusPedido }}
                    </div>

                    <!-- Valor -->
                    <div class="col-span-1 text-base xl:text-lg font-medium text-black text-center sub-middle:text-start laptop:text-center middle:text-start w-full truncate">
                        {{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}
                    </div>
                </div>

                <div class="block laptop:hidden bg-background rounded-lg p-4">
                    <div class="flex justify-between mb-4">
                        <div class="text-small font-normal">{{ \Carbon\Carbon::parse($order->dtPedido)->format('d/m/Y | H:i:s') }}</div>
                        <div class="flex flex-row items-center justify-center text-subtitle font-normal">
                            <div class="red-circle"></div>
                            {{ $order->statusPedido }}
                        </div>
                    </div>
                    <div class="text-small font-normal mb-4">
                        {{ $order->customer->nmCliente }}
                    </div>
                    <div class="text-small font-medium">
                        {{ 'R$ ' . number_format($order->vrTotal, 2, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
