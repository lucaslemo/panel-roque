@props(['type' => 'received', 'user' => null, 'stage' => 0, 'data' => [], 'usersDefault' => [], 'loopLast' => false, 'audio' => null])

@if ($type === 'received')
    <div {{ $attributes->merge(['class' => 'flex items-center self-start max-w-lg laptop:max-w-2xl h-max bg-white laptop:bg-background rounded-lg py-3 pe-3 md:pe-5']) }}>

        @if (!is_null($audio))
            <button type="button" class="text-primary h-full px-3 md:px-4 transition ease-in-out duration-150 hover:text-primary-700 active:text-primary-500 focus:outline-none"
                x-data="{
                    audio: new Audio('{{ $audio }}'),
                    isPlaying: false,
                    isReady: false,
                    init() {
                        this.audio.preload = 'auto';
                        this.audio.addEventListener('canplaythrough', () => {
                            this.isReady = true;
                        });
                        this.audio.addEventListener('ended', () => {
                            this.isPlaying = false;
                            this.audio.currentTime = 0;
                        });
                    },
                    playAudio() {
                        if (this.audio.paused) {
                            this.audio.currentTime = 0;
                        }
                        if (this.isReady) {
                            this.audio.play();
                            this.isPlaying = true;
                        }
                    },
                    pauseAudio() {
                        this.audio.pause();
                        this.isPlaying = false;
                    },
                    toggleAudio() {
                        this.isPlaying ? this.pauseAudio() : this.playAudio();
                    }
                }"
                x-init="init()"
                x-on:click="toggleAudio">

                <!-- Ícone do áudio -->
                <svg x-show="!isPlaying" class="size-6 min-w-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4332 4.09871C11.7797 4.26523 12 4.6156 12 5.00001V19C12 19.3844 11.7797 19.7348 11.4332 19.9013C11.0867 20.0678 10.6755 20.021 10.3753 19.7809L5.64922 16H2C1.44772 16 1 15.5523 1 15V9.00001C1 8.44772 1.44772 8.00001 2 8.00001H5.64922L10.3753 4.21914C10.6755 3.979 11.0867 3.93219 11.4332 4.09871ZM10 7.08063L6.62469 9.78088C6.44738 9.92273 6.22707 10 6 10H3V14H6C6.22707 14 6.44738 14.0773 6.62469 14.2191L10 16.9194V7.08063Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.363 4.22247C18.7536 3.83201 19.3868 3.8321 19.7773 4.22269C21.8394 6.28549 22.9979 9.08288 22.9979 11.9997C22.9979 14.9165 21.8394 17.7139 19.7773 19.7767C19.3868 20.1673 18.7536 20.1674 18.363 19.7769C17.9725 19.3864 17.9724 18.7533 18.3628 18.3627C20.0501 16.6749 20.9979 14.3862 20.9979 11.9997C20.9979 9.61321 20.0501 7.32444 18.3628 5.63669C17.9724 5.2461 17.9725 4.61294 18.363 4.22247ZM14.833 7.75247C15.2236 7.36201 15.8568 7.3621 16.2473 7.75269C17.3721 8.87785 18.004 10.4037 18.004 11.9947C18.004 13.5857 17.3721 15.1115 16.2473 16.2367C15.8568 16.6273 15.2236 16.6274 14.833 16.2369C14.4425 15.8464 14.4424 15.2133 14.8328 14.8227C15.5827 14.0726 16.004 13.0553 16.004 11.9947C16.004 10.934 15.5827 9.9168 14.8328 9.16669C14.4424 8.7761 14.4425 8.14294 14.833 7.75247Z" />
                </svg>

                <!-- Ícone de pause -->
                <svg x-show="isPlaying" class="size-6 min-w-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 4C5 3.44772 5.44772 3 6 3H10C10.5523 3 11 3.44772 11 4V20C11 20.5523 10.5523 21 10 21H6C5.44772 21 5 20.5523 5 20V4ZM7 5V19H9V5H7Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 4C13 3.44772 13.4477 3 14 3H18C18.5523 3 19 3.44772 19 4V20C19 20.5523 18.5523 21 18 21H14C13.4477 21 13 20.5523 13 20V4ZM15 5V19H17V5H15Z" />
                </svg>
            </button>
        @else
            <button type="button" class="text-primary h-full px-3 md:px-4 transition ease-in-out duration-150 hover:text-primary-700 active:text-primary-500 focus:outline-none">
                <!-- Ícone do áudio -->
                <svg class="size-6 min-w-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4332 4.09871C11.7797 4.26523 12 4.6156 12 5.00001V19C12 19.3844 11.7797 19.7348 11.4332 19.9013C11.0867 20.0678 10.6755 20.021 10.3753 19.7809L5.64922 16H2C1.44772 16 1 15.5523 1 15V9.00001C1 8.44772 1.44772 8.00001 2 8.00001H5.64922L10.3753 4.21914C10.6755 3.979 11.0867 3.93219 11.4332 4.09871ZM10 7.08063L6.62469 9.78088C6.44738 9.92273 6.22707 10 6 10H3V14H6C6.22707 14 6.44738 14.0773 6.62469 14.2191L10 16.9194V7.08063Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.363 4.22247C18.7536 3.83201 19.3868 3.8321 19.7773 4.22269C21.8394 6.28549 22.9979 9.08288 22.9979 11.9997C22.9979 14.9165 21.8394 17.7139 19.7773 19.7767C19.3868 20.1673 18.7536 20.1674 18.363 19.7769C17.9725 19.3864 17.9724 18.7533 18.3628 18.3627C20.0501 16.6749 20.9979 14.3862 20.9979 11.9997C20.9979 9.61321 20.0501 7.32444 18.3628 5.63669C17.9724 5.2461 17.9725 4.61294 18.363 4.22247ZM14.833 7.75247C15.2236 7.36201 15.8568 7.3621 16.2473 7.75269C17.3721 8.87785 18.004 10.4037 18.004 11.9947C18.004 13.5857 17.3721 15.1115 16.2473 16.2367C15.8568 16.6273 15.2236 16.6274 14.833 16.2369C14.4425 15.8464 14.4424 15.2133 14.8328 14.8227C15.5827 14.0726 16.004 13.0553 16.004 11.9947C16.004 10.934 15.5827 9.9168 14.8328 9.16669C14.4424 8.7761 14.4425 8.14294 14.833 7.75247Z" />
                </svg>
            </button>
        @endif

        <!-- Texto da mensagem -->
        <p class="text-normal md:text-lg font-normal">
            {{ $slot }}
        </p>
    </div>
