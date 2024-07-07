<div {{ $attributes->merge(['class' => 'flex flex-col bg-white p-4 overflow-hidden shadow-sm rounded-lg w-full']) }}>
    <div class="font-semibold text-md">{{ $title }}:</div>
    <div class="grid justify-items-stretch">
        <div class="font-bold text-2xl justify-self-end">
            {{ $slot }}
        </div>
    </div>
</div>
