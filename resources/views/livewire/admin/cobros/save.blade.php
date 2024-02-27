<div class="shadow overflow-hidden sm:rounded-md" x-data="{ vehiculosPanelOpen: @entangle('panelVehiculosOpen').live }"
    @set-vehiculosPanelOpen="vehiculosPanelOpen = $event.detail">
    <div class="px-4 py-2 bg-gray-50 sm:p-6">

        <div class="grid grid-cols-12 gap-2">


            <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
                {{-- CLIENTE --}}

                <div class="col-span-12 mb-2">

                    <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                        placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                        option-label="razon_social" option-value="id" hide-empty-message />

                </div>

                {{-- FECHA INICIO --}}
                <div class="col-span-6 gap-2">
                    <x-form.datetime-picker label="Fecha de Inicio: " id="fecha_inicio" name="fecha_inicio"
                        wire:model.live="fecha_inicio" without-time parse-format="YYYY-MM-DD"
                        display-format="DD-MM-YYYY" :clearable="false" />
                </div>
                {{-- FECHA CADUCIDAD --}}
                <div class="col-span-6 gap-2">
                    <x-form.datetime-picker label="Fecha de vencimiento: " id="fecha_vencimiento"
                        name="fecha_vencimiento" wire:model.live="fecha_vencimiento" without-time
                        parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                </div>

            </div>

            <div class="col-span-12 grid grid-cols-12 gap-3 md:col-span-6 border-red-600 lg:pl-6">

                <div class="col-span-12 sm:col-span-6 mb-2">

                    <x-form.select label="Periodo:" wire:model.live='periodo' name="periodo" id="periodo"
                        placeholder="selecciona un periodo" :options="[
                            ['name' => 'MENSUAL', 'id' => 'MENSUAL'],
                            ['name' => 'BIMENSUAL', 'id' => 'BIMENSUAL'],
                            ['name' => 'TRIMESTRAL', 'id' => 'TRIMESTRAL'],
                            ['name' => 'SEMESTRAL', 'id' => 'SEMESTRAL'],
                            ['name' => 'ANUAL', 'id' => 'ANUAL'],
                        ]" option-label="name" option-value="id" />
                </div>

                <div class="col-span-12 sm:col-span-6 mb-2">
                    <x-form.select label="Tipo Pago: " wire:model.live='tipo_pago' name="tipo_pago" id="tipo_pago"
                        placeholder="selecciona" :options="[['name' => 'RECIBO', 'id' => 'RECIBO'], ['name' => 'FACTURA', 'id' => 'FACTURA']]" option-label="name" option-value="id" />

                </div>

                <div class="col-span-12 sm:col-span-4 mb-2">
                    <x-form.select label="Divisa:" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]" option-label="name" option-value="id"
                        wire:model.live="divisa" :clearable="false" icon='currency-dollar' />

                </div>

            </div>
            <div class="col-span-12">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Nota
                    </div>

                </label>
                <textarea wire:model.live="nota" class="form-input w-full px-4 py-3" name="nota" id="" cols="30"
                    rows="5" placeholder="Ingresar nota (opcional)"></textarea>
            </div>


            <div class="col-span-12 sm:col-span-12 mt-4 lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Lista de Vehiculos
                    </h2>

                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            Cantidad: {{ $items->count() }}
                        </div>

                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Monto plan: $
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-span-12 mt-10 pt-4 border-2 bg-white shadow-lg rounded-lg px-3 mb-5">

                <div class="flex -mx-1 border-b px-2 py-2 ">
                    <div class="flex-auto px-5 xl:w-32 text-center">

                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">PLACA</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-28 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">MONTO
                                PLAN</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-28 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">
                                FECHA VENC.
                            </span>
                        </p>
                    </div>

                    <div class="flex-auto xl:w-20 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">ACCIONES</span>
                        </p>
                    </div>
                </div>




                <div class="flex justify-between items-center" aria-hidden="true">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                    <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                        <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                    </div>
                    <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                </div>
                <div class="detallesvehiculos">

                    @if ($items->count() > 0)
                        @foreach ($items->all() as $placa => $vehiculo)
                            <div wire:key="item-{{ $placa }}" class="flex -mx-1 px-2 py-4 border-b box-border">

                                <div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-center">

                                    <p class="text-gray-800 xs:text-base">{{ $vehiculo['placa'] }}</p>

                                </div>

                                <div class="flex-auto xl:w-28 text-center">

                                    <input wire:model.live="items.{{ $placa }}.plan"
                                        class="form-input w-16 md:w-28 lg:w-28" type="text">

                                    @if ($errors->has('items.' . $placa . '.plan'))
                                        <p class="mt-2  text-pink-600 text-sm">
                                            {{ $errors->first('items.' . $placa . '.plan') }}
                                        </p>
                                    @endif

                                </div>
                                <div class="flex-auto xl:w-28 text-center">

                                    <x-form.datetime-picker id="fecha_vencimiento_i" name="fecha_vencimiento_i"
                                        wire:model.live="items.{{ $placa }}.fecha" without-time
                                        parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                                </div>

                                <div class="flex-auto xl:w-20 text-center">

                                    <x-form.button label="Eliminar"
                                        wire:click.prevent="eliminarVehiculo('{{ $placa }}')" outline red sm
                                        icon="trash" />
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="filas flex -mx-1 px-2 py-4 border-b box-border" id="fila">
                            <div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-center">

                                <p class="text-gray-800 xs:text-base">Agregar un vehiculo</p>
                                @if ($errors->has('items'))
                                    <p class="mt-2  text-pink-600 text-sm">
                                        {{ $errors->first('items') }}
                                    </p>
                                @endif

                            </div>

                        </div>

                    @endif


                </div>


                <div class="py-3 text-left">
                    @if ($clientes_id)
                        <x-form.button spinner="openPanelVehiculos" rounded positive label="Añadir Vehiculo"
                            wire:click.prevent="openPanelVehiculos" />
                    @endif

                </div>
            </div>
        </div>

        <div class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white border-b border-slate-200">

            <div class="grid sm:grid-cols-2 gap-2 content-end">

                <div class="text-right col-span-2 ">

                    <x-form.button wire:click.prevent="save" spinner="save" label="GUARDAR" emerald md />
                </div>
            </div>
        </div>
        @livewire('admin.ventas.contratos.items-vehiculo')
    </div>


    {{ json_encode($errors->all()) }}
</div>





@section('js')
@endsection