@elseif ($type === 'info')
    <div {{ $attributes->merge(['class' => 'self-start max-w-lg laptop:max-w-2xl h-max bg-white laptop:bg-background rounded-lg p-3 md:p-5']) }}>
        <!-- Título da informação -->
        <div class="flex justify-between items-center mb-3">
            <p class="text-normal font-medium">{{ $slot }}</p>

            <svg class="size-4 fill-primary" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.25 9C11.25 8.30964 10.6904 7.75 10 7.75C9.30964 7.75 8.75 8.30964 8.75 9H11.25ZM9.11612 10.8839C9.60427 11.372 10.3957 11.372 10.8839 10.8839L18.8388 2.92893C19.327 2.44078 19.327 1.64932 18.8388 1.16117C18.3507 0.67301 17.5592 0.67301 17.0711 1.16117L10 8.23223L2.92893 1.16117C2.44078 0.67301 1.64932 0.67301 1.16117 1.16117C0.67301 1.64932 0.67301 2.44078 1.16117 2.92893L9.11612 10.8839ZM8.75 9V10H11.25V9H8.75Z" />
            </svg>
        </div>
        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('Full name')</span>: {{ $user->name }}</p>
        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('Email')</span>: {{ $user->email }}</p>
        <p class="text-small font-normal mb-3"><span class="font-medium">@lang('Phone')</span>: {{ formatPhone($user->phone) }}</p>

        <!-- Botões de ação -->
        <div class="flex flex-row space-x-3 md:space-x-4">
            <div class="w-1/3">
                <x-secondary-button type="button" class="text-normal font-medium h-12" :disabled="$stage === 3 ? false : true"
                    x-on:click="$dispatch('open-modal-edit-customer-form') || $dispatch('open-modal', 'edit-customer-form')">

                    {{ __('Edit') }}
                </x-secondary-button>
            </div>
            <div class="w-2/3">
                <x-primary-button-custom type="button" class="text-normal font-medium text-nowrap h-12" :disabled="$stage === 3 ? false : true"
                    wire:click="confirmEdition">

                    {{ __('Confirm Data') }}
                </x-primary-button-custom>
            </div>
        </div>
    </div>
