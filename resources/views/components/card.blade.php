<div {{ $attributes->merge(['class' => 'bg-white shadow-card rounded-lg h-24 md:h-28 p-4 md:p-6']) }}>
    <div class="flex justify-between flex-col-reverse laptop:flex-col h-full">
        <h2 class="text-h4 md:text-h2 font-medium text-black">{{ $slot }}</h2>
        <p class="text-normal font-medium text-black">{{ $title }}</p>
    </div>
</div>
