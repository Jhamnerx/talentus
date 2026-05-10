<x-admin-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.whats-fleep.campaigns') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-form.icon name="arrow-left" class="w-4 h-4 mr-1" /> Volver a campañas
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-2">Nueva Campaña</h1>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8">
            @livewire('admin.whats-fleep.campaigns.create-campaign')
        </div>
    </div>
</x-admin-layout>
