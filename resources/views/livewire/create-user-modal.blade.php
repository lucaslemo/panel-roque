<div>
    <!-- Overlay -->
    <div class="hidden fixed inset-0 flex items-center justify-center bg-[#000] bg-opacity-40 z-50 transition-opacity duration-300 ease-in-out" 
        x-data="{ show: @entangle('showModal'), pulse: false }"
        x-show="show"
        x-init="$el.classList.remove('hidden')"
        @click.self="pulse = true; setTimeout(() => pulse = false, 400)">

        <!-- Modal -->
        <div class="bg-white rounded-lg shadow-modal p-6 max-w-4xl w-full transform transition-all duration-300 ease-in-out"
            x-show="show"
            x-transition:enter="scale-90 opacity-0" 
            x-transition:enter-start="scale-90 opacity-0" 
            x-transition:enter-end="scale-100 opacity-100" 
            x-transition:leave="scale-100 opacity-100" 
            x-transition:leave-start="scale-100 opacity-100" 
            x-transition:leave-end="scale-90 opacity-0"
            :class="{ 'animate-pulse': pulse }">
            
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="text-xl font-semibold">Título do Modal</h2>
                <button class="text-gray-500 hover:text-gray-700" wire:click="closeModal">✖</button>
            </div>
            <div class="mt-4">
                <p>Este é o conteúdo do modal.</p>
            </div>
            <div class="mt-6 flex justify-end">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" wire:click="closeModal">Fechar</button>
            </div>
        </div>
    </div>
    <x-secondary-button wire:click="openModal" type="button" class="w-full font-medium mb-4 md:mb-0">
        <svg class="fill-current size-4 me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C12.5523 4 13 4.44772 13 5V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V5C11 4.44772 11.4477 4 12 4Z" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12Z" />
        </svg>
        {{ __('Register new user') }}
    </x-secondary-button>
</div>

