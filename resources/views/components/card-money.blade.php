<div {{ $attributes->merge(['class' => 'bg-white shadow-card rounded-lg h-24 md:h-28 p-4 md:p-6']) }}>
    <div class="flex justify-center md:justify-between flex-col h-full">
        <p class="text-small md:text-lg font-normal text-black mb-2 md:mb-0">{{ $title }}</p>
        <h2 class="text-lg md:text-2xl leading-none font-normal text-black text-nowrap">{{ $slot }}</h2>
    </div>
</div>