@elseif ($type === 'customer')
    <div {{ $attributes->merge(['class' => 'self-start max-w-lg laptop:max-w-2xl h-max bg-white laptop:bg-background rounded-lg p-3 md:p-5']) }}>
        <!-- Título da informação -->
        <p class="text-normal font-medium mb-3">{{ $slot }}</p>
        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('CNPJ/CPF')</span>: {{ $data['code'] }}</p>
    </div>
@elseif ($type === 'buttonNewUser')
    <!-- Botões de ação -->
    <div {{ $attributes->merge(['class' => 'self-start max-w-lg laptop:max-w-2xl h-max']) }}>
        <div class="flex flex-row space-x-4">
            <div class="w-28">
                <x-secondary-button type="button" class="text-normal font-medium h-12" :disabled="$stage === 4 && $loopLast ? false : true"
                    wire:click="finishChat">

                    {{ __('No') }}
                </x-secondary-button>
            </div>
            <div class="w-28">
                <x-primary-button-custom type="button" class="text-normal font-medium text-nowrap h-12" :disabled="$stage === 4 && $loopLast ? false : true"
                    x-on:click="$dispatch('open-modal-create-customer-form') || $dispatch('open-modal', 'create-customer-form')">

                    {{ __('Yes') }}
                </x-primary-button-custom>
            </div>
        </div>
    </div>
@elseif ($type === 'newUser')
    <div {{ $attributes->merge(['class' => 'self-start max-w-lg laptop:max-w-2xl h-max bg-white laptop:bg-background rounded-lg p-3 md:p-5']) }}>
        <!-- Título da informação -->
        <p class="text-normal font-medium mb-3">{{ $slot }}</p>

        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('Full name')</span>: {{ $usersDefault[$data['userId']]->name }}</p>
        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('Companies he will have access to')</span>:</p>
        <ul class="list-disc list-inside text-xs font-normal ms-2 mb-1">
            @forelse ($usersDefault[$data['userId']]->customers as $customer)
                <li>{{ $customer->nmCliente }}</li>
            @empty
                <p class="text-small font-normal">@lang('No companies were selected')</p>
            @endforelse
        </ul>
        <p class="text-small font-normal mb-1"><span class="font-medium">@lang('Phone')</span>: {{ formatPhone($usersDefault[$data['userId']]->phone) }}</p>
        <p class="text-small font-normal mb-3"><span class="font-medium">@lang('Email')</span>: {{ $usersDefault[$data['userId']]->email }}</p>

        <!-- Botão de ação -->
        <div class="w-1/3">
            <x-secondary-button type="button" class="text-normal font-medium h-12" :disabled="$stage === 4 ? false : true"
                x-on:click="$dispatch('open-modal-edit-customer-default-form', { id: {{ $usersDefault[$data['userId']]->id }} }) || $dispatch('open-modal', 'edit-customer-default-form')">

                {{ __('Edit') }}
            </x-secondary-button>
        </div>
    </div>
@elseif ($type === 'buttonAccess')
    <!-- Botões de ação -->
    <div {{ $attributes->merge(['class' => 'self-start w-full sm:w-min max-w-lg laptop:max-w-2xl h-max']) }}>
        <x-primary-button-custom type="button" class="text-normal font-medium text-nowrap h-12 px-0 sm:px-4" :disabled="$stage === 5 ? false : true"
            wire:click="openPortal">

            {{ __('Access the Customer Portal') }}
        </x-primary-button-custom>
    </div>
@elseif ($type === 'button')
    <div {{ $attributes->merge(['class' => "flex items-center justify-center self-end max-w-2xl h-max text-white rounded-lg py-3 px-5 bg-primary"]) }}>

        <!-- Texto da mensagem -->
        <p class="text-normal md:text-lg font-normal inline-block align-middle">
            {{ $slot }}
        </p>
    </div>
