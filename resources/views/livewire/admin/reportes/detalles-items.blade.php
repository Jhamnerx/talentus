<x-form.modal.card :title="'Reporte Detalles por Ítem — ' .
    match ($contexto) {
        'ventas' => 'Ventas',
        'recibos' => 'Recibos',
        default => '',
    }" name="showModal" wire:model.live="showModal" align="center" persistent>

    <div class="grid grid-cols-12 gap-4">

        {{-- ── Fechas ──────────────────────────────────────────────────── --}}
        <div class="col-span-6">
            <x-form.datetime.picker label="Desde:" id="fecha_inicio" name="fecha_inicio" wire:model.live="fecha_inicio"
                :min="now()->subYears(5)" :max="now()->addYears(1)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-6">
            <x-form.datetime.picker label="Hasta:" id="fecha_fin" name="fecha_fin" wire:model.live="fecha_fin"
                :min="$fecha_inicio" :max="now()->addYears(1)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        {{-- ── Tipo de ítem ────────────────────────────────────────────── --}}
        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Tipo de ítem:" id="tipo_item" name="tipo_item" :options="[
                ['name' => 'Todos', 'id' => 'todos'],
                ['name' => 'Producto', 'id' => 'producto'],
                ['name' => 'Servicio', 'id' => 'servicio'],
            ]" option-label="name" option-value="id" wire:model.live="tipo_item" :clearable="false" />
        </div>

        {{-- ── Tipo comprobante (solo contexto ventas) ──────────────────── --}}
        @if ($contexto === 'ventas')
            <div class="col-span-12 sm:col-span-6">
                <x-form.select label="Tipo comprobante:" id="tipo_comprobante_id" name="tipo_comprobante_id"
                    :options="[
                        ['name' => 'FACTURA ELECTRONICA', 'id' => '01'],
                        ['name' => 'BOLETA ELECTRONICA', 'id' => '03'],
                        ['name' => 'N. VENTA ELECTRONICA', 'id' => '02'],
                    ]" placeholder="Todos" option-label="name" option-value="id"
                    wire:model.live="tipo_comprobante_id" clearable />
            </div>
        @endif

        {{-- ── Cliente ─────────────────────────────────────────────────── --}}
        <div @class([
            'col-span-12',
            'sm:col-span-6' => $contexto !== 'ventas',
        ])>
            <x-form.select autocomplete="off" id="cliente_id" name="cliente_id" label="Cliente:"
                wire:model.live="cliente_id" placeholder="Todos" :async-data="[
                    'api' => route('api.clientes.index'),
                    'params' => ['local_id' => session('local_id')],
                ]" option-label="razon_social"
                option-value="id" option-description="numero_documento" clearable />
        </div>

        {{-- ── Estado del documento ────────────────────────────────────── --}}
        <div class="col-span-12">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado del documento:</label>
            <div class="flex flex-wrap gap-4">
                <x-form.radio wire:model.live="estado_doc" value="todos" name="estado_doc" label="Todos" />
                <x-form.radio wire:model.live="estado_doc" value="COMPLETADO" name="estado_doc" label="Completado" />
                <x-form.radio wire:model.live="estado_doc" value="BORRADOR" name="estado_doc" label="Borrador" />
                @if ($contexto === 'ventas')
                    <x-form.radio wire:model.live="estado_doc" value="anulado" name="estado_doc" label="Anulado" />
                @endif
            </div>
        </div>

        {{-- ── Exportar ─────────────────────────────────────────────────── --}}
        <div class="col-span-12 flex justify-center pt-2">
            <x-form.button icon="arrow-down-tray" primary label="Descargar Excel" wire:click.prevent="exportar"
                spinner="exportar" />
        </div>

    </div>

    <x-slot name="footer" class="flex justify-between gap-x-4">
        <x-form.button flat label="Cerrar" x-on:click="close" />
    </x-slot>

</x-form.modal.card>
