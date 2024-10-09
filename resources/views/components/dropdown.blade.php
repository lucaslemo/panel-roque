@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'full' => false])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
        break;
    case 'top':
        $alignmentClasses = 'bottom-full mb-2';
        break;
    case 'top-right':
        $alignmentClasses = 'bottom-full end-0 mb-2';
        break;
    case 'right':
    default:
        $alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';
        break;
}

switch ($width) {
    case '80':
        $width = 'w-80';
        break;
    case '72':
        $width = 'w-72';
        break;
    case '64':
        $width = 'w-64';
        break;
    case '60':
        $width = 'w-60';
        break;
    case '56':
        $width = 'w-56';
        break;
    case '52':
        $width = 'w-52';
        break;
    case '48':
        $width = 'w-48';
        break;
    case '40':
        $width = 'w-40';
        break;
    case '28':
        $width = 'w-28';
        break;
    case '24':
        $width = 'w-24';
        break;
    case '12':
    default:
        $width = 'w-12';
        break;
}
@endphp

<div class="relative {{ $full ? 'w-full' : ''}}" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div class="{{ $full ? 'w-full' : ''}}" @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $width }} rounded-lg shadow-button {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-lg ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
