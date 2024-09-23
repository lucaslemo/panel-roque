@props(['values' => false])

<div {{ $attributes->merge(['class' => 'flex flex-row']) }}>
    {{ $content }}
</div>
