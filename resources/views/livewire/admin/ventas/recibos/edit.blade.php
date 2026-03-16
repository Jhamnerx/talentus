<div>
    {{-- ENCABEZADO --}}
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300 dark:border-gray-600">
        <a href="{{ route('admin.ventas.recibos.index') }}">
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                </svg>
                <span class="hidden xs:block ml-2">Atrás</span>
            </button>
        </a>
        <div class="mt-2 md:mt-0">
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">EDITAR RECIBO</h4>
        </div>
    </div>

    <div class="p-2 shadow overflow-hidden sm:rounded-md bg-white dark:bg-gray-900">
        <div class="px-4 py-2 bg-slate-100 dark:bg-gray-700 sm:p-2">

            <div class="grid grid-cols-12 gap-2">

                {{-- COLUMNA IZQUIERDA: Cliente, serie, número, fechas --}}
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="grid grid-cols-12 gap-3 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        {{-- CLIENTE --}}
                        <div class="col-span-12">
                            <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                                placeholder="Selecciona un cliente" option-description="numero_documento"
                                :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id">
                                <x-slot name="afterOptions" class="p-2 flex justify-center"
                                    x-show="displayOptions.length === 0">
                                    <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close"
                                        primary flat full>
                                        <span x-html="`Crear cliente <b>${search}</b>`"></span>
                                    </x-form.button>
                                </x-slot>
                            </x-form.select>
                        </div>

                        @if ($cliente)
                            <div class="col-span-12">
                                <x-admin.ventas.cliente-selected :cliente="$cliente" />
                            </div>
                        @endif

                        {{-- SERIE --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                                placeholder="Selecciona una serie" :async-data="[
                                    'api' => route('api.series.index'),
                                    'params' => ['tipo_comprobante' => '10'],
                                ]" option-label="serie"
                                option-value="serie" />
                        </div>

                        {{-- NÚMERO --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.number id="correlativo" name="numero" wire:model.live="numero"
                                label="Número Recibo:" readonly />
                            @error('serie_numero')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FECHA EMISIÓN --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.datetime.picker label="Fecha de Emision:" id="fecha_emision" name="fecha_emision"
                                wire:model.live="fecha_emision" :min="now()->subDays(10)" :max="now()" without-time
                                parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                        </div>

                        {{-- FECHA PAGO --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.datetime.picker label="Fecha de Pago:" id="fecha_pago" name="fecha_pago"
                                wire:model.live="fecha_pago" :min="now()->subDays(15)" :max="now()->addDays(30)" without-time
                                parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                        </div>

                    </div>
                </div>

                {{-- COLUMNA DERECHA: Moneda, forma pago, nota --}}
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="grid grid-cols-12 gap-3 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        {{-- MONEDA --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.select label="Moneda:" id="divisa" name="divisa" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]"
                                option-label="name" option-value="id" wire:model.live="divisa" :clearable="false"
                                icon="currency-dollar" />
                        </div>

                        {{-- FORMA DE PAGO --}}
                        <div class="col-span-12 md:col-span-6">
                            <x-form.select id="tipo_venta" name="tipo_venta" label="Forma Pago:" :options="[
                                ['name' => 'CONTADO', 'id' => 'CONTADO'],
                                ['name' => 'CREDITO', 'id' => 'CREDITO'],
                            ]"
                                option-label="name" option-value="id" wire:model.live="tipo_venta" :clearable="false" />
                        </div>

                        {{-- NOTA --}}
                        <div class="col-span-12">
                            <x-form.textarea label="Nota:" id="nota" name="nota" wire:model.live="nota"
                                placeholder="Ingresar nota opcional" rows="3" />
                        </div>

                    </div>
                </div>

            </div>

            {{-- SECCIÓN DE PRODUCTOS --}}
            <div
                class="mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg px-3 py-3 mx-3 border border-gray-200 dark:border-gray-600">

                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="col-span-2 sm:col-span-1" wire:ignore>
                        <x-form.select :clearable="false" wire:model.live="product_selected_id" id="product_selected_id"
                            name="product_selected_id" placeholder="Seleccionar producto o servicio" :async-data="[
                                'api' => route('api.productos.index'),
                            ]"
                            option-label="descripcion" option-value="id" option-description="option_description"
                            :template="[
                                'name' => 'user-option',
                                'config' => ['src' => 'imagen'],
                            ]" :always-fetch="true">
                            <x-slot name="beforeOptions" class="p-2 flex justify-center">
                                <x-form.button wire:click.prevent="addProductoModal(`${search}`)" x-on:click="close"
                                    primary flat full>
                                    <span x-html="`Registrar Producto <b>${search}</b>`"></span>
                                </x-form.button>
                            </x-slot>
                        </x-form.select>
                    </div>
                </div>

                {{-- TABLA DE ITEMS --}}
                <x-admin.ventas.tabla-detalle-venta :items="$items" :selected="$selected" />

                <div class="block md:flex gap-2">

                    {{-- LADO IZQUIERDO: pagos --}}
                    <div class="grid grid-cols-12 gap-4 w-full px-4 py-2 mt-5 text-gray-800 dark:text-gray-200">

                        @if ($tipo_venta === 'CONTADO')
                            <div
                                class="col-span-12 border-b border-cyan-600 dark:border-cyan-400 flex items-center justify-between">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">PAGOS</h4>
                                <span class="text-xs text-gray-400 italic">Opcional — puede registrarlo después</span>
                            </div>

                            <div class="col-span-12 mt-2">
                                <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Método de
                                                pago</th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Destino
                                            </th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                Referencia</th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Monto</th>
                                            <th class="px-2 py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @forelse($pagos_detalle as $index => $pago)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-2 py-2">
                                                    <x-form.select
                                                        wire:model.live="pagos_detalle.{{ $index }}.metodo_pago_id"
                                                        :options="$this->paymentMethods
                                                            ? $this->paymentMethods->toArray()
                                                            : []" option-label="name" option-value="id"
                                                        :clearable="false" />
                                                </td>
                                                <td class="px-2 py-2 relative z-10">
                                                    @if ($this->paymentDestinations && $this->paymentDestinations->isNotEmpty())
                                                        <x-form.select
                                                            wire:model.live="pagos_detalle.{{ $index }}.payment_destination_id"
                                                            :options="$this->paymentDestinations->toArray()" option-label="description"
                                                            option-value="id" placeholder="Seleccione destino" />
                                                    @else
                                                        <span class="text-gray-500 text-xs">Sin destinos</span>
                                                    @endif
                                                </td>
                                                <td class="px-2 py-2">
                                                    <x-form.input
                                                        wire:model.live="pagos_detalle.{{ $index }}.referencia"
                                                        placeholder="Nro. operación" />
                                                </td>
                                                <td class="px-2 py-2">
                                                    <x-form.currency
                                                        wire:model.live="pagos_detalle.{{ $index }}.monto"
                                                        prefix="{{ $simbolo }}" precision="2" thousands=","
                                                        decimal="." />
                                                </td>
                                                <td class="px-2 py-2">
                                                    <x-form.button xs negative icon="trash"
                                                        wire:click="eliminarPago({{ $index }})" />
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="px-2 py-4 text-center text-gray-400 dark:text-gray-500 italic text-xs">
                                                    Sin pagos — el recibo quedará como pendiente de pago.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-2">
                                    <x-form.button xs primary icon="plus" label="Agregar pago"
                                        wire:click="agregarPago" />
                                </div>
                            </div>
                        @else
                            {{-- Método de pago para crédito --}}
                            <div class="col-span-12 md:col-span-6">
                                <x-form.select id="forma_pago" name="forma_pago" label="MÉTODO DE PAGO:"
                                    :options="[
                                        ['name' => 'En efectivo', 'id' => '009'],
                                        ['name' => 'Depósito en cuenta', 'id' => '001'],
                                        ['name' => 'Tarjeta de débito', 'id' => '005'],
                                        ['name' => 'Tarjeta de crédito', 'id' => '006'],
                                        ['name' => 'Transferencia bancaria', 'id' => '003'],
                                        ['name' => 'Giro', 'id' => '002'],
                                    ]" option-label="name" option-value="id"
                                    wire:model.live="forma_pago" :clearable="false" />
                            </div>
                        @endif

                    </div>

                    {{-- LADO DERECHO: totales --}}
                    <div class="py-2 ml-auto mt-5 w-full mx-4">
                        <div class="text-right mb-4 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200">RESUMEN</h4>
                        </div>

                        <div class="py-2 border-t border-b border-indigo-500 dark:border-indigo-400">
                            <div class="flex justify-between">
                                <div
                                    class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                    Importe Total
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-xl text-gray-800 dark:text-gray-200 font-bold">
                                        {{ $simbolo }}<span>{{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- BARRA DE ACCIONES --}}
        <div
            class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-600 z-5">
            <div class="text-center md:text-right">
                <x-form.button wire:click.prevent="save" spinner="save" label="EDITAR RECIBO" black md
                    icon="shopping-cart" />
            </div>
        </div>

    </div>

    {{-- ── Modal selección de IMEI para equipos GPS ──────────────────────── --}}
    @if ($showImeiModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">

                {{-- Header --}}
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                            {{ $editingImeiIndex !== null ? 'Modificar IMEIs' : 'Seleccionar IMEI' }}
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $pendingGpsItem['producto'] ?? '' }}
                        </p>
                    </div>
                    <button wire:click="cancelarImei"
                        class="rounded-lg p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Contador de progreso --}}
                @php
                    $needed = (int) ($pendingGpsItem['cantidad'] ?? 1);
                    $selected = count($selectedImeis);
                @endphp
                <div class="px-6 pt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            Progreso: <strong>{{ $selected }}</strong> / <strong>{{ $needed }}</strong>
                        </span>
                        <span class="text-xs text-slate-400">
                            {{ $needed - $selected }} restante(s)
                        </span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all"
                            style="width: {{ $needed > 0 ? round(($selected / $needed) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                {{-- IMEIs ya seleccionados --}}
                @if (count($selectedImeis) > 0)
                    <div class="px-6 pt-3">
                        <p
                            class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">
                            Seleccionados
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($selectedImeis as $sIndex => $sel)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-mono
                                    bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300">
                                    {{ $sel['imei'] }}
                                    <button wire:click.prevent="quitarImeiSeleccionado({{ $sIndex }})"
                                        class="ml-0.5 hover:text-red-500 transition-colors" title="Quitar">
                                        &times;
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Búsqueda --}}
                <div class="px-6 pt-3">
                    <input wire:model.live="imeiSearch" type="text" placeholder="Buscar IMEI..."
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                </div>

                {{-- Lista de dispositivos --}}
                <div class="px-6 py-3 max-h-56 overflow-y-auto space-y-2">
                    @forelse ($this->dispositivosImei as $disp)
                        <button wire:click="confirmarImei({{ $disp->id }})"
                            class="w-full text-left flex items-center justify-between px-4 py-2.5 rounded-xl
                                border border-slate-200 dark:border-slate-600
                                hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                                transition-all group">
                            <span class="font-mono text-sm text-slate-800 dark:text-slate-100">
                                {{ $disp->imei }}
                            </span>
                            <span class="text-xs text-slate-400 group-hover:text-indigo-500">
                                {{ $disp->modelo->nombre ?? '' }}
                            </span>
                        </button>
                    @empty
                        <p class="text-center text-sm text-slate-400 py-4">
                            No hay dispositivos disponibles
                        </p>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                    <button wire:click="cancelarImei"
                        class="px-4 py-2 rounded-lg text-sm text-slate-600 dark:text-slate-400
                            hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        Cancelar
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
