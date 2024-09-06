<button {{ $attributes->merge(['type' => 'button', 'class' => 'w-full h-12 flex justify-center items-center bg-white shadow-button border border-primary rounded-lg text-normal md:text-lg text-primary text-center hover:bg-primary-100 focus:bg-primary-300 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-800 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
