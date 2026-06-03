<x-form.modal.card title="Editar Orden de Trabajo" wire:model.live="modalOpen" width="xl">
    <div class="space-y-4">

        {{-- ── Aviso de mensaje WA ────────────────────────────────────────── --}}
        @if ($waEnviado)
            <div
                class="flex items-start gap-2 rounded-lg border border-amber-200 bg-amber-50 dark:border-amber-600/30 dark:bg-amber-950/20 px-3 py-2.5">
                <svg class="mt-0.5 w-4 h-4 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs text-amber-700 dark:text-amber-300">
                    Esta orden tiene mensaje de WhatsApp enviado. Si cambias el técnico, la fecha, la dirección o
                    el vehículo, el mensaje en el grupo se actualizará automáticamente.
                </span>
            </div>
        @endif

        {{-- ── Fecha programada ───────────────────────────────────────────── --}}
        <x-form.datetime.picker label="Fecha Programada *" wire:model.live="fecha_programada"
            parse-format="YYYY-MM-DD HH:mm" display-format="DD-MM-YYYY HH:mm" :clearable="false" :interval="30" />

        {{-- ── Técnico — filtrable por ciudad ────────────────────────────── --}}
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 space-y-3">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Técnico Asignado
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <x-form.select label="Filtrar por ciudad" wire:model.live="ciudad_filter"
                    placeholder="Todas las ciudades" option-label="nombre" option-value="id" :options="$ciudades"
                    :clearable="false" />

                <x-form.select label="Técnico *" wire:model.live="tecnico_id" placeholder="Seleccionar técnico"
                    :options="$tecnicos" option-label="name" option-value="id" />
            </div>
        </div>

        {{-- ── Vehículo (solo modo individual) ───────────────────────────── --}}
        @if (!$esProyecto)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Vehículo / Placa</span>
                </div>
                <x-form.select autocomplete="off" wire:model.live="vehiculo_id" placeholder="Buscar por placa"
                    :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id" option-description="option_description" />
                @if ($cliente_nombre)
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <svg class="inline w-3 h-3 mr-0.5 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $cliente_nombre }}
                    </p>
                @endif
            </div>
        @endif

        {{-- ── Dirección ───────────────────────────────────────────────────── --}}
        <x-form.input label="Dirección del servicio" wire:model="direccion"
            placeholder="Ej: Av. Los Álamos 456, Surco" />

        {{-- ── Sector + Plan ───────────────────────────────────────────────── --}}
        @if ($tipoMuestraSector || $tipoMuestraPlan)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if ($tipoMuestraSector)
                    <x-form.select multiselect label="Sector" wire:model.live="sector"
                        placeholder="Seleccionar sectores" :options="$sectores" option-label="label"
                        option-value="value" />
                @endif

                @if ($tipoMuestraPlan)
                    <x-form.select label="Plan de servicio" wire:model="plan_id" placeholder="Seleccionar plan"
                        :options="$planes" option-label="name" option-value="id" :clearable="true" />
                @endif
            </div>

            @if ($tipoMuestraSector && in_array('OTROS', $sector))
                <x-form.input label="Especificar sector" wire:model="sector_especifico"
                    placeholder="Describir sector..." />
            @endif
        @endif

        {{-- ── Operador SIM (independiente) ──────────────────────────────────── --}}
        @if ($tipoRequiereOperadorSim)
            <x-form.select label="Operador SIM *" wire:model="operador_sim_orden" placeholder="Seleccionar operador"
                :options="$operadores" option-label="name" option-value="name" :clearable="true" />
        @endif

        {{-- ── Modelo de dispositivo (independiente) ──────────────────────────── --}}
        @if ($tipoRequiereModeloDispositivo)
            <x-form.select label="Modelo del dispositivo *" wire:model="modelo_dispositivo_id"
                placeholder="Seleccionar modelo" :options="$modelosDispositivo" option-label="name" option-value="id"
                :clearable="true"
                hint="{{ $tipoEquipo === 'sensor_adas' ? 'Sensor ADAS' : ($tipoEquipo === 'velocimetro' ? 'Velocímetro' : 'Dispositivo GPS') }}" />
        @endif

        {{-- ── Observaciones ───────────────────────────────────────────────── --}}
        <x-form.textarea label="Observaciones iniciales" wire:model="observaciones_inicial" rows="3"
            placeholder="Indicaciones para el técnico..." />

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Guardar cambios" wire:click="save" wire:loading.attr="disabled"
                wire:target="save" />
        </div>
    </x-slot>
</x-form.modal.card>
