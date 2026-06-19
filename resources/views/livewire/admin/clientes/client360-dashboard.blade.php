<div class="p-4 sm:p-6 space-y-6">

    {{-- ── Header ejecutivo ──────────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $cliente->razon_social }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cliente->numero_documento }}</p>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Estado</span>
                    <span class="font-medium {{ $cliente->is_active ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $cliente->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Fecha de alta</span>
                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $cliente->created_at?->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Ejecutivo asignado</span>
                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $ejecutivo?->name ?? 'Sin asignar' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Panel de vehículos + GPS ──────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">
            Vehículos ({{ count($vehiculosConGps) }})
        </h2>
        @if (count($vehiculosConGps) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-200 dark:border-gray-800">
                            <th class="py-2 pr-4">Placa</th>
                            <th class="py-2 pr-4">Marca / Modelo</th>
                            <th class="py-2 pr-4">Estado GPS</th>
                            <th class="py-2 pr-4">Velocidad</th>
                            <th class="py-2 pr-4">Última señal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculosConGps as $row)
                            <tr wire:key="veh-{{ $row['vehiculo']->id }}" class="border-b border-gray-100 dark:border-gray-800/60">
                                <td class="py-2 pr-4 font-medium text-gray-800 dark:text-gray-100">{{ $row['vehiculo']->placa }}</td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['vehiculo']->marca }} {{ $row['vehiculo']->modelo }}</td>
                                <td class="py-2 pr-4">
                                    @if ($row['online'] === null)
                                        <span class="text-gray-400">No disponible</span>
                                    @elseif ($row['online'])
                                        <span class="text-emerald-600">🟢 Transmitiendo</span>
                                    @else
                                        <span class="text-rose-600">🔴 Desconectado</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['speed'] !== null ? $row['speed'].' km/h' : '—' }}</td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['time'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-400">Sin vehículos registrados.</p>
        @endif
    </div>

    {{-- ── Panel de documentos ───────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Documentos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Contratos</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $contratos->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Certificados GPS</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $certificados->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Actas</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $actas->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Cert. Velocímetro</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $certVelocimetros->count() }}</p>
            </div>
        </div>
    </div>

    <livewire:admin.clientes.cliente-resenas :cliente="$cliente" />

    @include('livewire.admin.clientes.partials.client360-comercial-timeline')
</div>
