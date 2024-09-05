<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full h-12 flex justify-center items-center bg-primary shadow-button border border-transparent rounded-lg font-medium text:normal md:text-lg text-white text-center hover:bg-primary-900 focus:bg-primary-600 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
