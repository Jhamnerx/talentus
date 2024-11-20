<div class="shadow overflow-hidden sm:rounded-md" x-data="{ vehiculosPanelOpen: @entangle('panelVehiculosOpen').live }"
    @set-vehiculosPanelOpen="vehiculosPanelOpen = $event.detail">
    <div class="px-4 py-5 bg-white sm:p-6">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 sm:col-span-4">

                <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                    placeholder="Selecciona un cliente" option-description="numero_documento"
                    :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id">

                    <x-slot name="afterOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
                        <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close" primary
                            flat full>
                            <span x-html="`Crear cliente <b>${search}</b>`"></span>
                        </x-form.button>
                    </x-slot>
                </x-form.select>

            </div>
            <div class="col-span-12 sm:col-span-4">
                <x-form.datetime.picker label="Fecha Emision:" id="fecha_emision" name="fecha_emision"
                    wire:model.live="fecha_emision" :min="now()->subDays(600)" without-time parse-format="YYYY-MM-DD"
                    display-format="DD-MM-YYYY" :clearable="false" />
            </div>
            <div class="col-span-12 sm:col-span-4">

                <x-form.datetime.picker label="Fecha Fin Contrato:" id="fecha" name="fecha" wire:model.live="fecha"
                    :min="now()->subDays(90)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                    :clearable="false" />
            </div>

            <div class="col-span-12 sm:col-span-4">
                <x-form.select label="Ciudad:" wire:model.live="ciudades_id" placeholder="Selecciona una ciudad"
                    :async-data="route('api.ciudades.index')" option-label="nombre" option-value="id">

                </x-form.select>
            </div>
            <div class="col-span-12 sm:col-span-12 mt-4">
                <span class="text-bold text-center mb-2">Caracteristicas:</span>
                <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                    <div class="m-2 w-full mt-2">

                        <x-form.toggle left-label="Fondo" lg wire:model.live="fondo" />
                    </div>

                    <div class="m-2 w-full">

                        <x-form.toggle left-label="Sello" lg wire:model.live="sello" />
                    </div>
                </div>
            </div>
            {{-- {{ $items }} --}}


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
                            Plan: $
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-span-12 mt-10 pt-4 border-2 bg-white shadow-lg rounded-lg px-3 mb-5">
                <div class="flex -mx-1 border-b px-2 py-2 ">
                    <div class="flex-auto px-5 xl:w-32 text-center">

                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">Placa</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-28 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">Plan</span>
                        </p>
                    </div>

                    <div class="flex-auto xl:w-20 text-center">
                        <p class="leading-none">
                            <span class="block uppercase tracking-wide text-sm font-bold text-gray-800">Acciones</span>
                        </p>
                    </div>
                </div>

                <div class="detallesvehiculos">

                    @if ($items->count() > 0)
                    @foreach ($items->all() as $placa => $vehiculo)
                    <div class="flex -mx-1 px-2 py-4 border-b box-border">

                        <div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-center">

                            <p class="text-gray-800 xs:text-base">{{ $vehiculo['placa'] }}</p>

                        </div>

                        <div class="flex-auto xl:w-28 text-center">

                            <input wire:model.live="items.{{ $placa }}.plan" class="form-input w-16 md:w-28 lg:w-28"
                                type="text">

                            @if ($errors->has('items.' . $placa . '.plan'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $placa . '.plan') }}
                            </p>
                            @endif


                        </div>

                        <div class="flex-auto xl:w-20 text-center">
                            <x-form.button label="Eliminar" wire:click.prevent="eliminarVehiculo('{{ $placa }}')"
                                outline red sm icon="trash" />
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

                <button type="button" @click.stop="$dispatch('vehiculosPanelOpen', true)"
                    class="btnAgregarVehiculo mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
                    wire:click.prevent="openPanelVehiculos" aria-controls="basic-modal">
                    Añadir Vehiculo
                </button>

                <div class="py-3 w-20 text-center">
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

            <button class="btnGuardarContrato cursor-pointer btn bg-emerald-500 hover:bg-emerald-600 text-white"
                wire:click.prevent="save">ACTUALIZAR</button>


        </div>
    </div>
    @livewire('admin.ventas.contratos.items-vehiculo', ['vehiculos' => $contrato->cliente->vehiculos, 'cliente' =>
    $contrato->cliente])
</div>

@push('modals')
@livewire('admin.clientes.save')
@endpush