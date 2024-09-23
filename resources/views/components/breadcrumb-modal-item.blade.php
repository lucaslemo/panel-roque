@props(['active' => false, 'tail' => true])

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <div class="flex justify-center items-center bg-primary {{ $active ? 'bg-primary' : 'bg-white' }} border-2 border-primary rounded-full size-10 min-w-10">
        <svg class="{{ $active ? 'fill-white' : 'fill-primary' }} size-4" viewBox="0 0 18 13" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7071 0.292893C18.0976 0.683417 18.0976 1.31658 17.7071 1.70711L6.70711 12.7071C6.31658 13.0976 5.68342 13.0976 5.29289 12.7071L0.292893 7.70711C-0.0976311 7.31658 -0.0976311 6.68342 0.292893 6.29289C0.683417 5.90237 1.31658 5.90237 1.70711 6.29289L6 10.5858L16.2929 0.292893C16.6834 -0.0976311 17.3166 -0.0976311 17.7071 0.292893Z" />
        </svg>
    </div>
    <div class="h-0.5 w-4 min-w-4 bg-primary"></div>
    <span class="text-nowrap mx-2 text-lg font-medium">{{ $slot }}</span>
    @if ($tail)
        <div class="h-0.5 w-full bg-primary"></div>
    @endif
</div>
