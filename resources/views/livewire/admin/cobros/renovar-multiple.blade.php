<x-form.modal.card title="Renovar Períodos — Múltiples Vehículos" wire:model="modalOpen" blur width="2xl">
    <div class="space-y-4">

        {{-- Resumen de selección --}}
        <div
            class="flex items-start gap-3 p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg border border-indigo-200 dark:border-indigo-700">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-indigo-800 dark:text-indigo-200">
                    {{ $totalVehiculos }} vehículo(s) · {{ $clienteNombre }}
                </p>
                <p class="text-xs text-indigo-600 dark:text-indigo-300 mt-0.5">
                    Período: <span class="font-semibold">{{ $periodo }}</span>
                    · Divisa: <span class="font-semibold">{{ $divisa }}</span>
                </p>
            </div>
        </div>

        {{-- Lista de placas --}}
        @if (!empty($vehiculosInfo))
            <div class="flex flex-wrap gap-1.5">
                @foreach ($vehiculosInfo as $v)
                    <span
                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <span class="font-bold">{{ $v['placa'] }}</span>
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ $divisa === 'USD' ? 'USD' : 'S/.' }}
                            {{ number_format(max(0, $v['monto'] - $descuento), 2) }}
                        </span>
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Fechas y período --}}
        <div class="grid grid-cols-2 gap-4">
            <x-form.datetime.picker wire:model.live="fechaInicio" label="Fecha Inicio" parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY" without-time />
            <x-form.select wire:model.live="periodo" label="Período" :options="[
                ['name' => 'Mensual', 'id' => 'MENSUAL'],
                ['name' => 'Bimensual', 'id' => 'BIMENSUAL'],
                ['name' => 'Trimestral', 'id' => 'TRIMESTRAL'],
                ['name' => 'Semestral', 'id' => 'SEMESTRAL'],
                ['name' => 'Anual', 'id' => 'ANUAL'],
            ]" option-label="name"
                option-value="id" :clearable="false" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-form.datetime.picker wire:model="fechaFin" label="Fecha Fin" parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY" without-time />
            <x-form.input type="number" wire:model.live="descuento" label="Descuento (por vehículo)" min="0"
                step="0.01" hint="Se resta del monto individual de cada cobro" />
        </div>

        <x-form.textarea wire:model="observaciones" label="Observaciones (opcional)" rows="2" />

        <div class="flex items-center gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
            <x-form.checkbox wire:model="cobrarAhora" id="cobrar-ahora-multiple-check" />
            <label for="cobrar-ahora-multiple-check" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                Generar comprobante ahora
            </label>
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="cerrar" />
            <x-form.button primary label="Renovar {{ $totalVehiculos }} vehículo(s)" wire:click="renovar"
                wire:loading.attr="disabled" spinner="renovar" />
        </div>
    </x-slot>
</x-form.modal.card>
