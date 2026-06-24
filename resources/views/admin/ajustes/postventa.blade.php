<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Ajustes ✨</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <x-admin.settings.navigation></x-admin.settings.navigation>

                <div class="grow">
                    <div class="p-6 space-y-6">
                        @livewire('admin.ajustes.postventa.plantillas.index')
                        @livewire('admin.ajustes.postventa.plantillas.save')
                        @livewire('admin.ajustes.postventa.plantillas.edit')
                        @livewire('admin.ajustes.postventa.plantillas.delete')
                    </div>
                </div>

            </div>
        </div>

    </div>

</x-admin-layout>
