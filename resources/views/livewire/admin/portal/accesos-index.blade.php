<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Accesos al Portal 🔐
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Aprueba o gestiona el acceso de tus clientes al portal.
            </p>
        </div>

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live.debounce.400ms="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    type="search" placeholder="Buscar por nombre, correo o RUC" />
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtro por estado -->
    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($estados as $e)
            <button type="button" wire:click="$set('estado', '{{ $e }}')"
                @class([
                    'px-3 py-1.5 rounded-full text-sm font-medium border transition capitalize',
                    'bg-violet-500 text-white border-violet-500' => $estado === $e,
                    'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600' => $estado !== $e,
                ])>
                {{ $e }}
                @if ($e === 'pendiente' && $pendientesCount > 0)
                    <span class="ml-1 inline-flex items-center justify-center px-1.5 rounded-full text-xs bg-amber-500 text-white">
                        {{ $pendientesCount }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Tabla -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl border border-gray-200 dark:border-gray-700/60 relative">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-100 dark:divide-gray-700/60">
                <thead class="text-xs uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                        <th class="px-4 py-3 text-left font-semibold">Usuario</th>
                        <th class="px-4 py-3 text-left font-semibold">Rol</th>
                        <th class="px-4 py-3 text-left font-semibold">Correo</th>
                        <th class="px-4 py-3 text-left font-semibold">Estado</th>
                        <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse ($accesos as $acceso)
                        <tr wire:key="acceso-{{ $acceso->id }}">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $acceso->cliente?->razon_social ?? '—' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    RUC: {{ $acceso->cliente?->numero_documento ?? '—' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-800 dark:text-gray-100">{{ $acceso->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $acceso->email }}</div>
                            </td>
                            <td class="px-4 py-3 capitalize text-gray-600 dark:text-gray-300">{{ $acceso->rol }}</td>
                            <td class="px-4 py-3">
                                @if ($acceso->email_verified_at)
                                    <span class="inline-flex items-center text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                        ✓ Verificado
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-xs font-medium text-gray-400 dark:text-gray-500">
                                        Sin verificar
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium capitalize',
                                    'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' => $acceso->estado === 'pendiente',
                                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' => $acceso->estado === 'aprobado',
                                    'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400' => $acceso->estado === 'rechazado',
                                    'bg-gray-200 text-gray-600 dark:bg-gray-600/30 dark:text-gray-300' => $acceso->estado === 'suspendido',
                                ])>
                                    {{ $acceso->estado }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if (in_array($acceso->estado, ['pendiente', 'rechazado', 'suspendido']))
                                        <button type="button" wire:click="aprobar({{ $acceso->id }})"
                                            wire:loading.attr="disabled"
                                            class="btn-sm bg-emerald-500 hover:bg-emerald-600 text-white">
                                            Aprobar
                                        </button>
                                    @endif

                                    @if ($acceso->estado === 'pendiente')
                                        <button type="button" wire:click="abrirRechazo({{ $acceso->id }})"
                                            class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-rose-500 hover:text-rose-600">
                                            Rechazar
                                        </button>
                                    @endif

                                    @if ($acceso->estado === 'aprobado')
                                        <button type="button" wire:click="suspender({{ $acceso->id }})"
                                            class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-amber-500 hover:text-amber-600">
                                            Suspender
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                No hay accesos en estado «{{ $estado }}».
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $accesos->links() }}
    </div>

    <!-- Modal de rechazo -->
    @if ($rechazandoId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4"
            wire:key="modal-rechazo">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 border border-gray-200 dark:border-gray-700/60">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Rechazar acceso</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Indica el motivo. Se enviará por correo al cliente.
                </p>
                <textarea wire:model="motivoRechazo" rows="3"
                    class="form-textarea w-full dark:bg-gray-900 dark:border-gray-700/60 dark:text-gray-100"
                    placeholder="Motivo del rechazo"></textarea>
                @error('motivoRechazo')
                    <p class="text-sm text-rose-500 mt-1">{{ $message }}</p>
                @enderror

                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" wire:click="cancelarRechazo"
                        class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300">
                        Cancelar
                    </button>
                    <button type="button" wire:click="rechazar" wire:loading.attr="disabled"
                        class="btn-sm bg-rose-500 hover:bg-rose-600 text-white">
                        Confirmar rechazo
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
