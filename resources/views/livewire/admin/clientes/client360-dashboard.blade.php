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
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Fecha de
                        alta</span>
                    <span
                        class="font-medium text-gray-700 dark:text-gray-200">{{ $cliente->created_at?->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Ejecutivo
                        asignado</span>
                    <span
                        class="font-medium text-gray-700 dark:text-gray-200">{{ $ejecutivo?->name ?? 'Sin asignar' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Customer Health Score ─────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <div class="flex items-center gap-2 mb-3">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Customer Health
                Score</h2>
            <button type="button" wire:click="$set('mostrarInfoChs', true)" title="¿Cómo se calcula?"
                class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-semibold text-gray-400 ring-1 ring-gray-300 dark:ring-gray-700 hover:text-indigo-600 hover:ring-indigo-400">
                ?
            </button>
        </div>
        @if ($chsActual)
            <div class="flex flex-wrap items-end gap-6">
                <div>
                    <span
                        class="text-4xl font-bold {{ $chsActual->categoria->color() }}">{{ $chsActual->score_final }}</span>
                    <span class="text-sm text-gray-400">/100</span>
                    <p class="mt-1">
                        <span
                            class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $chsActual->categoria->bgColor() }}">
                            {{ $chsActual->categoria->label() }}
                        </span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Período: {{ $chsActual->periodo->format('m/Y') }}</p>
                </div>
                @if ($chsTendencia->count() > 1)
                    <div class="flex items-end gap-1.5 h-20"
                        title="Tendencia últimos {{ $chsTendencia->count() }} meses">
                        @foreach ($chsTendencia as $snapshot)
                            <div class="flex flex-col items-end h-full" wire:key="chs-tendencia-{{ $snapshot->id }}">
                                <div class="w-4 rounded-t {{ $snapshot->categoria->barColor() }}"
                                    style="height: {{ max(4, $snapshot->score_final) }}%"
                                    title="{{ $snapshot->periodo->format('m/Y') }}: {{ $snapshot->score_final }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="text-sm text-gray-400">CHS aún no calculado.</p>
        @endif
    </div>

    <x-form.modal.card title="¿Cómo se calcula el Customer Health Score?" max-width="xl" blur
        wire:model.live="mostrarInfoChs" align="center">
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
            El puntaje (0-100) es un promedio ponderado de estos 7 factores. Si al cliente le falta información en
            alguno (por ejemplo, no tiene tickets en los últimos 6 meses), ese factor se excluye y su peso se
            redistribuye entre los demás. Se recalcula el día 1 de cada mes.
        </p>
        <ul class="space-y-3 text-sm">
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Pagos / Cobranza</span>
                    <p class="text-gray-500 dark:text-gray-400">% de cobros activos del cliente que están al día (no
                        vencidos).</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">25%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Soporte / Tickets</span>
                    <p class="text-gray-500 dark:text-gray-400">% de tickets de soporte (últimos 6 meses) resueltos
                        dentro del plazo (SLA).</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">20%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">GPS / Vehículos activos</span>
                    <p class="text-gray-500 dark:text-gray-400">% de vehículos del cliente con el rastreo GPS activo.
                    </p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">15%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Antigüedad / Lealtad</span>
                    <p class="text-gray-500 dark:text-gray-400">Tiempo que lleva el cliente con la empresa, con bono
                        extra si tiene un contrato vigente.</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">10%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Comunicación WhatsApp</span>
                    <p class="text-gray-500 dark:text-gray-400">Qué tan reciente fue la última conversación de
                        WhatsApp con el cliente.</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">10%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Satisfacción — Reseñas</span>
                    <p class="text-gray-500 dark:text-gray-400">Promedio de calificaciones (1-5 estrellas) dejadas
                        por el cliente en los últimos 6 meses.</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">10%</span>
            </li>
            <li class="flex justify-between gap-4">
                <div>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Satisfacción — Órdenes de trabajo</span>
                    <p class="text-gray-500 dark:text-gray-400">Promedio de calificaciones del cliente a las órdenes
                        de trabajo completadas en los últimos 6 meses.</p>
                </div>
                <span class="shrink-0 font-semibold text-gray-700 dark:text-gray-200">10%</span>
            </li>
        </ul>
        <div class="mt-5 pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Categorías</p>
            <div class="flex flex-wrap gap-2 text-xs">
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Excelente: 80-100</span>
                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">Bueno: 60-79</span>
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">En riesgo: 40-59</span>
                <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700">Crítico: 0-39</span>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-form.button flat label="Cerrar" wire:click="$set('mostrarInfoChs', false)" />
            </div>
        </x-slot>
    </x-form.modal.card>

    {{-- ── Panel de vehículos + GPS ──────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <details>
            <summary
                class="cursor-pointer select-none text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Vehículos ({{ count($vehiculosConGps) }})
            </summary>
            @if (count($vehiculosConGps) > 0)
                <div class="overflow-x-auto mt-3">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-200 dark:border-gray-800">
                                <th class="py-2 pr-4">Placa</th>
                                <th class="py-2 pr-4">Marca / Modelo</th>
                                <th class="py-2 pr-4">Estado GPS</th>
                                <th class="py-2 pr-4">Activo en plataforma</th>
                                <th class="py-2 pr-4">Velocidad</th>
                                <th class="py-2 pr-4">Última señal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiculosConGps as $row)
                                <tr wire:key="veh-{{ $row['vehiculo']->id }}"
                                    class="border-b border-gray-100 dark:border-gray-800/60">
                                    <td class="py-2 pr-4 font-medium text-gray-800 dark:text-gray-100">
                                        {{ $row['vehiculo']->placa }}</td>
                                    <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['vehiculo']->marca }}
                                        {{ $row['vehiculo']->modelo }}</td>
                                    <td class="py-2 pr-4">
                                        @if ($row['online'] === null)
                                            <span class="text-gray-400">No disponible</span>
                                        @elseif ($row['online'])
                                            <span class="text-emerald-600">🟢 Transmitiendo</span>
                                        @else
                                            <span class="text-rose-600">🔴 Desconectado</span>
                                        @endif
                                    </td>
                                    <td class="py-2 pr-4">
                                        @if (!$row['vehiculo']->gpswox_id)
                                            <span class="text-gray-400">—</span>
                                        @elseif ($row['vehiculo']->gpswox_active)
                                            <span class="text-emerald-600">🟢 Activo</span>
                                        @else
                                            <span class="text-rose-600">🔴 Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">
                                        {{ $row['speed'] !== null ? $row['speed'] . ' km/h' : '—' }}</td>
                                    <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['time'] ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-400 mt-2">Sin vehículos registrados.</p>
            @endif
        </details>
    </div>

    {{-- ── Panel de documentos ───────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5 space-y-3">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Documentos</h2>

        {{-- Contratos --}}
        <details class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800" open>
            <summary
                class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                Contratos ({{ $contratos->count() }})
            </summary>
            @if ($contratos->count() > 0)
                <div class="overflow-x-auto border-t border-gray-100 dark:border-gray-800">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                                <th class="py-2 px-3">Emitido el</th>
                                <th class="py-2 px-3">Estado</th>
                                <th class="py-2 px-3">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contratos as $contrato)
                                <tr wire:key="contrato-{{ $contrato->id }}"
                                    class="border-b border-gray-50 dark:border-gray-800/60 last:border-0">
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $contrato->fecha_emision?->format('d/m/Y') ?? $contrato->fecha?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="py-2 px-3">
                                        @if ($contrato->estado)
                                            <span class="text-emerald-600">Activo</span>
                                        @else
                                            <span class="text-rose-600">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">
                                        <a target="_blank" href="{{ route('admin.pdf.contratos', $contrato) }}"
                                            class="text-indigo-600 hover:underline">Ver PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="px-3 pb-3 text-sm text-gray-400">Sin contratos registrados.</p>
            @endif
        </details>

        {{-- Certificados GPS --}}
        <details class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800">
            <summary
                class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                Certificados GPS ({{ $certificados->count() }})
            </summary>
            @if ($certificados->count() > 0)
                <div class="overflow-x-auto border-t border-gray-100 dark:border-gray-800">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                                <th class="py-2 px-3">Vehículo</th>
                                <th class="py-2 px-3">Código</th>
                                <th class="py-2 px-3">Instalación</th>
                                <th class="py-2 px-3">Vigencia</th>
                                <th class="py-2 px-3">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificados as $certificado)
                                <tr wire:key="certificado-{{ $certificado->id }}"
                                    class="border-b border-gray-50 dark:border-gray-800/60 last:border-0">
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certificado->vehiculo?->placa ?? '—' }}</td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certificado->codigo ?? '—' }}</td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certificado->fecha_instalacion?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="py-2 px-3">
                                        @if ($certificado->estado && $certificado->fin_cobertura?->isFuture())
                                            <span class="text-emerald-600">Vigente</span>
                                        @else
                                            <span class="text-rose-600">Vencido</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">
                                        <a target="_blank"
                                            href="{{ route('admin.pdf.certificados', ['certificado' => $certificado, 'vehiculo' => $certificado->vehiculo]) }}"
                                            class="text-indigo-600 hover:underline">Ver PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="px-3 pb-3 text-sm text-gray-400">Sin certificados registrados.</p>
            @endif
        </details>

        {{-- Actas --}}
        <details class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800">
            <summary
                class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                Actas ({{ $actas->count() }})
            </summary>
            @if ($actas->count() > 0)
                <div class="overflow-x-auto border-t border-gray-100 dark:border-gray-800">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                                <th class="py-2 px-3">Vehículo</th>
                                <th class="py-2 px-3">Código</th>
                                <th class="py-2 px-3">Instalación</th>
                                <th class="py-2 px-3">Vigencia</th>
                                <th class="py-2 px-3">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actas as $acta)
                                <tr wire:key="acta-{{ $acta->id }}"
                                    class="border-b border-gray-50 dark:border-gray-800/60 last:border-0">
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $acta->vehiculo?->placa ?? '—' }}</td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">{{ $acta->codigo ?? '—' }}
                                    </td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $acta->fecha_instalacion?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="py-2 px-3">
                                        @if ($acta->estaVigente())
                                            <span class="text-emerald-600">Vigente</span>
                                        @else
                                            <span class="text-rose-600">Vencido</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">
                                        <a target="_blank"
                                            href="{{ route('admin.pdf.actas', ['acta' => $acta, 'vehiculo' => $acta->vehiculo]) }}"
                                            class="text-indigo-600 hover:underline">Ver PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="px-3 pb-3 text-sm text-gray-400">Sin actas registradas.</p>
            @endif
        </details>

        {{-- Certificados de velocímetro --}}
        <details class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800">
            <summary
                class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                Cert. Velocímetro ({{ $certVelocimetros->count() }})
            </summary>
            @if ($certVelocimetros->count() > 0)
                <div class="overflow-x-auto border-t border-gray-100 dark:border-gray-800">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr
                                class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-800">
                                <th class="py-2 px-3">Vehículo</th>
                                <th class="py-2 px-3">Código</th>
                                <th class="py-2 px-3">Fecha</th>
                                <th class="py-2 px-3">Estado</th>
                                <th class="py-2 px-3">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certVelocimetros as $certVelocimetro)
                                <tr wire:key="cert-velo-{{ $certVelocimetro->id }}"
                                    class="border-b border-gray-50 dark:border-gray-800/60 last:border-0">
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certVelocimetro->vehiculo?->placa ?? '—' }}</td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certVelocimetro->codigo ?? '—' }}</td>
                                    <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                                        {{ $certVelocimetro->fecha ?? '—' }}</td>
                                    <td class="py-2 px-3">
                                        @if ($certVelocimetro->estado)
                                            <span class="text-emerald-600">Activo</span>
                                        @else
                                            <span class="text-rose-600">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">
                                        <a target="_blank"
                                            href="{{ route('admin.pdf.velocimetros', ['certificado' => $certVelocimetro, 'vehiculo' => $certVelocimetro->vehiculo]) }}"
                                            class="text-indigo-600 hover:underline">Ver PDF</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="px-3 pb-3 text-sm text-gray-400">Sin certificados de velocímetro registrados.</p>
            @endif
        </details>
    </div>

    <livewire:admin.clientes.cliente-resenas :cliente="$cliente" />

    @include('livewire.admin.clientes.partials.client360-comercial-timeline')
</div>
