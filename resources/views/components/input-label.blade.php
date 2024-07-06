@props(['value', 'info'])

<div class="flex">
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>

    @if((bool)isset($info))
    <span class="flex items-center block font-medium text-xs text-sky-700 ms-2">
        {{ $info }}
    </span>
    @endif

</div>

