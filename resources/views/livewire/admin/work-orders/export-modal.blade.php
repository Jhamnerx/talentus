<div>
    {{-- Modal de Exportación --}}
    <x-form.modal.card title="Exportar Órdenes de Trabajo a Excel" wire:model="modalExport" max-width="2xl">
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Selecciona los parámetros para generar el reporte de órdenes de trabajo en formato Excel.
            </p>

            <x-form.select wire:model="export_tecnico_id" label="Técnico *" placeholder="Seleccione un técnico">
                @foreach ($tecnicos as $tecnico)
                    <x-select.option label="{{ $tecnico->name }}" value="{{ $tecnico->id }}" />
                @endforeach
            </x-form.select>

            <div class="grid grid-cols-2 gap-4">
                <x-form.datetime.picker wire:model="export_fecha_inicial" label="Fecha Inicial *"
                    placeholder="Seleccione fecha" without-time />

                <x-form.datetime.picker wire:model="export_fecha_final" label="Fecha Final *"
                    placeholder="Seleccione fecha" without-time />
            </div>

            <x-form.select wire:model="export_estado" label="Estado (Opcional)" placeholder="Todos los estados"
                hint="Deje vacío para exportar todos">
                <x-select.option value="">Todos</x-select.option>
                <x-select.option label="Pendiente" value="pendiente" />
                <x-select.option label="En Proceso" value="en_proceso" />
                <x-select.option label="Finalizado" value="finalizado" />
                <x-select.option label="Cancelado" value="cancelado" />
            </x-form.select>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    <strong>Nota:</strong> El archivo se descargará automáticamente con todas las órdenes de trabajo
                    del técnico seleccionado en el rango de fechas especificado.
                </p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Exportar" wire:click="exportarOrdenes" icon="document-arrow-down"
                    spinner="exportarOrdenes" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
