<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-6 w-full max-w-384 mx-auto">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-5">
            <a href="{{ route('admin.tickets.index') }}"
                class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                Tickets
            </a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-700 dark:text-gray-200 font-medium">{{ $ticket->code }}</span>
        </nav>

        @livewire('admin.tickets.show', ['ticket' => $ticket])
    </div>
</x-admin-layout>
