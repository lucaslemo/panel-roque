<div>
    <!-- Overlay -->
    <div class="hidden fixed inset-0 flex items-center justify-center bg-[#000] bg-opacity-40 z-50 transition-opacity duration-300 ease-in-out"
        x-data="{ show: @entangle('showModal'), pulse: false }"
        x-show="show"
        x-init="$el.classList.remove('hidden')"
        @click.self="pulse = true; setTimeout(() => pulse = false, 400)">

        <!-- Modal -->
        <div class="bg-white rounded-lg shadow-modal p-6 laptop:p-12 max-h-[90vh] overflow-y-auto max-w-xs md:max-w-lg laptop:max-w-4xl 2xl:max-w-5xl w-full transform transition-all duration-300 ease-in-out"
            x-show="show"
            x-transition:enter="scale-90 opacity-0"
            x-transition:enter-start="scale-90 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="scale-100 opacity-100"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-90 opacity-0"
            :class="{ 'animate-pulse': pulse }"
            @keydown.escape.window="show ? $wire.closeModal() : null">

            <!-- Título do modal -->
            <h2 class="text-lg md:text-h5 font-medium mb-4 md:mb-6 laptop:mb-8">{{ __('Edit user') }}</h2>

            <!-- Formulário -->
            <livewire:edit-customer-form />
        </div>
    </div>
</div>
