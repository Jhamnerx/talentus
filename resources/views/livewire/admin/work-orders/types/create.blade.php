<x-form.modal.card title="{{ $editingId ? 'Editar tipo de orden' : 'Nuevo tipo de orden' }}" wire:model.live="showModal"
    width="5xl">

    <div class="-mx-6 divide-y divide-gray-100 dark:divide-gray-800">

        {{-- ── Fila 1: Nombre + Costo base ─────────────────────────────────── --}}
        <div class="px-6 pb-5">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="sm:col-span-3">
                    <x-form.input wire:model="nombre" label="Nombre del tipo" placeholder="Ej: Instalación GPS" />
                </div>
                <div>
                    <x-form.input wire:model="costo_base" label="Costo base (S/)" type="number" step="0.01"
                        placeholder="0.00" />
                </div>
            </div>
        </div>

        {{-- ── Fila 2: Descripción ──────────────────────────────────────────── --}}
        <div class="px-6 py-5">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descripción</label>
            <div class="flex flex-wrap gap-1.5 mb-2">
                @foreach ($variablesDisponibles as $variable => $desc)
                    <button type="button" wire:click="insertarVariable('{{ $variable }}')"
                        title="{{ $desc }}"
                        class="px-2 py-0.5 font-mono text-xs rounded border border-dashed border-blue-300 text-blue-600
                               hover:bg-blue-50 dark:border-blue-700 dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors">
                        {{ $variable }}
                    </button>
                @endforeach
            </div>
            <x-form.textarea wire:model="descripcion"
                placeholder="Ej: Instalación de GPS %modelo_gps% en vehículo %placa% — %fecha% %hora%" rows="2" />
            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                Clic en una variable para insertarla. Se reemplazarán con los datos reales al crear la orden.
            </p>
        </div>

        {{-- ── Fila 2b: Tipo de equipo + Operador SIM ──────────────────────── --}}
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-form.select wire:model="tipo_equipo" label="Tipo de equipo"
                        placeholder="Sin especificar (general)" :options="[
                            ['id' => 'gps', 'name' => 'GPS Tracker'],
                            ['id' => 'sensor_adas', 'name' => 'Sensor ADAS'],
                            ['id' => 'velocimetro', 'name' => 'Velocímetro'],
                        ]" option-label="name" option-value="id"
                        :clearable="false" />
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                        Determina las alertas disponibles al crear la orden
                    </p>
                </div>
                @if ($requiere_sim)
                    <div>
                        <x-form.select wire:model="operador_sim" label="Operador SIM predeterminado"
                            placeholder="Sin especificar" :options="$operadores" option-label="name" option-value="name"
                            :clearable="true" />
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            Se mostrará como sugerencia al crear la orden
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Fila 3: Requisitos · Campos visibles · Comportamiento (3 col) ── --}}
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Requisitos técnicos --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                        Requisitos técnicos
                    </p>
                    <div class="space-y-3">
                        <div>
                            <x-form.checkbox wire:model="requiere_imei" label="IMEI del dispositivo" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">El técnico debe registrar el
                                IMEI</p>
                        </div>
                        <div>
                            <x-form.checkbox wire:model="requiere_sim" label="SIM / ICCID" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">El técnico debe registrar la
                                SIM</p>
                        </div>
                        <div>
                            <x-form.checkbox wire:model="requiere_accesorios" label="Accesorios GPS" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">Al menos un accesorio
                                requerido</p>
                        </div>
                        <div>
                            <x-form.checkbox wire:model="requiere_checklist" label="Checklist de inspección" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">Se debe completar el
                                checklist</p>
                        </div>
                        <div>
                            <x-form.checkbox wire:model="requiere_modelo_dispositivo" label="Modelo del dispositivo" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">Requiere seleccionar el
                                modelo de equipo</p>
                        </div>
                        <div>
                            <x-form.checkbox wire:model="requiere_alertas" label="Alertas obligatorias" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-6">Al menos una alerta debe ser
                                seleccionada</p>
                        </div>
                    </div>
                </div>

                {{-- Campos visibles al crear --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                        Campos visibles al crear
                    </p>
                    <div class="space-y-3">
                        <x-form.toggle wire:model="muestra_sector" label="Sector de operación"
                            description="SUTRAN, MINA, OSINERGMIN, etc." />
                        <x-form.toggle wire:model="muestra_plan" label="Plan de servicio"
                            description="Plan GPS asociado a la orden" />
                        <x-form.toggle wire:model="muestra_accesorios_instalar" label="Accesorios a instalar"
                            description="Buzzer, corte motor, cámara, etc." />
                        <x-form.toggle wire:model="muestra_alertas" label="Alertas a configurar"
                            description="Selector de alertas GPS o ADAS" />
                    </div>
                </div>

                {{-- Comportamiento --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                        Comportamiento
                    </p>
                    <div class="space-y-3">
                        <x-form.toggle wire:model="active" label="Tipo activo"
                            description="Los tipos inactivos no aparecen al crear órdenes" />
                        <x-form.toggle wire:model="es_mantenimiento_programado" label="Mantenimiento programado"
                            description="Permite vincular la orden con un mantenimiento del vehículo" />
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Fila 4: Costos por técnico ──────────────────────────────────── --}}
        @if ($tecnicos->isNotEmpty())
            <div class="px-6 py-5">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            Costos por técnico
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                            Deja vacío para usar el costo base (S/ {{ number_format($costo_base ?: 0, 2) }})
                        </p>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                        bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-700">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $tecnicos->count() }} técnicos
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($tecnicos as $tecnico)
                        @php $costoActual = $costosPorTecnico[$tecnico->id] ?? ''; @endphp
                        <div
                            class="flex items-center gap-2 rounded-lg border px-3 py-2 transition-colors
                            {{ $costoActual !== '' && $costoActual !== null
                                ? 'border-blue-200 bg-blue-50 dark:border-blue-700/50 dark:bg-blue-900/10'
                                : 'border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/40' }}">
                            {{-- Avatar inicial --}}
                            <div
                                class="shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold
                                {{ $costoActual !== '' && $costoActual !== null
                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-300'
                                    : 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ strtoupper(substr($tecnico->name, 0, 1)) }}
                            </div>
                            {{-- Nombre --}}
                            <span class="flex-1 text-xs font-medium text-gray-700 dark:text-gray-300 truncate"
                                title="{{ $tecnico->name }}">
                                {{ $tecnico->name }}
                            </span>
                            {{-- Input costo --}}
                            <div class="relative w-24 shrink-0">
                                <span
                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">S/</span>
                                <input type="number" step="0.01" min="0"
                                    wire:model.live="costosPorTecnico.{{ $tecnico->id }}"
                                    placeholder="{{ number_format($costo_base ?: 0, 2) }}"
                                    class="w-full pl-6 pr-2 py-1 text-xs border rounded-md text-right
                                           {{ $costoActual !== '' && $costoActual !== null
                                               ? 'border-blue-300 bg-white dark:border-blue-600 dark:bg-gray-900 text-blue-700 dark:text-blue-300 font-semibold'
                                               : 'border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-900 text-gray-700 dark:text-gray-300' }}
                                           focus:outline-none focus:ring-1 focus:ring-blue-400" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <x-slot name="footer">
        <div class="flex items-center justify-between w-full">
            <span class="text-xs text-gray-400 dark:text-gray-500">
                @if ($editingId)
                    Los cambios aplican a las próximas órdenes creadas.
                @endif
            </span>
            <div class="flex gap-3">
                <x-form.button flat label="Cancelar" wire:click="$set('showModal', false)" />
                <x-form.button primary label="{{ $editingId ? 'Actualizar tipo' : 'Crear tipo' }}"
                    wire:click="guardar" spinner="guardar" />
            </div>
        </div>
    </x-slot>

</x-form.modal.card>
