<div {{ $attributes->merge(['class' => 'bg-white shadow-card rounded-lg h-20 md:h-28 p-4']) }}>
    <div class="flex flex-col-reverse md:flex-col">
        <h2 class="text-h2 font-medium text-black mb-2">{{ $slot }}</h2>
        <p class="text-normal font-normal text-black">{{ $title }}</p>
    </div>
</div>
