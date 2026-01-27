<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                        Ticket: {{ $ticket->code }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Creado {{ $ticket->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <x-form.badge :label="$ticket->status->label()" :class="$ticket->status->statusColor()" />
                    <x-form.badge :label="$ticket->priority->label()" :class="$ticket->priority->statusColor()" />
                </div>
            </div>
        </div>

        @livewire('admin.tickets.show', ['ticket' => $ticket])
    </div>
</x-admin-layout>
