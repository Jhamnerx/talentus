<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.work-orders.index') }}" class="text-gray-600 hover:text-gray-900">
                        <x-icon name="arrow-left" class="w-6 h-6" />
                    </a>
                    <div>
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">
                            Orden de Trabajo {{ $workOrder->codigo }}
                        </h1>
                        <p class="text-sm text-gray-600">
                            Creada el {{ $workOrder->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $workOrder->estado->statusColor() }}">
                        {{ $workOrder->estado->label() }}
                    </span>

                    @if ($workOrder->bloqueado)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
                            <x-icon name="lock-closed" class="w-4 h-4 inline" /> Bloqueada
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Información General -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Información General</h2>
                    </div>
                    <div class="p-6 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Tipo de Orden</p>
                            <p class="font-medium">{{ $workOrder->tipo_data['nombre'] ?? $workOrder->tipo->nombre }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Costo Base</p>
                            <p class="font-medium">S/ {{ number_format($workOrder->tipo_data['costo_base'] ?? 0, 2) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Vehículo</p>
                            <p class="font-medium">{{ $workOrder->vehiculo->placa }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cliente</p>
                            <p class="font-medium">{{ $workOrder->cliente->nombres }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Técnico Asignado</p>
                            <p class="font-medium">{{ $workOrder->tecnico->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha Programada</p>
                            <p class="font-medium">{{ $workOrder->fecha_programada->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline de Progreso -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Timeline de Progreso</h2>
                    </div>
                    <div class="p-6">
                        <div class="relative">
                            <!-- Línea vertical -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                            <!-- Eventos del timeline -->
                            <div class="space-y-6">

                                <!-- Creación -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center z-10">
                                        <x-icon name="plus" class="w-4 h-4 text-white" />
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="text-sm font-medium text-gray-900">Orden Creada</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $workOrder->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">Por {{ $workOrder->creador->name }}</p>
                                    </div>
                                </div>

                                @if ($workOrder->fecha_inicio)
                                    <!-- Inicio -->
                                    <div class="relative flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center z-10">
                                            <x-icon name="play" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Trabajo Iniciado</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $workOrder->fecha_inicio->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($workOrder->fecha_finalizacion)
                                    <!-- Finalización -->
                                    <div class="relative flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center z-10">
                                            <x-icon name="check" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Trabajo Finalizado</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $workOrder->fecha_finalizacion->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($workOrder->fecha_cerrado)
                                    <!-- Cierre -->
                                    <div class="relative flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center z-10">
                                            <x-icon name="lock-closed" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Orden Cerrada y Bloqueada</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $workOrder->fecha_cerrado->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($workOrder->estado === \App\Enums\WorkOrderStatus::CANCELADO)
                                    <!-- Cancelación -->
                                    <div class="relative flex items-start">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-red-500 flex items-center justify-center z-10">
                                            <x-icon name="x" class="w-4 h-4 text-white" />
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Orden Cancelada</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $workOrder->updated_at->format('d/m/Y H:i') }}</p>
                                            @if ($workOrder->motivo_cancelacion)
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $workOrder->motivo_cancelacion }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checklist -->
                @if ($workOrder->checklists->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Checklist de Inspección</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- BEFORE -->
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-4">Antes del Trabajo</h3>
                                    <div class="space-y-2">
                                        @foreach ($workOrder->checklists->where('fase', 'before') as $item)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                                <span class="text-sm">{{ $item->template->nombre }}</span>
                                                <span
                                                    class="text-xs px-2 py-1 rounded {{ $item->resultado->statusColor() }}">
                                                    {{ $item->resultado->label() }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- AFTER -->
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-4">Después del Trabajo</h3>
                                    <div class="space-y-2">
                                        @foreach ($workOrder->checklists->where('fase', 'after') as $item)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                                <span class="text-sm">{{ $item->template->nombre }}</span>
                                                <span
                                                    class="text-xs px-2 py-1 rounded {{ $item->resultado->statusColor() }}">
                                                    {{ $item->resultado->label() }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Dispositivos -->
                @if ($workOrder->deviceHistory->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Historial de Dispositivos</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($workOrder->deviceHistory as $history)
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                @if ($history->accion_imei !== 'ninguna')
                                                    <p class="font-medium">IMEI: {{ $history->imei }}</p>
                                                    <p class="text-sm text-gray-600">Acción:
                                                        {{ ucfirst($history->accion_imei) }}</p>
                                                @endif
                                                @if ($history->accion_sim !== 'ninguna')
                                                    <p class="font-medium mt-2">SIM: {{ $history->numero_linea }}</p>
                                                    <p class="text-sm text-gray-600">Acción:
                                                        {{ ucfirst($history->accion_sim) }}</p>
                                                @endif
                                            </div>
                                            <span class="text-xs text-gray-500">
                                                {{ optional($history->fecha_instalacion)->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Accesorios -->
                @if ($workOrder->accessories->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Accesorios</h2>
                        </div>
                        <div class="p-6">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-sm text-gray-600 border-b">
                                        <th class="pb-2">Nombre</th>
                                        <th class="pb-2">Cantidad</th>
                                        <th class="pb-2">Acción</th>
                                        <th class="pb-2 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workOrder->accessories as $accessory)
                                        <tr class="text-sm border-b">
                                            <td class="py-2">{{ $accessory->nombre }}</td>
                                            <td class="py-2">{{ $accessory->cantidad }}</td>
                                            <td class="py-2">{{ ucfirst($accessory->accion) }}</td>
                                            <td class="py-2 text-right">S/
                                                {{ number_format($accessory->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-bold">
                                        <td colspan="3" class="py-2 text-right">Total:</td>
                                        <td class="py-2 text-right">S/
                                            {{ number_format($workOrder->accessories->sum('subtotal'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Columna Lateral -->
            <div class="space-y-6">

                <!-- Acciones -->
                @if ($workOrder->puedeEditar())
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Acciones</h3>
                        <div class="space-y-2">
                            @if ($workOrder->estado === \App\Enums\WorkOrderStatus::PENDIENTE)
                                <x-button wire:click="iniciarOrden" primary full label="Iniciar Trabajo" />
                            @endif

                            @if ($workOrder->estado === \App\Enums\WorkOrderStatus::EN_PROCESO)
                                <x-button wire:click="finalizarOrden" success full label="Finalizar Trabajo" />
                            @endif

                            @if ($workOrder->estado === \App\Enums\WorkOrderStatus::FINALIZADO && !$workOrder->bloqueado)
                                <x-button wire:click="cerrarOrden" purple full label="Cerrar y Bloquear" />
                            @endif

                            @if ($workOrder->estado !== \App\Enums\WorkOrderStatus::CANCELADO)
                                <x-button wire:click="cancelarOrden" red full label="Cancelar Orden" />
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Evidencia Fotográfica -->
                @if ($workOrder->photos->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Evidencia Fotográfica</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($workOrder->photos->take(4) as $photo)
                                <div class="aspect-square bg-gray-100 rounded overflow-hidden">
                                    <img src="{{ $photo->url }}" alt="Foto evidencia"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                        @if ($workOrder->photos->count() > 4)
                            <p class="text-sm text-gray-600 mt-2 text-center">
                                +{{ $workOrder->photos->count() - 4 }} fotos más
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Firmas -->
                @if ($workOrder->signatures->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Firmas Digitales</h3>
                        <div class="space-y-4">
                            @foreach ($workOrder->signatures as $signature)
                                <div class="border rounded p-3">
                                    <p class="text-sm font-medium">{{ ucfirst($signature->tipo) }}</p>
                                    <p class="text-xs text-gray-600">{{ $signature->nombre_firmante }}</p>
                                    <p class="text-xs text-gray-500">{{ $signature->firmado_at->format('d/m/Y H:i') }}
                                    </p>

                                    @if ($signature->verificarIntegridad())
                                        <span class="inline-flex items-center text-xs text-green-600 mt-2">
                                            <x-icon name="shield-check" class="w-4 h-4 mr-1" />
                                            Firma verificada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-xs text-red-600 mt-2">
                                            <x-icon name="exclamation" class="w-4 h-4 mr-1" />
                                            Firma comprometida
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Observaciones -->
                @if ($workOrder->observaciones_inicial || $workOrder->observaciones_tecnico || $workOrder->observaciones_final)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Observaciones</h3>
                        <div class="space-y-3">
                            @if ($workOrder->observaciones_inicial)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Inicial:</p>
                                    <p class="text-sm">{{ $workOrder->observaciones_inicial }}</p>
                                </div>
                            @endif
                            @if ($workOrder->observaciones_tecnico)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Técnico:</p>
                                    <p class="text-sm">{{ $workOrder->observaciones_tecnico }}</p>
                                </div>
                            @endif
                            @if ($workOrder->observaciones_final)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Final:</p>
                                    <p class="text-sm">{{ $workOrder->observaciones_final }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Exportar PDF -->
                <div class="bg-white rounded-lg shadow p-6">
                    <a href="{{ route('admin.work-orders.pdf', $workOrder) }}" target="_blank" class="block">
                        <x-button secondary full icon="document-download" label="Descargar PDF" />
                    </a>
                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
