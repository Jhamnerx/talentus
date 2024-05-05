<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <!-- Add customer button -->
        <a href="{{ route('admin.ventas.index') }}">
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
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">EMITIR
                {{ strtoupper($comprobante_slug == 'nota-venta' ? 'NOTA DE VENTA' : $comprobante_slug) }}</h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            </ul>
        </div>
    </div>
    <!-- Code block ends -->
    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 sm:p-6">
            @error('tipo_cambio')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-0 md:pr-4 gap-2">

                    {{-- CLIENTE --}}

                    <div class="col-span-12 mb-2">

                        <x-form.select autocomplete="off" id="cliente_id" name="cliente_id"
                            label="Selecciona un cliente:" wire:model.live="cliente_id"
                            placeholder="Selecciona un cliente" :async-data="[
                                'api' => route('api.clientes.index'),
                                'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                            ]" option-label="razon_social"
                            option-value="id" option-description="numero_documento" x-on:clear="$wire.direccion = ''">

                            <x-slot name="afterOptions" class="p-2 flex justify-center"
                                x-show="displayOptions.length === 0">
                                <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close"
                                    primary flat full>
                                    <span x-html="`Crear cliente <b>${search}</b>`"></span>
                                </x-form.button>
                            </x-slot>

                        </x-form.select>
                    </div>

                    <div class="col-span-12 mb-2">
                        <x-form.input autocomplete="off" id="direccion" name="direccion" label="Direccion:"
                            wire:model.live="direccion" placeholder="Ingresa direccion" />
                    </div>

                    {{-- MONEDA --}}
                    <div class="col-span-12 md:col-span-4">
                        <x-form.select label="Divisa:" id="divisa" name="divisa" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]"
                            option-label="name" option-value="id" wire:model.live="divisa" :clearable="false"
                            icon='currency-dollar' />
                    </div>

                    {{-- SERIE --}}
                    <div class="col-span-12 xs:col-span-4">

                        <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                            placeholder="Selecciona una serie" :async-data="[
                                'api' => route('api.series.index'),
                                'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                            ]" option-label="serie"
                            option-value="serie" />
                    </div>

                    {{-- CORRELATIVO --}}
                    <div class="col-span-12 xs:col-span-4">

                        <x-form.inputs.number readonly id="correlativo" name="correlativo" wire:model.live="correlativo"
                            label="Correlativo:" />

                    </div>

                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 mb-2 gap-2">
                    {{-- FECHA EMISION --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">
                        <div class="col-span-12 md:col-span-6">

                            <x-form.datetime-picker label="Fecha de Emision:" id="fecha_emision" name="fecha_emision"
                                wire:model.live="fecha_emision" :min="now()->subDays(1)" :max="now()" without-time
                                parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

                        </div>
                    </div>

                    {{-- FECHA CADUCIDAD --}}
                    <div class="col-span-12 xs:col-span-6 gap-2">
                        <x-form.datetime-picker label="Fecha Vencimiento:" id="fecha_vencimiento"
                            name="fecha_vencimiento" wire:model.live="fecha_vencimiento" :min="now()->subDays(1)"
                            :max="now()->addDays(7)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                            :clearable="false" />
                    </div>

                    {{-- TIPO DE VENTA --}}
                    @if ($tipo_comprobante_id == '01')
                        <div class="col-span-12 md:col-span-4 mb-3">

                            <x-form.select id="forma_pago" name="forma_pago" label="Forma Pago:" :options="[
                                ['name' => 'CONTADO', 'id' => 'CONTADO'],
                                ['name' => 'CREDITO', 'id' => 'CREDITO'],
                            ]"
                                option-label="name" option-value="id" wire:model.live="forma_pago" :clearable="false" />

                        </div>
                        @if (!$deduce_anticipos)
                            <div class="col-span-6 sm:col-span-4">
                                <x-form.checkbox left-label="Operación con Detraccion:" value="true" id="detraccion"
                                    name="detraccion" lg wire:model.live="detraccion" />
                            </div>
                        @endif

                        @if ($detraccion)
                            <div class="col-span-6 sm:col-span-4">
                                <x-form.button xs wire:click="openModalDetraccion" spinner="openModalDetraccion" outline
                                    primary label="Informacion de la detraccion" />
                            </div>
                            @error('datosDetraccion')
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                            <div class="col-span-6">
                                <x-form.card title="Datos de detracción">
                                    <ol>
                                        <li>
                                            <span class="font-semibold">Cuenta Bancaria:</span>
                                            {{ $datosDetraccion['cuenta_bancaria'] }}
                                        </li>
                                        <li>
                                            <span class="font-semibold">Codigo Detraccion:</span>
                                            {{ $datosDetraccion['codigo_detraccion'] }}
                                        </li>

                                        <li>
                                            <span class="font-semibold">Porcentaje:</span>
                                            {{ $datosDetraccion['porcentaje'] }}
                                        </li>
                                        <li>
                                            <span class="font-semibold">Monto:</span>
                                            {{ $datosDetraccion['monto'] }}
                                        </li>
                                    </ol>
                                </x-form.card>
                            </div>

                            @if (
                                $errors->has('datosDetraccion.cuenta_bancaria') ||
                                    $errors->has('datosDetraccion.codigo_detraccion') ||
                                    $errors->has('datosDetraccion.metodo_pago_id') ||
                                    $errors->has('datosDetraccion.porcentaje') ||
                                    $errors->has('datosDetraccion.monto'))
                                <div class="col-span-12">
                                    <p class="mt-2  text-pink-600 text-sm">
                                        {{ $errors->first('datosDetraccion.cuenta_bancaria') }}
                                        <br>
                                        {{ $errors->first('datosDetraccion.codigo_detraccion') }}
                                        <br>
                                        {{ $errors->first('datosDetraccion.metodo_pago_id') }}
                                        <br>
                                        {{ $errors->first('datosDetraccion.porcentaje') }}
                                        <br>
                                        {{ $errors->first('datosDetraccion.monto') }}
                                    </p>
                                </div>
                            @endif

                            <x-form.modal.card title="Información de Detracción" max-width='lg'
                                wire:model.live="openModalDt" align="center">

                                <div
                                    class="grid grid-cols-12 gap-6 text-sm col-span-12 rounded-lg shadow-lg bg-white text-center border border-gray-300 px-4 py-4">

                                    <div class="col-span-12">

                                        <span class="font-semibold">La información de detraccion siempre se registrará
                                            en
                                            moneda nacional "SOL"
                                            independiente de la moneda
                                            del comprobante.</span>
                                    </div>

                                    <div class="col-span-12">

                                        <x-form.select autocomplete="off" id="codigo_detraccion"
                                            name="codigo_detraccion"
                                            label="código de bien/servicio sujeto a detracción*:"
                                            wire:model.live="datosDetraccion.codigo_detraccion"
                                            placeholder="Selecciona" :async-data="[
                                                'api' => route('api.detracciones.index'),
                                            ]" option-label="descripcion"
                                            option-value="codigo" />

                                    </div>
                                    <div class="col-span-12 sm:col-span-6">

                                        <x-form.input wire:model.live="datosDetraccion.cuenta_bancaria"
                                            label="Nro. Cta. Banco de la Nación:" placeholder="" />

                                    </div>
                                    <div class="col-span-12 sm:col-span-6">

                                        <x-form.select autocomplete="off" id="metodo_pago_id" name="metodo_pago_id"
                                            label="Medio de pago:" wire:model.live="datosDetraccion.metodo_pago_id"
                                            placeholder="Selecciona" :async-data="[
                                                'api' => route('api.metodos.pago.index'),
                                            ]" option-label="descripcion"
                                            option-value="codigo" />
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">

                                        <x-form.input wire:model.live="datosDetraccion.porcentaje"
                                            label="Porcentaje de detracción:" placeholder="12" />

                                    </div>

                                    <div class="col-span-12 sm:col-span-6">

                                        <x-form.input wire:model.live="datosDetraccion.monto"
                                            label="Monto de detracción:" placeholder="0.00" />

                                    </div>

                                </div>
                            </x-form.modal.card>
                        @endif

                    @endif
                </div>

                {{-- componente venta al credito --}}
                <div class="grid grid-cols-12 col-span-12">

                    <x-admin.facturacion.detalle-cuotas-table :cuotas="$detalle_cuotas" :totalcuotas="$total_cuotas">
                    </x-admin.facturacion.detalle-cuotas-table>
                </div>
                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">

                    <div class="grid grid-cols-5 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

                        <div class="col-span-2 sm:col-span-2">

                            <x-form.button wire:click="openModalAddProducto" spinner="openModalAddProducto"
                                label="AÑADIR" primary md icon="plus" />

                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <x-form.checkbox left-label="Disminuir Stock:" value="true" lg id="decrease_stock"
                                wire:model.live="decrease_stock" />
                        </div>
                        @if (!$deduce_anticipos)
                            <div class="col-span-2 sm:col-span-1">
                                <x-form.checkbox
                                    left-label="Indique si la {{ $comprobante_slug }} se emite por un Pago Anticipado"
                                    value="true" lg id="pago_anticipado" wire:model.live="pago_anticipado" />
                            </div>
                        @endif
                        @if (!$pago_anticipado && !$detraccion)
                            <div class="col-span-2 sm:col-span-1">
                                <x-form.checkbox
                                    left-label="Indique si la {{ $comprobante_slug }} tiene Descuentos o Deduce Anticipos"
                                    value="true" lg wire:model.live="deduce_anticipos" id="deduce_anticipos" />
                            </div>
                        @endif
                    </div>

                    {{-- LISTA DE PRODUCTOS --}}

                    <x-admin.facturacion.tabla-detalle :items="$items" :prepayments="$prepayments" :tipo="$tipo_comprobante_id">

                    </x-admin.facturacion.tabla-detalle>


                    <div class="block md:flex gap-2">
                        {{-- LADO IZQUIERDO --}}
                        <div class="grid grid-cols-12 gap-4 w-full px-4 mx-4 py-2 ml-auto mt-5">

                            {{-- TIPO DESCUENTO --}}
                            <div class="col-span-12 border-b border-cyan-600">
                                <h4 class="font-semibold">DESCUENTO</h4>
                            </div>

                            <div class="col-span-12 md:col-span-12">

                                <div class="flex flex-wrap gap-4">
                                    <div class="mt-2 flex gap-5">
                                        <x-form.radio value="cantidad" id="left-label" md left-label="S/"
                                            wire:model.live="tipo_descuento" />
                                        {{-- <x-radio value="porcentaje" id="right-label" md label="%"
                                            wire:model.live="tipo_descuento" /> --}}
                                    </div>


                                    <x-form.inputs.currency id="descuento_monto" name="descuento_monto"
                                        icon="currency-dollar" placeholder="Monto descuento"
                                        wire:model.live.lazy="descuento_monto" thousands="." decimal="."
                                        precision="2" />
                                </div>

                            </div>

                            {{-- FORMA DE PAGO --}}
                            <div class="col-span-12 md:col-span-6">

                                <x-form.select id="metodo_pago_id" name="metodo_pago_id" label="MÉTODO DE PAGO:"
                                    :options="[
                                        ['name' => 'En efectivo', 'id' => '009'],
                                        ['name' => 'Depósito en cuenta', 'id' => '001'],
                                        ['name' => 'Tarjeta de débito', 'id' => '005'],
                                        ['name' => 'Tarjeta de crédito', 'id' => '006'],
                                        ['name' => 'Transferencia bancaria', 'id' => '003'],
                                        ['name' => 'Giro', 'id' => '002'],
                                    ]" option-label="name" option-value="id"
                                    wire:model.live="metodo_pago_id" :clearable="false" />

                            </div>

                            {{-- COMENTARIO --}}
                            <div class="col-span-12">

                                <x-form.textarea label="Comentario:" id="comentario" name="comentario"
                                    wire:model.live="comentario" placeholder="Escribe tu comentario" />
                            </div>

                        </div>

                        {{-- DIV PARA SUB Y TOTALES DERECHA --}}
                        <div class="py-2 ml-auto mt-5 w-full mx-4">
                            <div class="text-right mb-4 border-b">
                                <h4 class="font-semibold">RESUMEN</h4>
                            </div>

                            <div class="flex justify-between ">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">SUB TOTAL
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($sub_total, 4) }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="flex justify-between ">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">ANTICIPOS
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($total_anticipos, 4) }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="flex justify-between mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP. GRAVADAS
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($op_gravadas, 4) }}</span>
                                    </div>

                                </div>
                            </div>

                            @if ($op_exoneradas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        EXONERADAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($op_exoneradas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if ($op_inafectas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        INAFECTAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($op_inafectas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            @if ($op_gratuitas > 0)
                                <div class="flex justify-between mt-2">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP.
                                        GRATUITAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 text-sm">
                                            {{ $simbolo }} <span>{{ round($op_gratuitas, 4) }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="flex justify-between mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">DESCUENTO
                                    (-)
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        {{ $simbolo }} <span>{{ round($descuento, 2) }}</span>
                                    </div>

                                </div>
                            </div>


                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ round($igv, 4) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">ICBPER</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">{{ $simbolo }}
                                        <span>{{ number_format($icbper, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="py-2 border-t border-b border-indigo-500">
                                <div class="flex justify-between">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Importe Total
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold">
                                            {{ $simbolo }}<span>{{ round($total, 4) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($showCredit)
                                {{-- <div class="py-2 border-b ">
                                    <div class="flex justify-between">
                                        <div class="text-gray-900 text-right flex-1 font-medium text-sm">
                                            Adelanto
                                        </div>
                                        <div class="text-right w-40 pl-3">

                                            <x-form.inputs.currency id="adelanto" name="adelanto" placeholder="0.00"
                                                wire:model.live.lazy="adelanto" thousands="." decimal=","
                                                precision="4" />
                                        </div>
                                    </div>
                                </div> --}}
                            @endif

                        </div>
                    </div>

                </div>
            </div>
            {{ json_encode($errors->all()) }}
            <div class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white border-b border-slate-200 z-5">

                <div class="grid {{ $tipo_comprobante_id == '02' ? '' : 'sm:grid-cols-2' }}  gap-2 content-end">
                    @if ($tipo_comprobante_id == '01' || $tipo_comprobante_id == '03')
                        <div class="flex gap-10 w-full">
                            <div class="inline-flex items-center">
                                <label class="relative flex cursor-pointer items-center rounded-full p-3"
                                    for="metodo_1" data-ripple-dark="true">
                                    <input id="metodo_1" wire:model.live="metodo_type" value="01"
                                        type="radio"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-blue-gray-200 text-blue-500 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-blue-500 checked:before:bg-blue-500 hover:before:opacity-10" />
                                    <div
                                        class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-blue-500 opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 16 16" fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </div>
                                </label>
                                <label class="mt-px cursor-pointer select-none font-light text-gray-700 text-sm"
                                    for="metodo_1">
                                    SOLO FIRMAR E IMPRIMIR
                                </label>
                            </div>

                            <div class="inline-flex items-center">
                                <label class="relative flex cursor-pointer items-center rounded-full p-3"
                                    for="metodo_2" data-ripple-dark="true">
                                    <input id="metodo_2" wire:model.live="metodo_type" value="02"
                                        type="radio"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-blue-gray-200 text-blue-500 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-blue-500 checked:before:bg-blue-500 hover:before:opacity-10" />
                                    <div
                                        class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-blue-500 opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 16 16" fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </div>
                                </label>
                                <label class="mt-px cursor-pointer select-none font-light text-gray-700 text-sm"
                                    for="metodo_2">
                                    ENVIAR A SUNAT AHORA
                                </label>
                            </div>
                        </div>
                    @endif


                    <div class="text-center md:text-right">

                        <x-form.button wire:click.prevent="save" spinner="save" label="EMITIR COMPROBANTE" black md
                            icon="shopping-cart" />
                    </div>

                </div>
            </div>


        </div>

    </div>
    <livewire:admin.productos.modal-add-producto :deduce_anticipos="$deduce_anticipos" :comprobante_slug="$comprobante_slug" :divisa="$divisa"
        :tipo_comprobante_id="$tipo_comprobante_id" key="producto-add-">

</div>
@section('js')
@endsection

@push('modals')
@endpush
