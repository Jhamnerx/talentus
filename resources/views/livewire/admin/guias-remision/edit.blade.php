<div class="p-6 shadow overflow-hidden sm:rounded-md">

    <div class="px-4 py-2 bg-gray-100 sm:p-6">

        {{-- 1 --}}
        <div class="grid grid-cols-12 gap-2 mb-4">

            {{-- SERIE --}}
            <div class="col-span-12 md:col-span-6 xl:col-span-2">

                <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                    placeholder="Selecciona una serie" :async-data="[
                        'api' => route('api.series.index'),
                        'params' => ['tipo_comprobante' => '09'],
                    ]" option-label="serie" option-value="serie" />
            </div>

            {{-- CORRELATIVO --}}
            <div class="col-span-12 md:col-span-6 xl:col-span-3">

                <x-form.number readonly id="correlativo" name="correlativo" wire:model.live="correlativo"
                    label="Correlativo:" />

            </div>

            {{-- FECHA --}}
            <div class="col-span-12 sm:col-span-6 xl:col-span-4 mb-2">

                <x-form.datetime.picker label="Fecha de Emisión:" id="fecha_emision" name="fecha_emision"
                    wire:model.live="fecha_emision" :min="now()->subDays(10)" :max="now()" without-time
                    parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

            </div>

        </div>

        {{-- DATOS DESTINATARIO --}}
        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DATOS DESTINATARIO:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">

            <div class="col-span-12 sm:col-span-6 xl:col-span-2 mb-2">

                <x-form.select id="tipo_documento" name="tipo_documento" label="Tipo Documento:"
                    :options="[['name' => 'DNI', 'id' => '1'], ['name' => 'RUC', 'id' => '6']]" option-label="name"
                    option-value="id" wire:model.live="tipo_documento" :clearable="false" />

            </div>

            <div class="col-span-12 sm:col-span-6 xl:col-span-4 mb-2">

                <x-form.input wire:model.live='numero_documento' label="N° Documento:" placeholder="10203040">

                    <x-slot name="append">
                        <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                            <x-form.button wire:click.prevent='searchCliente' class="h-full rounded-r-md" icon="search"
                                primary squared />
                        </div>
                    </x-slot>

                </x-form.input>

            </div>

            <div class="col-span-12 sm:col-span-6 xl:col-span-6 mb-2 gap-2">

                <x-form.input wire:model.live='razon_social' label="Nombre/Razon Social:"
                    placeholder="Ingrese Nombre o Razon Social" />

            </div>

        </div>

        {{-- DATOS DE TRASLADO: --}}
        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DATOS DE TRASLADO:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">

            <div class="col-span-12 sm:col-span-4 mb-2">

                <x-form.select id="motivo_traslado_id" name="motivo_traslado_id" label="Motivo del traslado:"
                    wire:model.live="motivo_traslado_id" placeholder="Selecciona un motivo" :async-data="[
                        'api' => route('api.motivos.traslado.index'),
                    ]" option-label="descripcion" option-value="codigo" />

            </div>
            @if ($motivo_traslado_id == '13')
            <div class="col-span-12 sm:col-span-4 mb-2 gap-2">

                <x-form.input wire:model.live='descripcion_motivo_traslado' label="Descripción Motivo Traslado:"
                    placeholder="Ingresa un motivo" />

            </div>
            @endif

            <div class="col-span-12 sm:col-span-4 mb-2">

                <x-form.select id="modalidad_transporte_id" name="modalidad_transporte_id"
                    label="Modalidad del traslado:" searchable="false" wire:model.live="modalidad_transporte_id"
                    placeholder="Selecciona un motivo" :async-data="[
                        'api' => route('api.modalidad.traslado.index'),
                    ]" option-label="descripcion" option-value="codigo" />

            </div>

            <div class="col-span-12 sm:col-span-4 mb-2">
                <x-form.datetime.picker label="Fecha Inicio Traslado:" id="fecha_inicio_traslado"
                    name="fecha_inicio_traslado" wire:model.live="fecha_inicio_traslado" :min="now()->subDays(10)"
                    :max="now()->addDays(10)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                    :clearable="false" />
            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <x-form.number id="peso" name="peso" step="0.1" wire:model.live="peso" label="Peso Bruto (Kg):" />

            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <x-form.number id="cantidad_items" name="cantidad_items" wire:model.live="cantidad_items"
                    label="Cantidad Items:" />

            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <x-form.input wire:model.live='numero_contenedor' label="Numero Contenedor:" placeholder="0454141" />

            </div>

            <div class="col-span-6 sm:col-span-3 mb-2 ">

                <x-form.select id="code_puerto" name="code_puerto" label="Codigo Puerto:" searchable="false"
                    wire:model.live="code_puerto" placeholder="PUB" :async-data="[
                        'api' => route('api.puertos.index'),
                    ]" option-label="descripcion" option-value="descripcion" />

            </div>


        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">
            <div class="col-span-12 sm:col-span-6 mb-2">
                <div class="border-solid border-b-2 border-gray-200 mb-3">
                    <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                        PUNTO DE PARTIDA:
                    </span>
                </div>
                <div class="mb-2">
                    <x-form.input wire:model.live='direccion_partida' label="Direccion:"
                        placeholder="Direccion de partida" />

                </div>
                <div class="mb-2">

                    <x-form.select id="ubigeo_partida" name="ubigeo_partida" label="Ubigeo:"
                        wire:model.live="ubigeo_partida" placeholder="Ubigeo" :async-data="[
                            'api' => route('api.ubigeos.index'),
                        ]" option-label="option_description" option-value="ubigeo_inei" />

                </div>
                @if ($motivo_traslado_id == '04')
                <div class="grid grid-cols-12 gap-4 mb-3">

                    <div class="col-span-12 sm:col-span-4 mb-2">
                        <x-form.input wire:model.live='codigo_establecimiento_partida' label="Codigo Local:"
                            placeholder="Codigo Local de partida" />
                    </div>

                </div>
                @endif

            </div>


            <div class="col-span-12 sm:col-span-6 mb-2">
                <div class="border-solid border-b-2 border-gray-200 mb-3">
                    <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                        PUNTO DE LLEGADA:
                    </span>
                </div>
                <div class="mb-2">

                    <x-form.input wire:model.live='direccion_llegada' label="Direccion:"
                        placeholder="Direccion de llegada" />

                </div>

                <div class="mb-2">

                    <x-form.select id="ubigeo_llegada" name="ubigeo_llegada" label="Ubigeo:"
                        wire:model.live="ubigeo_llegada" placeholder="Ubigeo" :async-data="[
                            'api' => route('api.ubigeos.index'),
                        ]" option-label="option_description" option-value="ubigeo_inei" />

                </div>

                @if ($motivo_traslado_id == '04')
                <div class="grid grid-cols-12 gap-4 mb-3">

                    <div class="col-span-12 sm:col-span-4 mb-2">
                        <x-form.input wire:model.live='codigo_establecimiento_llegada' label="Codigo Local:"
                            placeholder="Codigo Local de llegada" />
                    </div>

                </div>
                @endif
            </div>


        </div>

        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DOCUMENTO DE REFERENCIA:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">


            <div
                class="col-span-12 sm:col-span-3 mb-2 {{ $motivo_traslado_id == '08' || $motivo_traslado_id == '09' ? '' : 'hidden' }}">
                <x-form.select id="docu_rel_tipo" name="docu_rel_tipo" label="Tipo Documento:"
                    wire:model.live="docu_rel_tipo" placeholder="Serie correlativo Comprobante" :async-data="[
                        'api' => route('api.prueba.index'),
                    ]" option-label="label" option-value="id" />
            </div>

            <div
                class="col-span-12 sm:col-span-3 mb-2 {{ $motivo_traslado_id == '08' || $motivo_traslado_id == '09' ? '' : 'hidden' }}">
                <x-form.input wire:model.live='docu_rel_numero' label="Número Documento:"
                    placeholder="Número documento" />
            </div>


            <div class="col-span-12 sm:col-span-6 mb-2 {{ $motivo_traslado_id == '01' ? '' : 'hidden' }}">

                <x-form.select id="venta_id" name="venta_id" label="Serie y Correlativo:" wire:model.live="venta_id"
                    placeholder="Serie correlativo Comprobante" :async-data="[
                        'api' => route('api.comprobantes.index'),
                    ]" option-label="option_description" option-value="id" />

            </div>


            <div class="col-span-12  {{ $asignarTecnico ? 'sm:col-span-3' : 'sm:col-span-6' }} mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Asignar a Tecnico Instalador? </div>
                </label>
                <div class="relative">

                    <div class="flex items-center" x-data="{ checked: false }">
                        <div class="form-switch">
                            <input value="true" wire:model.live='asignarTecnico' role="switch" type="checkbox"
                                id="switch-asign" class="sr-only" x-model="checked" />
                            <label class="bg-slate-400" for="switch-asign">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">Estado</span>
                            </label>
                        </div>
                        <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Asignar' : 'Sin Asignar'">
                        </div>
                    </div>
                </div>

            </div>

            @if ($asignarTecnico)
            <div class="col-span-12 sm:col-span-3 mb-2">
                <x-form.select id="tecnico_id" name="tecnico_id" label="Tecnico:" wire:model.live="tecnico_id"
                    placeholder="Selecciona un tecnico" :async-data="[
                            'api' => route('api.user.index'),
                        ]" option-label="name" option-value="id" />

            </div>
            @endif

        </div>

        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-2 py-2 border border-sky-600">
            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                <div class="col-span-2 sm:col-span-1">
                    <x-form.select :clearable="false" wire:model.live="selected_id" id="selected_id" name="selected_id"
                        placeholder="Seleccionar producto o servicio" :async-data="[
                            'api' => route('api.productos.index'),
                        ]" option-label="descripcion" option-value="id" option-description="option_description"
                        :template="[
                            'name' => 'user-option',
                            'config' => ['src' => 'imagen'],
                        ]" :always-fetch="true">
                        <x-slot name="beforeOptions" class="p-2 flex justify-center">
                            <x-form.button wire:click.prevent='addProductoModal(`${search}`)' x-on:click="close" primary
                                flat full>
                                <span x-html="`Registrar Producto <b>${search}</b>`"></span>
                            </x-form.button>
                        </x-slot>
                    </x-form.select>
                </div>

                <div class="col-span-2 sm:col-span-1">

                </div>
            </div>

            {{-- tabla de items --}}
            <x-admin.guias-remision.tabla-detalle :items="$items"></x-admin.guias-remision.tabla-detalle>
            @error('items')
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                {{ $message }}
            </p>
            @enderror
        </div>
        {{-- asignacion de imeis --}}

        @if ($asignarTecnico)
        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3 ">

            <h4>ARRASTRA AL PANEL EN BLACO LOS IMEIS A ASIGNAR</h4>

            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                <div class="col-span-2 sm:col-span-1">

                    <x-form.select multiselect label="SELECCIONA DISPOSITIVOS:" name="items_dispositivos"
                        wire:model.live="items_dispositivos" placeholder="357073292893290"
                        option-description="option_description" :async-data="route('api.dispositivos.index')"
                        option-label="imei" option-value="imei">

                        <x-slot name="beforeOptions" class="p-2 flex justify-center">
                            <x-form.button wire:click.prevent='registarImei(`${search}`)' x-on:click="close" primary
                                flat full>
                                <span x-html="`Registrar Imei <b>${search}</b>`"></span>
                            </x-form.button>
                        </x-slot>

                    </x-form.select>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <ul
                        class="bg-white shadow-xl overflow-hidden rounded sm:rounded-md max-w-sm mx-auto border-2 border-yellow-600">

                        @foreach ($items_dispositivos->all() as $item)
                        <li>
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg leading-6 font-medium text-blue-900">
                                        {{ $item }}<h4>

                                </div>

                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </div>
        @endif

        @if ($asignarTecnico)
        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3 ">

            <h4>ARRASTRA AL PANEL EN BLACO LOS SIM CARD A ASIGNAR</h4>

            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
                <div class="col-span-2 sm:col-span-1">

                    <x-form.select multiselect id="items_sim_card" name="items_sim_card" label="Selecciona las SIMS:"
                        wire:model.live="items_sim_card" placeholder="Selecciona un sim card" :async-data="[
                                'api' => route('api.sim.index'),
                                'params' => ['of' => '01'],
                            ]" option-label="sim_card" option-value="sim_card" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <ul
                        class="bg-white shadow-xl overflow-hidden rounded sm:rounded-md max-w-sm mx-auto border-2 border-emerald-600">

                        @foreach ($items_sim_card->all() as $item)
                        <li>
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-lg leading-6 font-medium text-blue-900">
                                        {{ $item }}<h4>

                                </div>

                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="px-4 py-3 text-right sm:px-6 col-span-12 mb-2 gap-2 ">

            <x-form.button wire:click.prevent="save" spinner="save" label="ACTUALIZAR GUIA" black lg icon="document" />
        </div>
    </div>

</div>

@push('modals')
@livewire('admin.dispositivos.save')
@endpush

@section('js')
@endsection