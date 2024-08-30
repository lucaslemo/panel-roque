@props(['value', 'info'])

<div class="flex">
    <label {{ $attributes->merge(['class' => 'block font-light text-base text-subtitle mb-0.5']) }}>
        {{ $value ?? $slot }}
    </label>

    @if((bool)isset($info))
    <span class="flex items-center block font-light text-xs text-sky-700 ms-2">
        {{ $info }}
    </span>
    @endif

</div>

