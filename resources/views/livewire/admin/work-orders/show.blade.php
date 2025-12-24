<div class="space-y-6">
    {{-- Header con Información Principal --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Orden: {{ $workOrder->codigo }}
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Creada: {{ $workOrder->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $workOrder->estado->statusColor() }}">
                        {{ $workOrder->estado->value }}
                    </span>

                    @if ($workOrder->bloqueado)
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            🔒 Bloqueado
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información del Servicio --}}
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Tipo de Orden</h3>
                <p class="text-base text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->tipo->nombre ?? 'N/A' }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Vehículo</h3>
                <p class="text-base text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->vehiculo->placa ?? 'N/A' }}
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        - {{ $workOrder->vehiculo->marca ?? '' }} {{ $workOrder->vehiculo->modelo ?? '' }}
                    </span>
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Cliente</h3>
                <p class="text-base text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->cliente->razon_social ?? ($workOrder->vehiculo->cliente->razon_social ?? 'N/A') }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Técnico Asignado</h3>
                <p class="text-base text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->tecnico->name ?? 'Sin asignar' }}
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Fecha Programada</h3>
                <p class="text-base text-gray-900 dark:text-white font-medium">
                    {{ $workOrder->fecha_programada ? $workOrder->fecha_programada->format('d/m/Y H:i') : 'No programada' }}
                </p>
            </div>

            @if ($workOrder->imei || $workOrder->iccid)
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Dispositivo</h3>
                    <p class="text-sm text-gray-900 dark:text-white">
                        @if ($workOrder->imei)
                            <span class="block">IMEI: {{ $workOrder->imei }}</span>
                        @endif
                        @if ($workOrder->iccid)
                            <span class="block">ICCID: {{ $workOrder->iccid }}</span>
                        @endif
                    </p>
                </div>
            @endif
        </div>

        @if ($workOrder->observaciones)
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Observaciones</h3>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $workOrder->observaciones }}
                </p>
            </div>
        @endif
    </div>

    {{-- Acciones Rápidas --}}
    @if (!$workOrder->bloqueado)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones</h2>

            <div class="flex flex-wrap gap-3">
                @if ($workOrder->estado->value === 'PENDIENTE')
                    <x-form.button primary icon="play" wire:click="iniciar">
                        Iniciar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'EN_PROCESO')
                    <x-form.button secondary icon="clipboard-document-list" wire:click="verChecklist('before')">
                        Checklist Inicial
                    </x-form.button>

                    <x-form.button secondary icon="clipboard-document-check" wire:click="verChecklist('after')">
                        Checklist Final
                    </x-form.button>

                    <x-form.button positive icon="check" wire:click="finalizar">
                        Finalizar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'FINALIZADO')
                    <x-form.button info icon="lock-closed" wire:click="cerrar">
                        Cerrar y Bloquear
                    </x-form.button>
                @endif

                @if (in_array($workOrder->estado->value, ['PENDIENTE', 'EN_PROCESO']))
                    <x-form.button negative icon="x-mark" wire:click="cancelar('Cancelado por usuario')">
                        Cancelar Orden
                    </x-form.button>
                @endif

                <x-form.button outline secondary icon="document-arrow-down" wire:click="descargarPDF">
                    Descargar PDF
                </x-form.button>
            </div>
        </div>
    @endif

    {{-- Timeline de Actividades --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
            Timeline de Actividades
        </h2>

        <div class="relative">
            {{-- Línea vertical --}}
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300 dark:bg-gray-600"></div>

            <div class="space-y-6">
                @foreach ($timeline as $event)
                    <div class="relative flex items-start gap-4 pl-12">
                        {{-- Icono --}}
                        <div
                            class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full 
                            bg-{{ $event['color'] }}-100 dark:bg-{{ $event['color'] }}-900
                            border-4 border-white dark:border-gray-800 z-10">
                            <svg class="w-4 h-4 text-{{ $event['color'] }}-600 dark:text-{{ $event['color'] }}-400"
                                fill="currentColor" viewBox="0 0 20 20">
                                @if ($event['icono'] === 'plus-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'play')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'check-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'camera')
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'lock-closed')
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                @endif
                            </svg>
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $event['titulo'] }}
                                    </h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $event['descripcion'] }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-4">
                                    {{ $event['fecha']->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- Data adicional si existe --}}
                            @if (isset($event['data']))
                                @if ($event['tipo'] === 'foto')
                                    <div class="mt-2">
                                        <img src="{{ Storage::disk('private')->url($event['data']->ruta) }}"
                                            alt="Evidencia"
                                            class="h-32 rounded border border-gray-300 dark:border-gray-600">
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Accesorios Instalados --}}
    @if ($workOrder->accessories->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Accesorios Instalados</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Producto</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Cantidad</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Precio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($workOrder->accessories as $accessory)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->producto->nombre ?? $accessory->descripcion }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->cantidad }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                    S/ {{ number_format($accessory->precio_unitario, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
