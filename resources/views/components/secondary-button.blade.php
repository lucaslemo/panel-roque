@props(['disabled' => false])

@php
    $class = $disabled ? 'bg-primary-100 cursor-not-allowed' : 'bg-white hover:bg-primary-100 focus:bg-primary-300 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-800 focus:ring-offset-2 transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge(['disabled' => $disabled, 'type' => 'button', 'class' => 'w-full h-12 flex justify-center items-center shadow-button border border-primary rounded-lg text-primary text-center ' . $class]) }}>
    {{ $slot }}
</button>
