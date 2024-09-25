<x-admin-layout>
    <div class="pb-12 pt-6">

        <!-- Cards -->
        <section class="flex flex-col laptop:flex-row justify-between mb-4 xl:mb-8">
            <livewire:users-cards />
            <div class="flex flex-col justify-between w-full laptop:w-[328px] mt-4 laptop:mt-0 ms-0 laptop:ms-4">

                <!-- Botão e modal para novo usuário -->
                <livewire:create-user-modal />

                <!-- Busca de usuários -->
                <livewire:input-search />
            </div>
        </section>

        <!-- Datatable -->
        <section>
            <livewire:users-datatable lazy="on-load" />
        </section>

    </div>
</x-admin-layout>
