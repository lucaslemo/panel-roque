<a {{ $attributes->merge(['target' => '_blank', 'class' => 'flex justify-center items-center size-[51px] border border-border-color rounded-full bg-transparent group cursor-pointer hover:bg-secondary hover:border-secondary transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
