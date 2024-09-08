<x-admin-layout>
    <div class="py-12">

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

        {{--  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h2 class="font-semibold text-xl">{{ __('Active users') }}:</h2>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:admin.dashboard.users-last-activity-table />
            </div>
        </div> --}}
    </div>
</x-admin-layout>
