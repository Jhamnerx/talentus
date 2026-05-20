<x-form.modal.card title="Importar Cobros desde Excel" wire:model="modalOpen" blur width="lg">

    {{-- ── Resultado del import ──────────────────────────────────── --}}
    @if ($importados !== null)
        <div class="space-y-3">
            <div class="flex gap-4">
                <div class="flex-1 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ $importados }}</p>
                    <p class="text-sm text-emerald-700">Importados</p>
                </div>
                <div class="flex-1 rounded-lg bg-amber-50 border border-amber-200 p-4 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ $omitidos }}</p>
                    <p class="text-sm text-amber-700">Omitidos</p>
                </div>
            </div>

            @if (count($errores) > 0)
                <div class="rounded-lg border border-red-200 bg-red-50 p-3">
                    <p class="text-sm font-semibold text-red-700 mb-2">
                        {{ count($errores) }} advertencia(s):
                    </p>
                    <ul class="space-y-1 max-h-48 overflow-y-auto">
                        @foreach ($errores as $error)
                            <li class="text-xs text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <x-slot name="footer">
            <x-form.button wire:click="cerrar" primary label="Cerrar" class="w-full" />
        </x-slot>

        {{-- ── Formulario de carga ─────────────────────────────────────── --}}
    @else
        <div class="space-y-4">
            {{-- Zona de carga --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Archivo Excel <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 bg-gray-50 dark:bg-gray-800 hover:border-blue-400 transition-colors cursor-pointer"
                    x-data @click="$refs.fileInput.click()">
                    <svg class="w-10 h-10 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Haz clic para seleccionar o arrastra tu archivo
                    </p>
                    <p class="text-xs text-gray-400 mt-1">.xlsx o .xls — max. 10 MB</p>

                    @if ($archivo)
                        <div class="mt-3 flex items-center gap-2 text-sm text-emerald-600 font-medium">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ $archivo->getClientOriginalName() }}
                        </div>
                    @endif

                    <input x-ref="fileInput" type="file" wire:model="archivo" accept=".xlsx,.xls" class="hidden" />
                </div>
                @error('archivo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Formato esperado --}}
            <div
                class="rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-3 text-xs text-blue-700 dark:text-blue-300">
                <p class="font-semibold mb-1">Formato esperado (fila 1 = cabecera):</p>
                <p class="font-mono leading-relaxed">CLIENTE - PLACA - PLAN - PERIODO - TIPO COMPROBANTE - MONTO PLAN -
                    DESCUENTO - DIVISA - FECHA INICIO - FECHA VENCIMIENTO - DIAS RESTANTES - ESTADO</p>
                <p class="mt-1 text-blue-600 dark:text-blue-400">Fechas en formato <strong>dd/mm/aaaa</strong>.</p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button wire:click="cerrar" flat label="Cancelar" />
                <x-form.button wire:click="importar" wire:loading.attr="disabled" wire:target="importar,archivo" primary
                    label="Importar" spinner="importar" />
            </div>
        </x-slot>
    @endif

</x-form.modal.card>
