<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Cuentas por Cobrar
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
            @livewire('admin.finanzas.cuentas-cobrar.index')
        </div>
    </div>

    @push('modals')
        @livewire('admin.finanzas.cuentas-cobrar.register-payment')
    @endpush
</x-admin-layout>
