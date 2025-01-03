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
            border: 0.03rem solid #000000;
            padding: 1rem;
            margin-bottom: 1rem;
          }

          .title {
            font-size: 1.25rem;
            line-height: 1.75rem;
            font-weight: 700;
          }

          .subtitle {
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
          }

          .reverse-text {
            font-size: 0.75rem;
            line-height: 1rem;
            text-align: right;
          }

          .header-line {
            font-size: 0.875rem;
            line-height: 1.25rem; 
          }

          .header-line span {
            font-weight: 600;
          }

          .table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 0px 0px;
            text-align: center;
            border: 0.03rem solid #000000;
            font-size: 0.75rem;
            line-height: 1rem;
            margin-bottom: 1rem; 
          }

          .table thead tr th {
            font-weight: 700;
            text-wrap: nowrap;
          }

          .table-col-default {
            width: 10%;
          }
          .table-col-2 {
            width: 30%;
          }

          .table thead tr,
          .table tbody tr {
            border-bottom: 0.03rem solid #000000;
          }

          .table thead tr th,
          .table tbody tr td{
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            border-left: 0.03rem solid #000000;
          }

          .table thead tr th:first-child,
          .table tbody tr td:first-child {
            border-left: none;
          }

          .table tbody tr:last-child {
            border-bottom: none;
          }

          .footer {
            border: 0.03rem solid #000000;
            padding: 1rem;
          }

          .totals {
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
          }

          .footer-line {
            font-size: 0.875rem;
            line-height: 1.25rem; 
          }

          .footer-line span {
            font-weight: 600;
          }

          .footer-total {
            font-size: 1rem;
            line-height: 1.5rem;
            font-weight: 600;
          }
        </style>
    </head>
    <body>
        <!-- Page Content -->
        <main>
          <div class="header">
            <div class="title">Roque - Portal do cliente</div>
            <div class="subtitle">Pedido N° {{ $order->extPedido }}</div>
            <div class="header-line"><span>NOME / RAZÃO SOCIAL:</span> {{ $order->customer->nmCliente }}</div>
            <div class="header-line"><span>CNPJ / CPF:</span> {{ formatCnpjCpf($order->customer->codCliente) }}</div>
            <div class="header-line"><span>DATA DO PEDIDO:</span> {{ $order->dtPedido->format('d/m/Y H:i:s') }}</div>
            <div class="header-line"><span>RCA:</span> {{ $order->nmVendedor }}</div>
            <div class="reverse-text">DOCUMENTO SEM VALOR FISCAL</div>
          </div>
          <table class="table">
              <thead>
                <tr>
                  <th class="table-col-default">CÓDIGO</th>
                  <th class="table-col-2">DESCRIÇÃO DO PRODUTO</th>
                  <th class="table-col-default">QUANT</th>
                  <th class="table-col-default">UN</th>
                  <th class="table-col-default">VL TAB</th>
                  <th class="table-col-default">VL DESC</th>
                  <th class="table-col-default">VL UNIT</th>
                  <th class="table-col-default">VL TOTAL</th>
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
          <div class="footer">
            <div class="totals">Totais:</div>
            <div class="footer-line"><span>Valor Total Tabela:</span> {{ number_format($order->vrBruto, 2, ',', '.') }}</div>
            <div class="footer-line"><span>Total Itens:</span> {{ count($order->orderDetails) }}</div>
            <div class="footer-line"><span>Valor Frete:</span> {{ number_format($order->vrFrete, 2, ',', '.') }}</div>
            <div class="footer-total">Valor Total Líquido: {{ number_format($order->vrTotal, 2, ',', '.') }}</div>
            <div class="reverse-text">Emitido em: {{ now()->format('d/m/Y H:i:s') }}</div>
          </div>
        </main>
    </body>
</html>