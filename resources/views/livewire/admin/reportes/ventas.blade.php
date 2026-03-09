<x-form.modal.card :title="'Reporte ' .
    match ($contexto) {
        'ventas' => 'Ventas',
        'recibos' => 'Recibos',
        default => 'Ventas &amp; Recibos',
    }" name="showModal" wire:model.live="showModal" align="center" persistent>

    <div class="grid grid-cols-12 gap-4">

        {{-- ── Agrupación del Excel ────────────────────────────────────── --}}
        <div class="col-span-12">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Agrupar hojas del Excel por:
            </label>
            <div class="flex gap-2">
                <button type="button" wire:click="$set('agrupacion','mensual')" @class([
                    'px-4 py-2 text-sm font-semibold rounded-lg border transition',
                    'bg-primary-600 border-primary-600 text-white shadow' =>
                        $agrupacion === 'mensual',
                    'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400' =>
                        $agrupacion !== 'mensual',
                ])>
                    Mes
                </button>
                <button type="button" wire:click="$set('agrupacion','semanal')" @class([
                    'px-4 py-2 text-sm font-semibold rounded-lg border transition',
                    'bg-primary-600 border-primary-600 text-white shadow' =>
                        $agrupacion === 'semanal',
                    'bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-primary-400' =>
                        $agrupacion !== 'semanal',
                ])>
                    Semana
                </button>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">
                Si el rango abarca varios {{ $agrupacion === 'mensual' ? 'meses' : 'semanas' }},
                se generará una hoja por cada {{ $agrupacion === 'mensual' ? 'mes' : 'semana' }}.
            </p>
        </div>

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

        {{-- ── Tipo comprobante (solo contexto ventas o ambos) ─────────── --}}
        @if (in_array($contexto, ['ventas', 'ambos']))
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
            'sm:col-span-6' => in_array($contexto, ['ventas', 'ambos']),
        ])>
            <x-form.select autocomplete="off" id="cliente_id" name="cliente_id" label="Cliente:"
                wire:model.live="cliente_id" placeholder="Todos" :async-data="[
                    'api' => route('api.clientes.index'),
                    'params' => ['local_id' => session('local_id')],
                ]" option-label="razon_social"
                option-value="id" option-description="numero_documento" clearable />
        </div>

        {{-- ── Estado de pago ──────────────────────────────────────────── --}}
        <div class="col-span-12">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado de pago:</label>
            <div class="flex flex-wrap gap-4">
                <x-form.radio wire:model.live="estado" value="PAID" name="estado" label="Pagado" />
                <x-form.radio wire:model.live="estado" value="UNPAID" name="estado" label="Por pagar" />
                <x-form.radio wire:model.live="estado" value="Todos" name="estado" label="Todos" />
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
