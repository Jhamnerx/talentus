<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
        <a href="{{ route('admin.ventas.presupuestos.index') }}">
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
        <div>
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">EDITAR PRESUPUESTO</h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
                <li class="flex items-center mr-4">
                    <div class="mr-1">
                        <img class="dark:hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1.svg"
                            alt="Active">
                        <img class="dark:block hidden"
                            src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1dark.svg"
                            alt="Active">
                    </div>
                    <span>Active</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- Code block ends -->
    <div class="p-6 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-gray-50 sm:p-6">
            @error('tipo_cambio')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">

                    {{-- CLIENTE --}}
                    <div class="col-span-12 mb-2">

                        <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                            placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                            option-label="razon_social" option-value="id" hide-empty-message>

                            <x-slot name="afterOptions" class="p-2 flex justify-center"
                                x-show="displayOptions.length === 0">
                                <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close"
                                    primary flat full>
                                    <span x-html="`Crear cliente <b>${search}</b>`"></span>
                                </x-form.button>
                            </x-slot>

                        </x-form.select>

                    </div>

                    {{-- SERIE --}}
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">

                        <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                            placeholder="Selecciona una serie" :async-data="[
                                'api' => route('api.series.index'),
                                'params' => ['tipo_comprobante' => '00'],
                            ]" option-label="serie"
                            option-value="serie" hide-empty-message />
                    </div>

                    {{-- CORRELATIVO --}}
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">

                        <x-form.inputs.number readonly id="correlativo" name="correlativo" wire:model.live="correlativo"
                            label="Correlativo:" />

                    </div>

                    {{-- FECHA PRESUPUESTO --}}

                    <div class="col-span-6 gap-2">

                        <x-form.datetime-picker label="Fecha de Emision:" id="fecha" name="fecha"
                            wire:model.live="fecha" :min="now()->subDays(1)" :max="now()" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

                    </div>

                    {{-- FECHA CADUCIDAD --}}
                    <div class="col-span-6 gap-2">
                        <x-form.datetime-picker label="Fecha de Vencimiento:" id="fecha_caducidad"
                            name="fecha_caducidad" wire:model.live="fecha_caducidad" :min="now()->subDays(1)" :max="now()->addDays(15)"
                            without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

                    </div>
                </div>

                <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-red-600 lg:pl-6 gap-2">
                    {{-- moneda --}}
                    <div class="col-span-12 md:col-span-6 mb-2">

                        <x-form.select label="Moneda:" id="divisa" name="divisa" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]"
                            option-label="name" option-value="id" wire:model.live="divisa" :clearable="false"
                            icon='currency-dollar' />

                    </div>

                    <div class="col-span-12 md:col-span-6 mb-3">

                        <x-form.select id="forma_pago" name="forma_pago" label="Forma Pago:" :options="[['name' => 'CONTADO', 'id' => 'CONTADO'], ['name' => 'CREDITO', 'id' => 'CREDITO']]"
                            option-label="name" option-value="id" wire:model.live="forma_pago" :clearable="false" />

                    </div>
                    <div class="col-span-12">
                        <x-form.textarea label="Comentario:" id="comentario" name="comentario"
                            wire:model.live="comentario" placeholder="Ingresar nota opcional" />
                    </div>
                </div>

                {{-- componente venta al credito --}}
                <div class="grid grid-cols-12 col-span-12">

                    <x-admin.facturacion.detalle-cuotas-table :cuotas="$detalle_cuotas" :totalcuotas="$total_cuotas">
                    </x-admin.facturacion.detalle-cuotas-table>
                </div>


                <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3">
                    <div class="grid grid-cols-4 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                        <div class="col-span-2 sm:col-span-2">

                            <x-form.button wire:click="openModalAddProducto" spinner="openModalAddProducto"
                                label="AÑADIR" primary md icon="plus" />

                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <div class="m-2 w-full mt-1">
                                <label for="features">Mostrar Hoja Caracteristicas:</label>

                                <div class="flex items-center">
                                    <div class="form-switch">
                                        <input wire:model.live="features" type="checkbox" id="features-1"
                                            class="sr-only features" />
                                        <label class="bg-slate-400" for="features-1">
                                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                            <span class="sr-only">features switch</span>
                                        </label>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <div class="m-2 w-full mt-1">

                                <x-form.button wire:click.prevent='openModalTerminos' label="Editar Terminos" outline
                                    blue icon="pencil" />

                            </div>
                        </div>
                    </div>

                    {{-- LISTA DE PRODUCTOS --}}

                    <x-admin.facturacion.tabla-detalle :items="$items" :tipo="$tipo_comprobante_id">

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

                        </div>


                        {{-- DIV PARA SUB Y TOTALES SOLES --}}
                        <div class="py-2 ml-auto mt-5 w-full mx-4 {{ $ConvertirSoles ? '' : 'hidden' }}">
                            <div class="text-right mb-4 border-b">
                                <h4 class="font-semibold">RESUMEN SOLES</h4>
                            </div>

                            <div class="flex justify-between ">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">SUB TOTAL
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        S/ <span>{{ round($sub_total_soles, 4) }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="flex justify-between mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm text-lg">OP. GRAVADAS
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">
                                        S/ <span>{{ round($op_gravadas_soles, 4) }}</span>
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
                                            S/ <span>{{ round($op_exoneradas_soles, 4) }}</span>
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
                                            S/ <span>{{ round($op_inafectas_soles, 4) }}</span>
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
                                            S/ <span>{{ round($op_gratuitas_soles, 4) }}</span>
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
                                        S/ <span>{{ round($descuento_soles, 2) }}</span>
                                    </div>

                                </div>
                            </div>


                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">S/
                                        <span>{{ round($igv_soles, 4) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 text-right flex-1 font-medium text-sm">ICBPER</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 text-sm">S/
                                        <span>{{ number_format($icbper_soles, 2) }}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="py-2 border-t border-b border-indigo-500">
                                <div class="flex justify-between">
                                    <div class="text-gray-900 text-right flex-1 font-medium text-sm">Importe Total
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 font-bold">
                                            S/ <span>{{ round($total_soles, 4) }}</span>
                                        </div>
                                    </div>
                                </div>
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


                        </div>
                    </div>


                </div>
            </div>

            <div class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white border-b border-slate-200 z-5">

                <div class="grid gap-2 content-end">

                    <div class="text-center md:text-right">

                        <x-form.button wire:click.prevent="actualizarPresupuesto" spinner="actualizarPresupuesto"
                            label="ACTUALIZAR COTIZACION" black md icon="shopping-cart" />
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@push('modals')
    @livewire('admin.clientes.save')
    @livewire('admin.ventas.presupuestos.modal-terminos', ['terminos' => $terminos])
@endpush

@section('js')
@endsection
