@props(['disabled' => false])

@php
    $class = $disabled ? 'bg-primary-800 cursor-not-allowed' : 'bg-primary hover:bg-primary-900 focus:bg-primary-600 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge(['disabled' => $disabled, 'type' => 'submit', 'class' => 'w-full h-12 flex justify-center items-center shadow-button border border-transparent rounded-lg text-white text-center ' . $class]) }}>
    {{ $slot }}
</button>
