<div x-data="{ inputText: '' }" class="relative w-full laptop:w-[328px] flex items-center justify-center">
    <input id="searchField" type="text" placeholder="" autocomplete="off"
        wire:model.live.debounce.350ms="inputSearch"
        class="w-full border-line focus:border-primary focus:ring-primary rounded-lg shadow-sm h-12 text-center text-subtitle-color border-subtitle-color font-light"
        :class="inputText ? 'pl-3' : 'pl-3'"
        x-model="inputText" >

    <div class="absolute inset-y-0 left-50 flex items-center pointer-events-none" :class="{ 'hidden': inputText }">
        <svg class="fill-current text-subtitle-color size-6 me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 4C7.13401 4 4 7.13401 4 11C4 14.866 7.13401 18 11 18C14.866 18 18 14.866 18 11C18 7.13401 14.866 4 11 4ZM2 11C2 6.02944 6.02944 2 11 2C15.9706 2 20 6.02944 20 11C20 15.9706 15.9706 20 11 20C6.02944 20 2 15.9706 2 11Z" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9429 15.9428C16.3334 15.5523 16.9666 15.5523 17.3571 15.9428L21.7071 20.2928C22.0976 20.6833 22.0976 21.3165 21.7071 21.707C21.3166 22.0975 20.6834 22.0975 20.2929 21.707L15.9429 17.357C15.5524 16.9665 15.5524 16.3333 15.9429 15.9428Z" />
        </svg>
        <div class="font-light text-lg text-subtitle-color">{{ __('Search user') }}</div>
    </div>
</div>
