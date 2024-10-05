<div>
    @if ($message)
        <div x-init="setTimeout(() => { $wire.type === 'success' && $wire.close() }, 2000)" class="fixed inset-0 flex items-start justify-center pt-28 laptop:pt-20 bg-[#000000] bg-opacity-10 z-100">
            <div class="flex flex-row space-x-4 min-w-80 max-w-80 md:max-w-96 bg-white rounded-lg shadow-card p-4">
                <div>
                    @if ($type === 'success')
                        <svg class="size-8" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="6" fill="#56BA28"/>
                            <path d="M9.75 16.8665L12.3399 20.4138C13.1517 21.5256 14.8179 21.504 15.6006 20.3715L22.25 10.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @else
                        <svg class="size-8" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="32" height="32" rx="6" fill="#FF1F25"/>
                            <path d="M21.25 10.75L10.75 21.25M10.75 10.75L21.25 21.25" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                </div>
                <div>
                    <h5 class="text-black font-normal text-h5 mb-2">{{ $title }}</h5>
                    <p class="text-black font-normal text-subtitle">{{ $message }}</p>
                </div>
                <div>
                    <svg wire:click="close" class="fill-current size-5 text-black" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>{{ __('Close') }}</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </div>
            </div>
        </div>
    @endif
</div>
