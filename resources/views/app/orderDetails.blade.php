<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('build/assets/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('build/assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('build/assets/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('build/assets/favicon/site.webmanifest') }}">

        <style>
          .header {
            border-style: solid;
            border-width: 1px;
            padding: 1rem;
          }

          .title {
            font-size: 2.25rem;
            line-height: 2.5rem;
          }
        </style>
    </head>
    <body>
        <!-- Page Content -->
        <main>
          <div class="header">
            <div class="title">Roque - Portal do cliente</div>
            <div>Pedido N° {{ $order->extPedido }}</div>
            <div><span>NOME / RAZÃO SOCIAL:</span> {{ $order->customer->nmCliente }}</div>
            <div><span>CNPJ / CPF:</span> {{ formatCnpjCpf($order->customer->codCliente) }}</div>
            <div><span>DATA DO PEDIDO:</span> {{ $order->dtPedido->format('d/m/Y H:i:s') }}</div>
            <div><span>RCA:</span> {{ $order->nmVendedor }}</div>
            <div style="text-align: end;"><span>DOCUMENTO SEM VALOR FISCAL</div>
          </div>
          <table>
              <thead>
                <tr>
                  <th>CÓDIGO</th>
                  <th>DESCRIÇÃO DO PRODUTO</th>
                  <th>QUANT</th>
                  <th>UN</th>
                  <th>VL TAB</th>
                  <th>VL DESC</th>
                  <th>VL UNIT</th>
                  <th>VL TOTAL</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->orderDetails as $orderDetail)
                  <tr>
                    <td>{{ $orderDetail->codProduto }}</td>
                    <td>{{ $orderDetail->nmProduto }}</td>
                    <td>{{ $orderDetail->qtdProduto }}</td>
                    <td>{{ $orderDetail->cdUnidade }}</td>
                    <td>{{ number_format($orderDetail->vrTabela, 2, ',', '.') }}</td>
                    <td>{{ number_format($orderDetail->vrDesconto, 2, ',', '.') }}</td>
                    <td>{{ number_format($orderDetail->vrProduto, 2, ',', '.') }}</td>
                    <td>{{ number_format($orderDetail->vrTotal, 2, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
          <div>
            <div>Totais:</div>
            <div>Valor Total Tabela: <span>{{ number_format($order->vrBruto, 2, ',', '.') }}</span></div>
            <div>Total Itens: <span>{{ count($order->orderDetails) }}</span></div>
            <div>Valor Frete: <span>{{ number_format($order->vrFrete, 2, ',', '.') }}</span></div>
            <div>Valor Total Líquido: <span>{{ number_format($order->vrTotal, 2, ',', '.') }}</span></div>
          </div>
        </main>
    </body>
</html>