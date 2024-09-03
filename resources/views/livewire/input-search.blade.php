<div x-data="{ inputText: '' }" class="relative flex items-center justify-center">
    <input id="searchField" type="text" placeholder="{{ __('Search user') }}"
        wire:model.live.debounce.350ms="inputSearch"
        class="w-full border-line focus:border-primary focus:ring-primary rounded-lg shadow-sm h-12 text-center text-subtitle-color border-subtitle-color font-light"
        :class="inputText ? 'pl-3' : 'pl-3 md:pl-5 lg:pl-6 xl:pl-7 2xl:pl-9'"
        x-model="inputText" >

    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" :class="{ 'hidden': inputText }">
        <svg class="fill-current text-subtitle-color size-5 ms-2 sm:ms-4 md:ms-6 lg:ms-8 xl:ms-10 2xl:ms-12" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 4C7.13401 4 4 7.13401 4 11C4 14.866 7.13401 18 11 18C14.866 18 18 14.866 18 11C18 7.13401 14.866 4 11 4ZM2 11C2 6.02944 6.02944 2 11 2C15.9706 2 20 6.02944 20 11C20 15.9706 15.9706 20 11 20C6.02944 20 2 15.9706 2 11Z" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9429 15.9428C16.3334 15.5523 16.9666 15.5523 17.3571 15.9428L21.7071 20.2928C22.0976 20.6833 22.0976 21.3165 21.7071 21.707C21.3166 22.0975 20.6834 22.0975 20.2929 21.707L15.9429 17.357C15.5524 16.9665 15.5524 16.3333 15.9429 15.9428Z" />
        </svg>
    </div>
</div>
