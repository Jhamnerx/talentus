<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Ajustes ✨</h1>

        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->

                <x-admin.settings.navigation></x-admin.settings.navigation>

                <div class="grow">
                    <div>
                        <!-- Page content -->
                        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-slate-50 dark:bg-gray-900">

                            <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white dark:bg-gray-800 px-3 mb-2">

                                @livewire('admin.ajustes.sunat.datos', ['plantilla' => $plantilla], key('dat' . $plantilla->id))

                            </div>

                            <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white dark:bg-gray-800 px-3 mb-2">

                                @livewire('admin.ajustes.sunat.certificado', ['plantilla' => $plantilla], key('cdt' . $plantilla->id))
                                @livewire('admin.ajustes.sunat.certificado-pem', ['plantilla' => $plantilla], key('cdt' . $plantilla->id))

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
