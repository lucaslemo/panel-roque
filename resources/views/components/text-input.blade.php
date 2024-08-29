@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary-action focus:ring-primary-action rounded-md shadow-sm']) !!}>
