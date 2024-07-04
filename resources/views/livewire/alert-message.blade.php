<div>
    @if ($message)
        <div class="bg-{{ $color }}-100 border-t-4 border-{{ $color }}-500 rounded-b text-{{ $color }}-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex justify-between">
                <div class="flex">
                    <div class="py-">
                        @if ($color === 'teal')
                            <svg class="fill-current h-6 w-6 text-{{ $color }}-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/>
                            </svg>
                        @elseif($color === 'red')
                            <svg class="fill-current h-6 w-6 text-{{ $color }}-500 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold">{{ $title }}</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>

                <span class="top-0 bottom-0 right-0 px-4 py-3">
                    <svg wire:click="close" class="fill-current h-6 w-6 text-{{ $color }}-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>{{ __('Close') }}</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        </div>
    @endif
</div>
