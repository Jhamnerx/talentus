<div>
    <x-form.modal.card title="Nueva Categoría" wire:model.live="modalCreate" width="2xl" align="center">
        <div class="space-y-4">
            <x-form.input label="Nombre *" wire:model.live="nombre" placeholder="Nombre de la categoría" />
            <x-form.textarea label="Descripción" wire:model.live="descripcion"
                placeholder="Descripción de la categoría" />

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
                <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wide">
                    Facturación GPS
                </p>

                {{-- Equipo GPS --}}
                @if ($equipoGpsOcupado)
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-400 dark:text-gray-500">Equipo GPS</span>
                            <p class="text-xs text-amber-600 dark:text-amber-400">
                                ⚠️ Ya asignado a: <strong>{{ $equipoGpsOcupado->nombre }}</strong>
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-400">
                            No disponible
                        </span>
                    </div>
                @else
                    <x-form.toggle wire:model.live="es_equipo_gps" label="Equipo GPS" md />
                    @error('es_equipo_gps')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                @endif

                {{-- Servicio de Monitoreo --}}
                @if ($monitoreoOcupado)
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-400 dark:text-gray-500">Servicio de
                                Monitoreo</span>
                            <p class="text-xs text-amber-600 dark:text-amber-400">
                                ⚠️ Ya asignado a: <strong>{{ $monitoreoOcupado->nombre }}</strong>
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-400">
                            No disponible
                        </span>
                    </div>
                @else
                    <x-form.toggle wire:model.live="es_servicio_monitoreo" label="Servicio de Monitoreo" md />
                    @error('es_servicio_monitoreo')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="closeModal" flat />
                <x-form.button label="Guardar" wire:click="save" primary spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
