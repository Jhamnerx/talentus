<x-form.modal.card title="{{ $cobroId ? 'Editar Suscripción' : 'Registrar Vehículo' }}" wire:model="modalOpen" blur
    width="5xl">
    <div class="space-y-4">

        {{-- Cliente + Vehículo --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form.select label="Cliente *" wire:model.live="cliente_id" placeholder="Seleccionar cliente..."
                :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id"
                option-description="numero_documento" :clearable="false" />
            <x-form.select label="Vehículo *" wire:model="vehiculo_id" placeholder="Busca una placa..."
                :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id"
                option-description="option_description" :clearable="false" />
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
                <x-form.currency label="Monto *" wire:model="monto" thousands="." decimal="," precision="4" />
                @if ($tipo_comprobante !== 'RECIBO')
                    <p class="text-xs text-blue-500 mt-1">Incluye IGV 18%</p>
                @else
                    <p class="text-xs text-gray-400 mt-1">Sin IGV</p>
                @endif
            </div>
            <x-form.currency label="Descuento" wire:model="descuento" thousands="." decimal="," precision="4" />
        </div>

        {{-- Nota --}}
        <x-form.textarea label="Nota / Observaciones" wire:model="nota" rows="2" placeholder="Opcional..." />

        {{-- Cobrar ahora (solo al crear) --}}
        @if (!$cobroId)
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" wire:model="cobrar_ahora" id="cobrar_ahora_registrar"
                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="cobrar_ahora_registrar"
                    class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                    Cobrar ahora (emitir comprobante al guardar)
                </label>
            </div>
        @endif

    </div>

    <x-slot name="footer">
        <x-form.button flat label="Cancelar" wire:click="cerrar" />
        <x-form.button primary label="{{ $cobroId ? 'Guardar cambios' : 'Registrar' }}" wire:click="guardar"
            spinner="guardar" />
    </x-slot>
</x-form.modal.card>
