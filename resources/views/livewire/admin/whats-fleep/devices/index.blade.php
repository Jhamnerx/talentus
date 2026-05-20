<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dispositivos WhatsApp</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-form.button wire:click="openCreateModal" primary icon="plus" label="Nuevo dispositivo" />
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-full sm:w-64">
                    <x-form.input wire:model.live.debounce="search" placeholder="Buscar dispositivo..."
                        icon="magnifying-glass" />
                </div>
            </div>
        </div>
    </div>

    @if ($devices->isEmpty())
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl py-16 text-center">
            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3" />
            </svg>
            <p class="text-gray-500 dark:text-gray-400 mb-4">A&uacute;n no tienes dispositivos registrados.</p>
            <x-form.button wire:click="openCreateModal" primary label="Agregar primer dispositivo" />
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl relative">
            <header
                class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                    Cuentas de WhatsApp
                    <span
                        class="ml-2 text-xs font-normal px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full">{{ $totalDevices }}</span>
                </h2>
            </header>
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead
                        class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/60">
                        <tr>
                            <th class="px-4 py-3 text-left">Número</th>
                            <th class="px-4 py-3 text-left">URL Webhook</th>
                            <th class="px-4 py-3 text-left">Clave API</th>
                            <th class="px-4 py-3 text-center">Mensajes enviados</th>
                            <th class="px-4 py-3 text-center">Sistema</th>
                            <th class="px-4 py-3 text-center">Sistema</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach ($devices as $device)
                            <tr wire:key="device-{{ $device->id }}"
                                class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $device->body }}</div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                                {{ $device->updated_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $device->webhook ? Str::limit($device->webhook, 30) : '' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-xs font-mono text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                            {{ Str::limit($device->api_key, 20) }}
                                        </span>
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $device->api_key }}').then(() => $wire.apiKeyCopied())"
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition cursor-pointer"
                                            title="Copiar clave API">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                                <path
                                                    d="M12 0H4a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V2a2 2 0 00-2-2zm0 12H4V2h8v10z" />
                                                <path
                                                    d="M2 4H1a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1v-1h-2v-1H2V5H1h1V4z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="text-gray-600 dark:text-gray-300">{{ $device->message_histories_count ?? 0 }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($device->interno)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            Sistema
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span @class([
                                        'px-2.5 py-1 text-xs font-semibold rounded-full',
                                        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' =>
                                            $device->status === 'Connected',
                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' =>
                                            $device->status === 'Pending',
                                        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' => !in_array(
                                            $device->status,
                                            ['Connected', 'Pending']),
                                    ])>
                                        @if ($device->status === 'Connected')
                                            Conectado
                                        @elseif ($device->status === 'Pending')
                                            Pendiente
                                        @else
                                            Desconectado
                                        @endif
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        {{-- Escanear / Ver --}}
                                        <a href="{{ route('admin.whats-fleep.devices.scan', $device->body) }}"
                                            title="{{ $device->status === 'Connected' ? 'Ver dispositivo' : 'Escanear QR' }}"
                                            class="p-1.5 rounded transition @if ($device->status === 'Connected') text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 @else text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 @endif">
                                            @if ($device->status === 'Connected')
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            @endif
                                        </a>
                                        {{-- Editar --}}
                                        <button wire:click="openEditModal({{ $device->id }})" title="Editar"
                                            class="p-1.5 rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        {{-- Eliminar --}}
                                        <button wire:click="openDeleteModal({{ $device->id }})" title="Eliminar"
                                            class="p-1.5 rounded text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($devices->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                    {{ $devices->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