@elseif ($type === 'sent' || $type === 'error')
    <div {{ $attributes->merge(['class' => "flex items-center justify-center self-end max-w-2xl h-max text-white rounded-lg py-3 px-5 " . ($type === 'sent' ? "bg-primary" : "bg-danger")]) }}>
        <!-- Senha com máscara -->
        <p x-show="!visible" class="text-normal md:text-lg font-normal inline-block align-middle me-3 md:me-5">
            {{ Str::mask($slot, '*', 0) }}
        </p>

        <!-- Senha sem máscara -->
        <p x-show="visible" class="text-normal md:text-lg font-normal inline-block align-middle me-3 md:me-5">
            {{ $slot }}
        </p>

        <!-- Ícone de olho fechado -->
        <button x-on:click="visible = ! visible">
            <svg x-show="!visible" class="fill-white size-5 min-w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1_748)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9977 5.00002C11.3682 4.99854 10.7408 5.07025 10.1279 5.21371C9.59016 5.33958 9.05219 5.00569 8.92632 4.46794C8.80045 3.93019 9.13434 3.39222 9.67209 3.26634C10.4355 3.08765 11.2171 2.99828 12.0012 3.00003C12.0016 3.00003 12.002 3.00003 12.0023 3.00003L12 4.00003V3.00003C12.0004 3.00003 12.0008 3.00003 12.0012 3.00003C15.9001 3.00046 18.8957 5.22667 20.8545 7.31608C21.8432 8.37062 22.5979 9.42134 23.1057 10.2075C23.3601 10.6015 23.5542 10.9317 23.686 11.166C23.752 11.2833 23.8025 11.3767 23.8372 11.4425C23.8546 11.4753 23.8681 11.5013 23.8777 11.5198L23.889 11.5421L23.8925 11.5489L23.8936 11.5512C23.8938 11.5516 23.8944 11.5528 23 12L22.1181 11.5286C22.0338 11.6864 21.947 11.8428 21.858 11.9978C21.7488 11.8093 21.6044 11.5694 21.4256 11.2926C20.9646 10.5787 20.2818 9.62943 19.3955 8.68397C17.6045 6.77359 15.1005 5.00003 12 5.00003L11.9977 5.00002ZM21.858 11.9978C21.3406 12.8982 20.7439 13.7511 20.0748 14.5462C19.7193 14.9688 19.7736 15.5996 20.1962 15.9552C20.6187 16.3108 21.2496 16.2565 21.6052 15.8339C22.479 14.7953 23.2421 13.6684 23.8819 12.4714C24.0348 12.1854 24.0395 11.8429 23.8944 11.5528L23 12C22.1056 12.4472 22.1057 12.4475 22.1058 12.4478L22.1051 12.4464L22.099 12.4343C22.0929 12.4226 22.0831 12.4036 22.0695 12.3779C22.0423 12.3265 22 12.248 21.9429 12.1465C21.9175 12.1014 21.8892 12.0517 21.858 11.9978ZM5.4531 5.26525C5.85123 4.96123 6.41289 4.9987 6.76711 5.35292L10.5832 9.16899C10.5855 9.1713 10.5878 9.17361 10.5901 9.17594L14.824 13.4098C14.8264 13.4122 14.8287 13.4145 14.8311 13.4169L18.6471 17.2329C18.8511 17.4369 18.9571 17.7191 18.9378 18.007C18.9184 18.2949 18.7757 18.5604 18.5462 18.7353C16.6671 20.1677 14.3789 20.9613 12.0163 20.9999L12 21C8.10049 21 5.10448 18.7736 3.14546 16.684C2.15683 15.6294 1.40207 14.5787 0.894336 13.7926C0.63985 13.3985 0.445792 13.0684 0.313971 12.834C0.248023 12.7168 0.19754 12.6233 0.162753 12.5576C0.145357 12.5247 0.131875 12.4988 0.122338 12.4802L0.11099 12.458L0.107539 12.4512L0.10637 12.4488C0.106186 12.4485 0.105573 12.4472 1 12L0.105573 12.4472C-0.0397387 12.1566 -0.0347895 11.8135 0.118844 11.5272C1.43015 9.08345 3.24891 6.94839 5.4531 5.26525ZM2.14257 12.0032C2.25165 12.1916 2.39592 12.4311 2.57441 12.7075C3.03543 13.4213 3.71817 14.3706 4.60454 15.3161C6.39395 17.2248 8.89512 18.9969 11.9918 19C13.5373 18.9734 15.0437 18.5524 16.3714 17.7856L14.0497 15.464C13.891 15.5635 13.7251 15.652 13.5531 15.7286C13.0625 15.9472 12.5328 16.0648 11.9957 16.0742C11.4586 16.0837 10.9252 15.9849 10.4271 15.7837C9.92902 15.5826 9.47657 15.2831 9.09674 14.9033C8.71691 14.5235 8.41747 14.071 8.21629 13.5729C8.01511 13.0749 7.91631 12.5414 7.92579 12.0043C7.93527 11.4672 8.05282 10.9375 8.27145 10.4469C8.34805 10.2749 8.43652 10.109 8.53604 9.95028L5.9871 7.40134C4.45031 8.7014 3.14935 10.2582 2.14257 12.0032ZM10.0279 11.4421C9.96372 11.6346 9.92907 11.836 9.92548 12.0396C9.92074 12.3081 9.97014 12.5749 10.0707 12.8239C10.1713 13.0729 10.321 13.2992 10.511 13.4891C10.7009 13.679 10.9271 13.8287 11.1761 13.9293C11.4252 14.0299 11.6919 14.0793 11.9604 14.0745C12.164 14.071 12.3655 14.0363 12.5579 13.9721L10.0279 11.4421Z" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L23.7071 22.2929C24.0976 22.6834 24.0976 23.3166 23.7071 23.7071C23.3166 24.0976 22.6834 24.0976 22.2929 23.7071L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z" />
                </g>
                <defs>
                    <clipPath id="clip0_1_748">
                        <rect width="24" height="24" fill="white"/>
                    </clipPath>
                </defs>
            </svg>

            <!-- Ícone de olho aberto -->
            <svg x-show="visible" class="fill-white size-5 min-w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.14074 12C2.25003 12.1889 2.39492 12.4296 2.57441 12.7075C3.03543 13.4213 3.71817 14.3706 4.60454 15.3161C6.39552 17.2264 8.89951 19 12 19C15.1005 19 17.6045 17.2264 19.3955 15.3161C20.2818 14.3706 20.9646 13.4213 21.4256 12.7075C21.6051 12.4296 21.75 12.1889 21.8593 12C21.75 11.8111 21.6051 11.5704 21.4256 11.2925C20.9646 10.5787 20.2818 9.6294 19.3955 8.68394C17.6045 6.77356 15.1005 5 12 5C8.89951 5 6.39552 6.77356 4.60454 8.68394C3.71817 9.6294 3.03543 10.5787 2.57441 11.2925C2.39492 11.5704 2.25003 11.8111 2.14074 12ZM23 12C23.8944 11.5528 23.8943 11.5524 23.8941 11.5521L23.8925 11.5489L23.889 11.542L23.8777 11.5198C23.8681 11.5013 23.8546 11.4753 23.8372 11.4424C23.8025 11.3767 23.752 11.2832 23.686 11.166C23.5542 10.9316 23.3601 10.6015 23.1057 10.2075C22.5979 9.42131 21.8432 8.3706 20.8545 7.31606C18.8955 5.22644 15.8995 3 12 3C8.10049 3 5.10448 5.22644 3.14546 7.31606C2.15683 8.3706 1.40207 9.42131 0.894336 10.2075C0.63985 10.6015 0.445792 10.9316 0.313971 11.166C0.248023 11.2832 0.19754 11.3767 0.162753 11.4424C0.145357 11.4753 0.131875 11.5013 0.122338 11.5198L0.11099 11.542L0.107539 11.5489L0.10637 11.5512C0.106186 11.5516 0.105573 11.5528 1 12L0.105573 11.5528C-0.0351909 11.8343 -0.0351909 12.1657 0.105573 12.4472L1 12C0.105573 12.4472 0.105389 12.4468 0.105573 12.4472L0.107539 12.4511L0.11099 12.458L0.122338 12.4802C0.131875 12.4987 0.145357 12.5247 0.162753 12.5576C0.19754 12.6233 0.248023 12.7168 0.313971 12.834C0.445792 13.0684 0.63985 13.3985 0.894336 13.7925C1.40207 14.5787 2.15683 15.6294 3.14546 16.6839C5.10448 18.7736 8.10049 21 12 21C15.8995 21 18.8955 18.7736 20.8545 16.6839C21.8432 15.6294 22.5979 14.5787 23.1057 13.7925C23.3601 13.3985 23.5542 13.0684 23.686 12.834C23.752 12.7168 23.8025 12.6233 23.8372 12.5576C23.8546 12.5247 23.8681 12.4987 23.8777 12.4802L23.889 12.458L23.8925 12.4511L23.8936 12.4488C23.8938 12.4484 23.8944 12.4472 23 12ZM23 12L23.8944 12.4472C24.0352 12.1657 24.0348 11.8336 23.8941 11.5521L23 12Z" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10ZM8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12Z" />
            </svg>
        </button>
    </div>
@endif

