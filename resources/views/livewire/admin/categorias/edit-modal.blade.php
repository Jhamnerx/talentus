<div>
    <x-form.modal.card title="Editar Categoría" wire:model="modalEdit" max-width="2xl">
        <div class="space-y-4">
            <x-form.input label="Nombre *" wire:model="nombre" placeholder="Nombre de la categoría" />
            <x-form.textarea label="Descripción" wire:model="descripcion" placeholder="Descripción de la categoría" />

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wide">
                        Facturación GPS
                    </p>
                    @if ($tieneProductos)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 ring-1 ring-inset ring-amber-500/30">
                            🔒 Bloqueado — categoría con productos
                        </span>
                    @endif
                </div>

                {{-- GPS y Monitoreo: bloqueados si hay productos --}}
                @if ($tieneProductos)
                    <div class="flex items-center justify-between py-1">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Equipo GPS</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $es_equipo_gps ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                            {{ $es_equipo_gps ? '📡 Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-1">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Servicio de Monitoreo</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $es_servicio_monitoreo ? 'bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                            {{ $es_servicio_monitoreo ? '🛰️ Activo' : 'Inactivo' }}
                        </span>
                    </div>
                @else
                    {{-- Equipo GPS --}}
                    @if ($equipoGpsOcupado)
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-gray-400 dark:text-gray-500">Equipo GPS</span>
                                <p class="text-xs text-amber-600 dark:text-amber-400">⚠️ Ya asignado a: <strong>{{ $equipoGpsOcupado->nombre }}</strong></p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-400">No disponible</span>
                        </div>
                    @else
                        <x-form.toggle name="es_equipo_gps_edit" wire:model.live="es_equipo_gps" label="Equipo GPS" md />
                        @error('es_equipo_gps') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    @endif

                    {{-- Servicio de Monitoreo --}}
                    @if ($monitoreoOcupado)
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-gray-400 dark:text-gray-500">Servicio de Monitoreo</span>
                                <p class="text-xs text-amber-600 dark:text-amber-400">⚠️ Ya asignado a: <strong>{{ $monitoreoOcupado->nombre }}</strong></p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-400">No disponible</span>
                        </div>
                    @else
                        <x-form.toggle name="es_servicio_monitoreo_edit" wire:model.live="es_servicio_monitoreo" label="Servicio de Monitoreo" md />
                        @error('es_servicio_monitoreo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    @endif
                @endif

                {{-- Accesorios WorkOrder: siempre editable --}}
                @if ($accesoriosOcupado)
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-400 dark:text-gray-500">Accesorios WorkOrder</span>
                            <p class="text-xs text-amber-600 dark:text-amber-400">⚠️ Ya asignado a: <strong>{{ $accesoriosOcupado->nombre }}</strong></p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-400">No disponible</span>
                    </div>
                @else
                    <x-form.toggle name="es_accesorios_edit" wire:model.live="es_accesorios" label="Accesorios WorkOrder" md />
                    @error('es_accesorios') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Actualizar" wire:click="update" primary spinner="update" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
