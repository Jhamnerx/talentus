<x-form.modal.card title="{{ $editingId ? 'Editar Tipo de Orden' : 'Nuevo Tipo de Orden' }}" wire:model.live="showModal"
    max-width="2xl">

    <div class="space-y-4">
        {{-- Nombre --}}
        <x-form.input wire:model="nombre" label="Nombre del Tipo *" placeholder="Ej: Instalación GPS" />

        {{-- Descripción con Variables --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Descripción
                <span class="text-xs text-gray-500 font-normal ml-2">
                    (Puedes usar variables para personalizar la descripción)
                </span>
            </label>

            {{-- Botones de Variables --}}
            <div class="flex flex-wrap gap-1 mb-2">
                @foreach ($variablesDisponibles as $variable => $descripcion)
                    <button type="button" wire:click="insertarVariable('{{ $variable }}')"
                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md 
                               bg-blue-50 text-blue-700 hover:bg-blue-100 
                               dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30
                               transition-colors duration-150"
                        title="{{ $descripcion }}">
                        {{ $variable }}
                    </button>
                @endforeach
            </div>

            <x-form.textarea wire:model="descripcion"
                placeholder="Ej: Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%"
                rows="3" />

            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Las variables serán reemplazadas automáticamente al crear la orden de trabajo
            </p>
        </div>

        {{-- Costo Base --}}
        <x-form.input wire:model="costo_base" label="Costo Base (S/)" type="number" step="0.01"
            placeholder="0.00" />

        {{-- Checkboxes de Requisitos --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos</label>
            <div class="grid grid-cols-2 gap-3">
                <x-form.checkbox wire:model="requiere_imei" label="Requiere IMEI" />
                <x-form.checkbox wire:model="requiere_sim" label="Requiere SIM/ICCID" />
                <x-form.checkbox wire:model="requiere_accesorios" label="Requiere Accesorios" />
                <x-form.checkbox wire:model="requiere_checklist" label="Requiere Checklist" />
            </div>
        </div>

        {{-- Estado Activo --}}
        <div class="col-span-2">
            <x-form.toggle wire:model="is_active" label="Tipo Activo"
                description="Los tipos inactivos no aparecerán al crear órdenes" />
        </div>
    </div>

    <x-slot name="footer" class="flex justify-end gap-3">
        <x-form.button flat label="Cancelar" wire:click="$set('showModal', false)" />
        <x-form.button primary label="{{ $editingId ? 'Actualizar' : 'Guardar' }}" wire:click="guardar"
            spinner="guardar" />
    </x-slot>
</x-form.modal.card>
