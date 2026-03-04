<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300 dark:border-gray-700">
        <!-- Add customer button -->
        <a href="{{ route('admin.compras.index') }}">
            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                </svg>
                <span class="hidden xs:block ml-2">Atras</span>
            </button>
        </a>
        <div class="mt-2 md:mt-0">
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">REGISTRAR COMPRA</h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            </ul>
        </div>
    </div>
    <!-- Code block ends -->
    <div class="p-2 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-slate-100 dark:bg-gray-800 sm:p-2">
            <div class="grid grid-cols-12 gap-2">

                <div
                    class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 dark:border-gray-700 pr-4 gap-2 bg-white dark:bg-gray-900 items-start border border-gray-200 dark:border-gray-700 rounded-md m-3 p-4">

                    <div class="col-span-12 xs:col-span-6">
                        <x-form.select label="Tipo comprobante:" id="tipo_comprobante_id" name="tipo_comprobante_id"
                            :options="[
                                ['name' => 'FACTURA ELECTRONICA', 'id' => '01'],
                                ['name' => 'BOLETA ELECTRONICA', 'id' => '03'],
                                ['name' => 'N. VENTA ELECTRONICA', 'id' => '02'],
                            ]" option-label="name" option-value="id"
                            wire:model.live="tipo_comprobante_id" :clearable="false" />
                    </div>


                    <div class="col-span-12 md:col-span-3">
                        <x-form.input label="Serie Doc.:" wire:model.blur="serie" placeholder="F001" />
                    </div>

                    <div class="col-span-12 md:col-span-3">
                        <x-form.input label="Correlativo Doc.:" wire:model.live="correlativo" placeholder="001" />
                    </div>


                    {{-- PROVEEDOR --}}
                    <div class="col-span-12 md:col-span-8">
                        <x-form.select autocomplete="off" id="proveedor_id" name="proveedor_id"
                            label="Selecciona un Proveedor:" wire:model.live="proveedor_id" :clearable="false"
                            placeholder="Escriba el nombre o número de documento del proveedor" :async-data="[
                                'api' => route('api.proveedores.index'),
                                'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                            ]"
                            option-label="razon_social" option-value="id" option-description="numero_documento">

                        </x-form.select>
                    </div>


                    {{-- FECHA Factura --}}
                    <div class="col-span-6 md:col-span-4">
                        <x-form.datetime.picker label="Fec. Emision:" id="fecha_emision" name="fecha_emision"
                            wire:model.live="fecha_emision" :min="now()->subDays(180)" :max="now()->addDays(30)" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                    </div>

                </div>

                <div
                    class="col-span-12 grid grid-cols-12 md:col-span-6  lg:pl-6 gap-2 bg-white dark:bg-gray-900 items-start border border-gray-200 dark:border-gray-700 rounded-md m-3 p-4">
                    {{-- moneda --}}
                    <div class="col-span-12 md:col-span-6 mb-2">

                        <x-form.select label="Divisa:" id="divisa" name="divisa" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]"
                            option-label="name" option-value="id" wire:model.live="divisa" :clearable="false"
                            icon='currency-dollar' />

                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <x-form.input label="Tipo Cambio sunat.:" wire:model.live="tipo_cambio" placeholder="3.741" />
                    </div>

                    {{-- FORMA DE PAGO --}}
                    <div class="col-span-12 md:col-span-6">
                        <x-form.select label="Forma de Pago:" id="forma_pago" name="forma_pago" :options="[['name' => 'CONTADO', 'id' => 'CONTADO'], ['name' => 'CREDITO', 'id' => 'CREDITO']]"
                            option-label="name" option-value="id" wire:model.live="forma_pago" :clearable="false" />
                    </div>

                    {{-- FECHA VENCIMIENTO --}}
                    <div class="col-span-12 md:col-span-6">
                        <x-form.datetime.picker label="Fecha Vencimiento:" id="fecha_vencimiento"
                            name="fecha_vencimiento" wire:model.live="fecha_vencimiento" :min="now()"
                            :max="now()->addYears(2)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                            :clearable="false" />
                    </div>

                    <div class="col-span-12">
                        <x-form.textarea label="Comentario:" id="comentario" name="comentario"
                            wire:model.live="comentario" placeholder="Escribe tu comentario" />
                    </div>

                    <div class="col-span-12">
                        <x-form.textarea label="Observación:" id="observacion" name="observacion"
                            wire:model.live="observacion" placeholder="Observaciones detalladas" rows="3" />
                    </div>

                </div>

                {{-- SECCIÓN DE CUOTAS (Solo visible cuando es CREDITO) --}}
                <div class="col-span-12 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md m-3 p-4"
                    x-show="$wire.showCredit" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Sistema de Cuotas - Pago a Crédito
                    </h3>

                    <div class="grid grid-cols-12 gap-4 mb-4">
                        <div class="col-span-12 md:col-span-4">
                            <x-form.number label="Número de Cuotas:" wire:model.live="numero_cuotas" min="1"
                                max="36" placeholder="0" />
                        </div>

                        <div class="col-span-12 md:col-span-4">
                            <x-form.number label="Días entre Cuotas:" wire:model.live="vence_cuotas" min="1"
                                max="365" placeholder="30" />
                        </div>

                        <div class="col-span-12 md:col-span-4 flex items-end">
                            <x-form.button primary label="Calcular Cuotas" wire:click="calcularCuotas(numero_cuotas)"
                                class="w-full" />
                        </div>
                    </div>

                    {{-- TABLA DE CUOTAS --}}
                    @if ($detalle_cuotas->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Días
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Fecha Vencimiento
                                        </th>
                                        <th
                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Día
                                        </th>
                                        <th
                                            class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Importe ({{ $divisa }})
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($detalle_cuotas as $index => $cuota)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                            <td
                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $cuota['n_cuota'] }}
                                            </td>
                                            <td
                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $cuota['dias'] }}
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm">
                                                <x-form.datetime.picker
                                                    wire:model.live="detalle_cuotas.{{ $index }}.fecha"
                                                    without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                                                    :clearable="false" :min="$fecha_emision" />
                                            </td>
                                            <td
                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $cuota['dia_semana'] }}
                                            </td>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-right">
                                                <x-form.currency
                                                    wire:model.live="detalle_cuotas.{{ $index }}.importe"
                                                    thousands="," decimal="." precision="2" />
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr class="bg-gray-100 dark:bg-gray-800 font-semibold">
                                        <td colspan="4"
                                            class="px-3 py-2 text-right text-sm text-gray-900 dark:text-gray-100">
                                            TOTAL CUOTAS:
                                        </td>
                                        <td class="px-3 py-2 text-right text-sm text-gray-900 dark:text-gray-100">
                                            {{ $divisa }} {{ number_format($total_cuotas, 2) }}
                                        </td>
                                    </tr>

                                    @if (abs($total_cuotas - $total) > 0.01)
                                        <tr class="bg-red-50 dark:bg-red-900/20">
                                            <td colspan="5"
                                                class="px-3 py-2 text-center text-sm text-red-600 dark:text-red-400">
                                                ⚠️ Diferencia: {{ $divisa }}
                                                {{ number_format(abs($total_cuotas - $total), 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="col-span-12 mt-10 pt-4 bg-white dark:bg-gray-900 shadow-lg rounded-lg px-3">

                    <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white dark:bg-gray-900 px-3 mb-2">
                        <div class="col-span-2 sm:col-span-1">
                            <x-form.select autocomplete="off" :clearable="false" wire:model.live="product_selected_id"
                                id="product_selected_id" name="product_selected_id"
                                placeholder="Seleccionar producto o servicio" :async-data="[
                                    'api' => route('api.productos.index'),
                                    'params' => ['local_id' => session('local_id')],
                                ]"
                                option-label="descripcion" option-value="id" option-description="option_description"
                                :template="[
                                    'name' => 'user-option',
                                    'config' => ['src' => 'imagen'],
                                ]" :always-fetch="true">
                            </x-form.select>
                        </div>
                        <!-- ... -->
                        <div class="col-span-2 sm:col-span-1">
                            -
                        </div>
                    </div>
                    {{-- LISTA DE PRODUCTOS --}}

                    <div class="overflow-x-auto min-h-screen">
                        <table class="w-full dark:text-gray-300">
                            <!-- Table header -->
                            <thead
                                class="text-xs font-semibold uppercase text-white dark:text-gray-100 bg-slate-800 dark:bg-gray-800 border-t border-b border-slate-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">CODIGO</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-center">CANTIDAD</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-center">DESCRIPCION</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">PRECIO</div>
                                    </th>

                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">IMPORTE TOTAL</div>
                                    </th>
                                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-left">ACCIONES</div>
                                    </th>

                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700 listaItems">
                                <!-- Row -->
                                <tr class="main bg-slate-100 dark:bg-gray-800">
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <div class="font-normal text-center">
                                            {{ $selected['codigo'] }}
                                        </div>
                                        @if ($errors->has('selected.producto_id'))
                                            <p class="mt-2 text-pink-600 text-sm">
                                                {{ $errors->first('selected.producto_id') }}
                                            </p>
                                        @endif

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-36 lg:min-w-0">

                                        <x-form.number wire:model.live="selected.cantidad" min="1"
                                            step="1" placeholder="Cantidad" />

                                        @if ($errors->has('selected.cantidad'))
                                            <p class="mt-2 text-pink-600 text-sm">
                                                {{ $errors->first('selected.cantidad') }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 ">

                                        <div class="font-normal text-center">
                                            {{ $selected['descripcion'] }}
                                        </div>

                                    </td>


                                    <td class="px-2 first:pl-5 last:pr-5 py-3 min-w-36 lg:min-w-0">
                                        <x-form.currency id="precio" name="precio"
                                            prefix="{{ $divisa == 'PEN' ? 'S/ ' : '$' }}"
                                            wire:model.blur="selected.precio" precision="6" />
                                        @if ($errors->has('selected.precio'))
                                            <p class="mt-2 text-pink-600 text-sm">
                                                {{ $errors->first('selected.precio') }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-normal text-center">
                                            {{ $selected['importe_total'] }}
                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="space-x-1">

                                            <button type="button" wire:click.prevent="agregarItem"
                                                class="text-white btn bg-cyan-500 hover:text-slate-500 ">
                                                <span class="sr-only">Añadir</span>


                                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <g fill="none" class="nc-icon-wrapper">
                                                        <path
                                                            d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
                                                            fill="currentColor">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <p class="mt-2 hidden text-pink-600 text-sm vacio">
                                        Debes añadir al menos 1 item
                                    </p>
                                </tr>

                                @foreach ($items->all() as $clave => $item)
                                    <tr wire:key="detalle-{{ $clave }}" id="fila{{ $loop->index }}">
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-normal text-center">
                                                {{ $items[$clave]['codigo'] }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                            <x-form.number wire:model.live="items.{{ $clave }}.cantidad"
                                                min="1" step="1" placeholder="Cantidad" />
                                        </td>

                                        <td class="px-2 first:pl-5 last:pr-5 py-3 ">
                                            <div class="font-normal text-center">
                                                {{ $items[$clave]['descripcion'] }}
                                            </div>
                                        </td>

                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-normal text-center">
                                                {{ $items[$clave]['precio'] }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-normal text-center">
                                                {{ $items[$clave]['importe_total'] }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <div class="space-x-1">
                                                <button type="button"
                                                    wire:click.prevent="eliminarItem({{ $clave }})"
                                                    class="text-rose-500 hover:text-rose-600 rounded-full">
                                                    <span class="sr-only">Delete</span>
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                                        <path
                                                            d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                @error('items')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </tfoot>
                        </table>
                    </div>


                    <div class="flex">
                        {{-- DIV PARA SUB Y TOTALES --}}
                        <div class="py-2 ml-auto mt-5 w-full sm:w-2/4 lg:w-1/4 mr-2">
                            <div class="flex justify-between mb-3">
                                <div class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">Sub
                                    Total</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm dark:text-gray-300">
                                        {{ $divisa == 'PEN' ? 'S/' : '$' }} <span>{{ round($sub_total, 2) }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="flex justify-between mb-4">
                                <div class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">
                                    IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm dark:text-gray-300">
                                        {{ $divisa == 'PEN' ? 'S/' : '$' }}
                                        <span>{{ round($igv, 2) }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="py-2 border-t border-b dark:border-gray-700">
                                <div class="flex justify-between">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">
                                        Total</div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold dark:text-gray-300">
                                            {{ $divisa == 'PEN' ? 'S/' : '$' }}<span>{{ round($total, 2) }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN DE MÉTODOS DE PAGO --}}
                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Métodos de Pago</h3>
                            <x-form.button wire:click="addPayment" icon="plus" primary xs label="Agregar Pago" />
                        </div>

                        @if ($pagos_detalle->count() > 0)
                            <div class="space-y-3">
                                @foreach ($pagos_detalle as $index => $pago)
                                    <div class="grid grid-cols-12 gap-2 items-end bg-gray-50 dark:bg-gray-800 p-3 rounded-lg"
                                        wire:key="pago-{{ $index }}">
                                        {{-- Método de Pago --}}
                                        <div class="col-span-12 sm:col-span-3">
                                            <x-form.select label="Método:"
                                                wire:model="pagos_detalle.{{ $index }}.metodo_pago_id"
                                                :options="$this->paymentMethods" option-label="descripcion" option-value="id"
                                                placeholder="Seleccione" />
                                        </div>

                                        {{-- Destino --}}
                                        <div class="col-span-12 sm:col-span-3">
                                            <x-form.select label="Destino:"
                                                wire:model="pagos_detalle.{{ $index }}.payment_destination_id"
                                                :options="$this->paymentDestinations" option-label="description" option-value="id"
                                                placeholder="Seleccione" />
                                        </div>

                                        {{-- Monto --}}
                                        <div class="col-span-12 sm:col-span-2">
                                            <x-form.currency label="Monto:"
                                                wire:model="pagos_detalle.{{ $index }}.monto"
                                                prefix="{{ $divisa == 'PEN' ? 'S/' : '$' }}" thousands=","
                                                decimal="." precision="2" />
                                        </div>

                                        {{-- Referencia --}}
                                        <div class="col-span-12 sm:col-span-3">
                                            <x-form.input label="Referencia:"
                                                wire:model="pagos_detalle.{{ $index }}.referencia"
                                                placeholder="Nro. operación, cheque, etc." />
                                        </div>

                                        {{-- Botón Eliminar --}}
                                        <div class="col-span-12 sm:col-span-1">
                                            <x-form.button wire:click="removePayment({{ $index }})"
                                                icon="trash" negative xs flat />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400 text-sm">
                                No se han agregado métodos de pago. Los pagos se registrarán como pendientes.
                            </div>
                        @endif
                    </div>

                    <div
                        class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white dark:bg-gray-900 border-b border-slate-200 dark:border-gray-700 z-5">
                        <div class="grid { gap-2 content-end">

                            <div class="text-center md:text-right">
                                <x-form.button wire:click.prevent="save" spinner="save" label="REGISTRAR" black md
                                    icon="shopping-cart" />
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </div>

</div>
