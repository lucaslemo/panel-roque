@props(['active' => false, 'customer' => '', 'code' => ''])

@php
    $class = $active
        ? 'text-white bg-primary hover:bg-primary-900 focus:bg-primary-800 active:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150'
        : 'text-primary bg-white hover:bg-primary-100 focus:bg-primary-300 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-800 focus:ring-offset-2 transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => 'justify-self-center text-left w-96 rounded-lg border border-primary shadow-picker p-8 ' . $class]) }}>
    <p class="text-normal font-medium mb-2">{{ $customer }}</p>
    <p class="text-normal font-normal">{{ __('CNPJ/CPF') }}: {{ $code }}</p>
</button>
