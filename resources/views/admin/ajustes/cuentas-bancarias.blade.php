<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Ajustes ✨</h1>

        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->
                <x-admin.settings.navigation></x-admin.settings.navigation>

                <!-- Panel -->
                <div class="grow">

                    <!-- Panel body -->
                    <div class="p-6 space-y-6">
                        <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-5">Cuentas Bancarias</h2>

                        @livewire('admin.ajustes.bank-accounts.index')
                    </div>

                </div>

            </div>
        </div>

    </div>

    @livewire('admin.ajustes.bank-accounts.save')

</x-admin-layout>
