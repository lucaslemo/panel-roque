<x-app-layout>

    <!-- Modal -->
    <x-modal-panel title="" name="pre-order" width='large'>
        <div class="flex justify-end -mt-2 laptop:-mt-8 mb-4">
            <button class="bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                x-on:click="$dispatch('close-modal', 'pre-order')">

                <!-- Ícone de X -->
                <svg class="size-4 laptop:size-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.43884 0.418419C1.88095 -0.139473 0.976437 -0.139473 0.418549 0.418418C-0.139339 0.97631 -0.139339 1.88083 0.418549 2.43872L7.9797 9.99993L0.418416 17.5613C-0.139472 18.1192 -0.139472 19.0237 0.418416 19.5816C0.976304 20.1395 1.88082 20.1395 2.43871 19.5816L9.99999 12.0202L17.5613 19.5816C18.1192 20.1395 19.0237 20.1395 19.5816 19.5816C20.1395 19.0237 20.1395 18.1192 19.5816 17.5613L12.0203 9.99993L19.5814 2.43872C20.1393 1.88083 20.1393 0.976312 19.5814 0.41842C19.0236 -0.139471 18.119 -0.139471 17.5612 0.41842L10 7.97962L2.43884 0.418419Z" fill="#022266"/>
                </svg>
            </button>
        </div>
        <livewire:modal-orders-reserved />
    </x-modal-panel>

    <!-- Modal para visualizar um pedido -->
    <x-modal-panel title="" name="product-detail" width="large">
        <div class="flex justify-end -mt-2 laptop:-mt-8 mb-2">
            <button class="bg-transparent rounded-lg p-2 hover:bg-primary-100 active:bg-primary-200 focus:outline-none transition ease-in-out duration-150"
                x-on:click="$dispatch('close-modal', 'product-detail')">
                <svg class="size-4 laptop:size-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.43884 0.418419C1.88095 -0.139473 0.976437 -0.139473 0.418549 0.418418C-0.139339 0.97631 -0.139339 1.88083 0.418549 2.43872L7.9797 9.99993L0.418416 17.5613C-0.139472 18.1192 -0.139472 19.0237 0.418416 19.5816C0.976304 20.1395 1.88082 20.1395 2.43871 19.5816L9.99999 12.0202L17.5613 19.5816C18.1192 20.1395 19.0237 20.1395 19.5816 19.5816C20.1395 19.0237 20.1395 18.1192 19.5816 17.5613L12.0203 9.99993L19.5814 2.43872C20.1393 1.88083 20.1393 0.976312 19.5814 0.41842C19.0236 -0.139471 18.119 -0.139471 17.5612 0.41842L10 7.97962L2.43884 0.418419Z" fill="#022266"/>
                </svg>
            </button>
        </div>
        <livewire:modal-order-detail lazy="on-load" />
    </x-modal-panel>

    <!-- Cartões -->
    <livewire:credit-limit-cards lazy="on-load" />

    <div class="grid grid-cols-1 auto-rows-min md:grid-cols-2 laptop:grid-cols-4 gap-y-8 gap-x-4 laptop:gap-x-8 mt-8 w-full">
        <!-- Contas -->
        <div class="w-full h-full col-span-1 row-span-1 md:col-span-2 laptop:row-span-3 laptop:col-span-3">
            <livewire:last-orders-dashboard lazy="on-load"/>
        </div>

        <!-- Redes sociais -->
        <div class="col-span-1 row-span-1 laptop:row-span-3 h-max">
            <div class="flex flex-col justify-around h-44 xl:h-52 bg-white rounded-lg shadow-card p-4 md:p-6">

                <!-- Nossas Redes Sociais -->
                <p class="text-lg laptop:text-base xl:text-lg font-normal text-nowrap">{{ __('Our Social Networks') }}</p>

                <!-- Linha amarela -->
                <div class="h-0.5 w-full bg-secondary"></div>

                <!-- Links -->
                <div class="flex justify-around">
                    <!-- Instagram -->
                    <x-footer-link class="size-[51px] laptop:size-[40px] xl:size-[51px]" href="https://www.instagram.com/roquematcon?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                        <svg class="size-6 laptop:size-4 xl:size-6 fill-border-color group-hover:fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.16215C15.2041 2.16215 15.5837 2.17439 16.849 2.23212C18.019 2.28547 18.6544 2.48096 19.0773 2.6453C19.6374 2.86299 20.0371 3.12302 20.457 3.54291C20.877 3.96286 21.137 4.3626 21.3547 4.92273C21.519 5.34557 21.7145 5.98096 21.7679 7.15095C21.8256 8.41629 21.8378 8.79584 21.8378 11.9999C21.8378 15.2041 21.8256 15.5836 21.7679 16.849C21.7145 18.019 21.519 18.6543 21.3547 19.0772C21.137 19.6373 20.877 20.0371 20.4571 20.457C20.0371 20.8769 19.6374 21.1369 19.0773 21.3546C18.6544 21.519 18.019 21.7144 16.849 21.7678C15.5839 21.8255 15.2044 21.8378 12 21.8378C8.79563 21.8378 8.41618 21.8255 7.15097 21.7678C5.98098 21.7144 5.34559 21.519 4.92274 21.3546C4.36261 21.1369 3.96287 20.8769 3.54297 20.457C3.12308 20.0371 2.863 19.6373 2.64531 19.0772C2.48097 18.6543 2.28548 18.019 2.23213 16.849C2.1744 15.5836 2.16216 15.2041 2.16216 11.9999C2.16216 8.79584 2.1744 8.41629 2.23213 7.15095C2.28548 5.98096 2.48097 5.34557 2.64531 4.92273C2.863 4.3626 3.12303 3.96286 3.54297 3.54296C3.96287 3.12302 4.36261 2.86299 4.92274 2.6453C5.34559 2.48096 5.98098 2.28547 7.15097 2.23212C8.41632 2.17439 8.79587 2.16215 12 2.16215ZM12 0C8.741 0 8.33234 0.0138138 7.05241 0.072213C5.77516 0.130469 4.90283 0.333342 4.13954 0.629958C3.35044 0.936626 2.68123 1.34694 2.01406 2.01406C1.34695 2.68122 0.936629 3.35043 0.630008 4.13953C0.333343 4.90282 0.13047 5.77514 0.0722133 7.05239C0.0138139 8.33231 0 8.74096 0 11.9999C0 15.259 0.0138139 15.6676 0.0722133 16.9475C0.13047 18.2248 0.333343 19.0971 0.630008 19.8604C0.936629 20.6495 1.34695 21.3187 2.01406 21.9859C2.68123 22.653 3.35044 23.0633 4.13954 23.3699C4.90283 23.6666 5.77516 23.8694 7.05241 23.9277C8.33234 23.9861 8.741 23.9999 12 23.9999C15.259 23.9999 15.6677 23.9861 16.9476 23.9277C18.2248 23.8694 19.0972 23.6666 19.8605 23.3699C20.6496 23.0633 21.3188 22.653 21.9859 21.9859C22.653 21.3187 23.0634 20.6495 23.37 19.8604C23.6667 19.0971 23.8695 18.2248 23.9278 16.9475C23.9862 15.6676 24 15.259 24 11.9999C24 8.74096 23.9862 8.33231 23.9278 7.05239C23.8695 5.77514 23.6667 4.90282 23.37 4.13953C23.0634 3.35043 22.653 2.68122 21.9859 2.01406C21.3188 1.34694 20.6496 0.936626 19.8605 0.629958C19.0972 0.333342 18.2248 0.130469 16.9476 0.072213C15.6677 0.0138138 15.259 0 12 0Z" />
                            <path d="M12.0057 5.84338C8.60238 5.84338 5.84351 8.60225 5.84351 12.0055C5.84351 15.4088 8.60238 18.1677 12.0057 18.1677C15.409 18.1677 18.1678 15.4088 18.1678 12.0055C18.1678 8.60225 15.409 5.84338 12.0057 5.84338ZM12.0057 16.0055C9.79651 16.0055 8.00566 14.2147 8.00566 12.0055C8.00566 9.79638 9.79651 8.00553 12.0057 8.00553C14.2148 8.00553 16.0057 9.79638 16.0057 12.0055C16.0057 14.2147 14.2148 16.0055 12.0057 16.0055Z" />
                            <path d="M19.8507 5.59615C19.8507 6.3914 19.206 7.03613 18.4107 7.03613C17.6154 7.03613 16.9707 6.3914 16.9707 5.59615C16.9707 4.80085 17.6154 4.15613 18.4107 4.15613C19.206 4.15613 19.8507 4.80085 19.8507 5.59615Z" />
                        </svg>
                    </x-footer-link>

                    <!-- Facebook -->
                    <x-footer-link class="size-[51px] laptop:size-[40px] xl:size-[51px]" href="https://www.facebook.com/roqueac">
                        <svg class="size-6 laptop:size-4 xl:size-6 fill-border-color group-hover:fill-white" viewBox="0 0 11 22" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.315 3.9578C9.6917 3.83314 8.84983 3.74 8.32037 3.74C6.8867 3.74 6.79358 4.36333 6.79358 5.36066V7.13607H10.3774L10.065 10.8137H6.79358V22H2.30632V10.8137H0L0 7.13607H2.30632V4.86127C2.30632 1.74533 3.77079 0 7.44771 0C8.72517 0 9.66017 0.187001 10.8753 0.436334L10.315 3.9578Z" />
                        </svg>
                    </x-footer-link>

                    <!-- Youtube -->
                    <x-footer-link class="size-[51px] laptop:size-[40px] xl:size-[51px]" href="https://www.youtube.com/@RoqueMatconEstrutural">
                        <svg class="size-6 laptop:size-4 xl:size-6 fill-border-color group-hover:fill-white" viewBox="0 0 26 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.3005 1.37807C24.6996 1.77717 24.9872 2.27386 25.1346 2.81868C25.9835 6.23572 25.7873 11.6324 25.1511 15.1813C25.0037 15.7261 24.7161 16.2228 24.317 16.6219C23.9179 17.021 23.4212 17.3086 22.8764 17.456C20.8819 18 12.8544 18 12.8544 18C12.8544 18 4.82691 18 2.8324 17.456C2.28759 17.3086 1.79089 17.021 1.39179 16.6219C0.992691 16.2228 0.705107 15.7261 0.557679 15.1813C-0.296167 11.7791 -0.0620999 6.37912 0.541197 2.83517C0.688622 2.29035 0.976206 1.79365 1.37531 1.39455C1.77441 0.99545 2.2711 0.707864 2.81592 0.560444C4.81043 0.0164795 12.8379 0 12.8379 0C12.8379 0 20.8654 0 22.8599 0.543954C23.4047 0.691384 23.9014 0.97897 24.3005 1.37807ZM16.9423 8.99999L10.283 12.8571V5.14285L16.9423 8.99999Z" />
                        </svg>
                    </x-footer-link>

                    <!-- LinkedIn -->
                    <x-footer-link class="size-[51px] laptop:size-[40px] xl:size-[51px]" href="https://www.linkedin.com/company/roque-a-o-e-cimento/">
                        <svg class="size-6 laptop:size-4 xl:size-6 fill-border-color group-hover:fill-white" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.77475 2.28389C4.77475 3.52898 3.82671 4.5366 2.34415 4.5366C0.919355 4.5366 -0.0286772 3.52898 0.000662254 2.28389C-0.0286772 0.978283 0.919332 0 2.37255 0C3.82669 0 4.74633 0.978283 4.77475 2.28389ZM0.119858 20.8191V6.31621H4.62712V20.8181H0.119858V20.8191Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.2398 10.9441C8.2398 9.13517 8.1802 7.59301 8.12061 6.31767H12.0356L12.2437 8.3045H12.3326C12.9259 7.38489 14.4084 5.99219 16.8106 5.99219C19.7757 5.99219 22 7.94968 22 12.2186V20.8205H17.4927V12.7833C17.4927 10.9139 16.8408 9.63944 15.2098 9.63944C13.9637 9.63944 13.2229 10.4995 12.9268 11.3292C12.8076 11.6263 12.7489 12.0407 12.7489 12.4569V20.8205H8.24162V10.9441H8.2398Z" />
                        </svg>
                    </x-footer-link>
                </div>
            </div>

            <!-- Add desktop -->
            <div class="hidden laptop:block w-full overflow-hidden mt-8">
                <div class="flex flex-row transition-transform duration-500 container-instagram">

                    <!-- Loading (Desabilita quando as imagens são carregadas) -->
                    <span class="mx-auto"><x-spinner /></span>
                </div>
            </div>
        </div>

        <!-- Add mobile -->
        <div class="block laptop:hidden col-span-1 row-span-1 laptop:row-span-2 w-full overflow-hidden">
            <div class="flex flex-row transition-transform duration-500 container-instagram">

                <!-- Loading (Desabilita quando as imagens são carregadas) -->
                <span class="mx-auto"><x-spinner /></span>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        // Guarda os index das imagens atuais
        var currentIndex = [0, 0];

        // Carrega as imagens do Instagram 
        if (document.readyState !== 'loading') {
            loadImages();
        } else {
            document.addEventListener("DOMContentLoaded", function(event) {
                loadImages();
            });
        }

        function updateCarousel() {
            const containers = document.getElementsByClassName("container-instagram");

            for (let i = 0; i < containers.length; i++) {
                const images = containers[i].querySelectorAll("img");
                const totalImages = images.length;
                const imageWidth = images[currentIndex[i]]?.offsetWidth;

                currentIndex[i] = (currentIndex[i] + 1) % totalImages;
                const offset = -currentIndex[i] * imageWidth;
                containers[i].style.transform = `translateX(${offset}px)`;
            }
        }

        function loadImages() {
            const url = "{{ route('app.instagramLatestImages') }}";

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    const containers = document.getElementsByClassName("container-instagram");
                    const response = JSON.parse(xmlHttp.response);

                    for (let i = 0; i < containers.length; i++) {
                        containers[i].replaceChildren();

                        response.forEach(media => {
                            const aElement = document.createElement("a");
                            const imgElement = document.createElement("img");
    
                            aElement.setAttribute("target", "_blank");
                            aElement.setAttribute("class", "flex justify-center items-center min-w-full");
                            aElement.setAttribute("href", `https://instagram.com/p/${media.shortcode}`);
    
                            imgElement.setAttribute("src", media.media_url);
                            imgElement.setAttribute("class", "w-full h-auto rounded-lg shadow-card");
                            imgElement.setAttribute("alt", "Post do Instagram");
    
                            aElement.appendChild(imgElement);
                            containers[i].appendChild(aElement);
                        });
                    }

                    if (!window.intervalId) {
                        window.intervalId = setInterval(updateCarousel, 5000);
                    }
                } else if(xmlHttp.readyState == 4) {
                    const containers = document.getElementsByClassName("container-instagram");
                    
                    
                    for (let i = 0; i < containers.length; i++) {
                        containers[i].replaceChildren();

                        const aElement = document.createElement("a");
                        const imgElement = document.createElement("img");
                        
                        aElement.setAttribute("target", "_blank");
                        aElement.setAttribute("href", "https://www.instagram.com/roquematcon");
    
                        imgElement.setAttribute("class", "w-full h-auto rounded-lg shadow-card");
                        imgElement.setAttribute("alt", "Posts do Instagram");
    
                        aElement.appendChild(imgElement);
                        containers[i].appendChild(aElement);
                    }
                }
            }

            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }
    </script>
</x-app-layout>
