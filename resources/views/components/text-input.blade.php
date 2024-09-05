@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-border-color focus:border-primary focus:ring-primary rounded-lg shadow-sm h-12']) !!}>
