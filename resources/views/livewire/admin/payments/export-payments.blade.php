<x-form.modal.card title="EXPORTAR PAGOS" wire:model="modalExport" blur max-width="2xl">
    <div class="grid grid-cols-12 gap-4">
        <!-- Información -->
        <div class="col-span-12">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        <p class="font-semibold mb-1">Configure los filtros para exportar</p>
                        <p>Los campos son opcionales. Si no selecciona filtros, se exportarán todos los pagos.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Método de Pago -->
        <div class="col-span-12">
            <x-form.select label="Método de Pago" wire:model.defer="payment_method_id" placeholder="Todos los métodos"
                :options="$paymentMethods" option-label="description" option-value="id" />
        </div>

        <!-- Fecha Desde -->
        <div class="col-span-12 md:col-span-6">
            <x-form.datetime.picker label="Fecha Desde" wire:model.defer="from" without-time parse-format="YYYY-MM-DD"
                placeholder="Seleccione fecha inicial" />
        </div>

        <!-- Fecha Hasta -->
        <div class="col-span-12 md:col-span-6">
            <x-form.datetime.picker label="Fecha Hasta" wire:model.defer="to" without-time parse-format="YYYY-MM-DD"
                placeholder="Seleccione fecha final" />
        </div>

        <!-- Nota informativa -->
        <div class="col-span-12">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                * El archivo Excel contendrá los pagos filtrados con columnas separadas por divisa (PEN y USD)
            </p>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Exportar" wire:click="exportar" spinner="exportar" icon="document-download" />
        </div>
    </x-slot>
</x-form.modal.card>
