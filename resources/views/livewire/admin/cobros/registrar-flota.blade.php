<x-form.modal.card title="Registrar Flota" wire:model="modalOpen" blur width="5xl">
    <div class="space-y-4">

        {{-- Cliente --}}
        <x-form.select label="Cliente *" wire:model.live="cliente_id" placeholder="Seleccionar cliente..."
            :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id"
            option-description="numero_documento" :clearable="false" />

        {{-- Vehículos del cliente (multi-select) --}}
        <div>
            <x-form.select label="Vehículos *" wire:model="vehiculo_ids"
                placeholder="{{ $cliente_id ? 'Selecciona uno o más vehículos...' : 'Primero selecciona un cliente' }}"
                :options="$vehiculos" option-label="placa" option-value="id" option-description="marca"
                :clearable="false" multiselect :disabled="!$cliente_id" />

            @if (count($vehiculo_ids) > 0)
                <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">
                    {{ count($vehiculo_ids) }} vehículo(s) seleccionado(s)
                </p>
            @elseif ($cliente_id && $vehiculos->isEmpty())
                <p class="text-xs text-amber-500 mt-1">Este cliente no tiene vehículos registrados.</p>
            @endif
        </div>

        {{-- Plan · Período · Divisa · Tipo comprobante --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <x-form.select label="Plan *" wire:model.live="plan_id" :options="$planes" option-label="name"
                option-value="id" :clearable="false" placeholder="Seleccionar..." />
            <x-form.select label="Período *" wire:model.live="periodo" :options="[
                ['id' => 'MENSUAL',    'name' => 'Mensual'],
                ['id' => 'BIMENSUAL', 'name' => 'Bimensual'],
                ['id' => 'TRIMESTRAL','name' => 'Trimestral'],
                ['id' => 'SEMESTRAL', 'name' => 'Semestral'],
                ['id' => 'ANUAL',     'name' => 'Anual'],
            ]" option-label="name" option-value="id" :clearable="false" />
            <x-form.select label="Divisa *" wire:model.live="divisa" :options="[
                ['id' => 'PEN', 'name' => 'Soles (PEN)'],
                ['id' => 'USD', 'name' => 'Dólares (USD)'],
            ]" option-label="name" option-value="id" :clearable="false" />
            <x-form.select label="Tipo comprobante *" wire:model.live="tipo_comprobante" :options="[
                ['id' => 'FACTURA', 'name' => 'Factura / Boleta'],
                ['id' => 'RECIBO',  'name' => 'Recibo (sin IGV)'],
            ]" option-label="name" option-value="id" :clearable="false" />
        </div>

        {{-- Fechas · Monto · Descuento --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <x-form.datetime.picker label="Fecha inicio *" wire:model.live="fecha_inicio"
                parse-format="YYYY-MM-DD" display-format="DD/MM/YYYY" without-time />
            <x-form.datetime.picker label="Fecha fin" wire:model="fecha_fin"
                parse-format="YYYY-MM-DD" display-format="DD/MM/YYYY" without-time />
            <div>
                <x-form.currency label="Monto unit. *" wire:model="monto" thousands="." decimal="," precision="4" />
                @if ($tipo_comprobante !== 'RECIBO')
                    <p class="text-xs text-blue-500 mt-1">Incluye IGV 18%</p>
                @else
                    <p class="text-xs text-gray-400 mt-1">Sin IGV</p>
                @endif
            </div>
            <x-form.currency label="Descuento unit." wire:model="descuento" thousands="." decimal="," precision="4" />
        </div>

        {{-- Nota --}}
        <x-form.textarea label="Nota / Observaciones" wire:model="nota" rows="2" placeholder="Opcional..." />

        {{-- Resumen total --}}
        @if (count($vehiculo_ids) > 0 && $monto > 0)
            @php
                $montoUnit  = max(0, $monto - ($descuento ?? 0));
                $montoTotal = $montoUnit * count($vehiculo_ids);
            @endphp
            <div class="rounded-lg bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700/60 px-4 py-3 text-sm text-indigo-700 dark:text-indigo-300">
                <span class="font-medium">Resumen:</span>
                {{ count($vehiculo_ids) }} vehículo(s)
                × {{ number_format($montoUnit, 2, ',', '.') }} {{ $divisa }}
                = <span class="font-bold">{{ number_format($montoTotal, 2, ',', '.') }} {{ $divisa }}</span>
            </div>
        @endif

    </div>

    <x-slot name="footer">
        <x-form.button flat label="Cancelar" wire:click="cerrar" />
        <x-form.button primary
            label="Registrar {{ count($vehiculo_ids) > 0 ? count($vehiculo_ids) . ' vehículo(s)' : 'flota' }}"
            wire:click="guardar" spinner="guardar" />
    </x-slot>
</x-form.modal.card>
