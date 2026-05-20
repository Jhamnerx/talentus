<x-form.modal.card wire:model.live="modalOpen" width="4xl" align="center">

    <x-slot name="title">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0-3-3.85" />
            </svg>
            <span>Contactos — {{ $clienteNombre }}</span>
        </div>
    </x-slot>

    @if ($contactos->isEmpty())
        <div class="py-10 text-center text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mb-3 opacity-40" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="7" r="4" />
                <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                <line x1="17" y1="8" x2="23" y2="14" />
                <line x1="23" y1="8" x2="17" y2="14" />
            </svg>
            <p class="text-sm">Este cliente no tiene contactos registrados.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">DNI</th>
                        <th class="px-4 py-3 text-left">Cargo</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-left">Correo</th>
                        <th class="px-4 py-3 text-center">Gerente</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-gray-700 dark:text-gray-300">
                    @foreach ($contactos as $contacto)
                        <tr wire:key="contacto-{{ $contacto->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-4 py-3 font-medium">{{ $contacto->nombre }}</td>
                            <td class="px-4 py-3">{{ $contacto->numero_documento }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $contacto->cargo }}</td>
                            <td class="px-4 py-3">{{ $contacto->telefono }}</td>
                            <td class="px-4 py-3">{{ $contacto->email }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($contacto->is_gerente)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        Gerente
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($contactos->hasPages())
            <div class="mt-4 px-4">
                {{ $contactos->links() }}
            </div>
        @endif
    @endif

    <x-slot name="footer">
        <div class="flex justify-end">
            <x-form.button flat label="Cerrar" wire:click="cerrar" />
        </div>
    </x-slot>

</x-form.modal.card>
