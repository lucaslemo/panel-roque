@props(['title' => 'Modal', 'name', 'width' => null])

@php
    switch ($width) {
        case 'large':
            $width = 'max-w-xs md:max-w-xl laptop:max-w-[900px] 2xl:max-w-6xl';
            break;

        default:
            $width = 'max-w-xs md:max-w-lg laptop:max-w-4xl 2xl:max-w-5xl';
            break;
    }
@endphp

<!-- Overlay -->
<div class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 transition-opacity duration-300 ease-in-out"
    x-data="{ show: false, pulse: false }"
    x-show="show"
    x-init="$el.classList.remove('hidden')"
    x-on:click.self="pulse = true; setTimeout(() => pulse = false, 400)"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null">

    <!-- Modal -->
    <div class="bg-white rounded-lg shadow-modal p-6 laptop:p-12 max-h-[90vh] {{ $width }} overflow-y-auto w-full transform transition-all duration-300 ease-in-out"
        x-show="show"
        x-transition:enter="scale-90 opacity-0"
        x-transition:enter-start="scale-90 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="scale-100 opacity-100"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-90 opacity-0"
        x-bind:class="{ 'animate-pulse': pulse }"
        x-on:keydown.escape.window="show = false">

        <!-- Título do modal -->
        @if ($title && !empty($title))
            <h2 class="text-lg md:text-h5 font-medium mb-4 md:mb-6 laptop:mb-8">{{ $title }}</h2>
        @endif

        <!-- Conteúdo -->
        {{ $slot }}
    </div>
</div>
