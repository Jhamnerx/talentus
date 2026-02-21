<div class="shadow overflow-hidden sm:rounded-md" @set-vehiculosPanelOpen="vehiculosPanelOpen = $event.detail">
    <div class="px-4 py-2 bg-gray-50 dark:bg-gray-900 sm:p-6">

        <div class="grid grid-cols-12 gap-2">


            <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
                {{-- CLIENTE --}}
                <div class="col-span-12 mb-2">
                    <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                        placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                        option-label="razon_social" option-value="id" />
                </div>
            </div>

            <div class="col-span-12 grid grid-cols-12 gap-3 md:col-span-6 border-red-600 lg:pl-6">
                <div class="col-span-12 sm:col-span-6 mb-2">
                    <x-form.select label="Divisa:" :options="[['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]" option-label="name" option-value="id"
                        wire:model.live="divisa" :clearable="false" icon='currency-dollar' />
                </div>

                {{-- Valores por defecto para nuevos vehículos --}}
                <div class="col-span-12 sm:col-span-6 mb-2">
                    <x-form.select label="Periodo por defecto:" wire:model.live='default_periodo'
                        placeholder="Periodo para nuevos vehículos" :options="[
                            ['name' => 'MENSUAL', 'id' => 'MENSUAL'],
                            ['name' => 'BIMENSUAL', 'id' => 'BIMENSUAL'],
                            ['name' => 'TRIMESTRAL', 'id' => 'TRIMESTRAL'],
                            ['name' => 'SEMESTRAL', 'id' => 'SEMESTRAL'],
                            ['name' => 'ANUAL', 'id' => 'ANUAL'],
                        ]" option-label="name"
                        option-value="id" />
                </div>
            </div>
            <div class="col-span-12">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap justify-between">
                    <div>Nota
                    </div>

                </label>
                <textarea wire:model.live="nota"
                    class="form-input w-full px-4 py-3 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700" name="nota"
                    id="" cols="30" rows="5" placeholder="Ingresar nota (opcional)"></textarea>
            </div>


            <div class="col-span-12 sm:col-span-12 mt-4 lg:flex lg:items-center lg:justify-between ">
                <div class="flex-1 min-w-0 grid grid-cols-12 gap-2">
                    <div class="mt-1 col-span-12">
                        <h2
                            class="text-2xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-3xl sm:truncate">
                            Lista de Vehiculos
                        </h2>

                    </div>
                    <div class="mt-1 col-span-12 sm:col-span-6">


                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <x-form.select label="Selecciona un Vehiculo:" wire:model.live="vehiculo_selected"
                                placeholder="Busca una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                                option-label="placa" option-value="id" />
                        </div>
                    </div>
                    <div class="mt-10 col-span-12 sm:col-span-2">
                        <x-form.button label="Agregar" wire:click.prevent="agregarVehiculo" icon="plus" />
                    </div>
                    <div class="mt-1 col-span-12 sm:col-span-4">
                        <x-form.select label="Producto asociado:" autocomplete="off" :clearable="false"
                            wire:model.live="producto_id" id="producto_id" name="producto_id"
                            placeholder="Seleccionar producto o servicio" :async-data="[
                                'api' => route('api.productos.index'),
                                'params' => ['local_id' => session('local_id')],
                            ]" option-label="descripcion"
                            option-value="id" option-description="option_description" :template="[
                                'name' => 'user-option',
                                'config' => ['src' => 'imagen'],
                            ]"
                            :always-fetch="true">
                        </x-form.select>
                    </div>
                </div>

            </div>

            <div
                class="col-span-12 mt-10 pt-4 border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg rounded-lg px-3 mb-5">

                <div class="flex -mx-1 border-b border-gray-200 dark:border-gray-700 px-2 py-2 ">
                    <div class="flex-auto px-2 xl:w-24 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">PLACA</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-28 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">PERIODO</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-24 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">PLAN</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-32 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">F.
                                INICIO</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-32 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">F.
                                VENC.</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-20 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">ACCIONES</span>
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
                    {{-- ITEMS --}}

                    @if ($items->count() > 0)
                        @foreach ($items as $placa => $vehiculo)
                            @if (isset($placa) && !empty($placa))
                                <div wire:key="item-{{ $placa }}"
                                    class="flex -mx-1 px-2 py-4 border-b border-gray-200 dark:border-gray-700 box-border items-center gap-2 {{ isset($vehiculo['estado']) && $vehiculo['estado'] == 0 ? 'bg-red-200 dark:bg-red-900/30' : 'bg-white dark:bg-gray-800' }}">

                                    <div class="flex-auto px-1 xl:w-24 text-center">
                                        <p class="text-gray-800 dark:text-gray-200 xs:text-base font-semibold">
                                            {{ $placa }}
                                        </p>
                                    </div>

                                    <div class="flex-auto xl:w-28 text-center">
                                        <select wire:model.live="items.{{ $placa }}.periodo"
                                            class="form-select w-full text-sm dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                                            <option value="MENSUAL">MENSUAL</option>
                                            <option value="BIMENSUAL">BIMENSUAL</option>
                                            <option value="TRIMESTRAL">TRIMESTRAL</option>
                                            <option value="SEMESTRAL">SEMESTRAL</option>
                                            <option value="ANUAL">ANUAL</option>
                                        </select>
                                        @if ($errors->has('items.' . $placa . '.periodo'))
                                            <p class="mt-1 text-pink-600 text-xs">
                                                {{ $errors->first('items.' . $placa . '.periodo') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex-auto xl:w-24 text-center">
                                        @if (isset($vehiculo['plan']))
                                            <input wire:model.live="items.{{ $placa }}.plan"
                                                class="form-input w-full text-sm dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
                                                type="number" step="0.01" min="0">

                                            @if ($errors->has('items.' . $placa . '.plan'))
                                                <p class="mt-1 text-pink-600 text-xs">
                                                    {{ $errors->first('items.' . $placa . '.plan') }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="flex-auto xl:w-32 text-center">
                                        <x-form.datetime.picker
                                            wire:model.live="items.{{ $placa }}.fecha_inicio" without-time
                                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                                        @if ($errors->has('items.' . $placa . '.fecha_inicio'))
                                            <p class="mt-1 text-pink-600 text-xs">
                                                {{ $errors->first('items.' . $placa . '.fecha_inicio') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex-auto xl:w-32 text-center">
                                        <x-form.datetime.picker
                                            wire:model.live="items.{{ $placa }}.fecha_vencimiento" without-time
                                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                                            :clearable="false" />
                                        @if ($errors->has('items.' . $placa . '.fecha_vencimiento'))
                                            <p class="mt-1 text-pink-600 text-xs">
                                                {{ $errors->first('items.' . $placa . '.fecha_vencimiento') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex-auto xl:w-20 text-center">
                                        <x-form.button label="Eliminar"
                                            wire:click.prevent="eliminarVehiculo('{{ $placa }}')"
                                            spinner="eliminarVehiculo('{{ $placa }}')" outline red sm
                                            icon="trash" />
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="filas flex -mx-1 px-2 py-4 border-b border-gray-200 dark:border-gray-700 box-border"
                            id="fila">
                            <div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-center">
                                <p class="text-gray-800 dark:text-gray-300 xs:text-base">Agregar un vehículo</p>
                                @if ($errors->has('items'))
                                    <p class="mt-2 text-pink-600 text-sm">
                                        {{ $errors->first('items') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif


                </div>

            </div>
        </div>

        <div
            class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-700">

            <div class="grid sm:grid-cols-2 gap-2 content-end">

                <div class="text-right col-span-2 ">

                    <x-form.button wire:click.prevent="save" spinner="save" label="GUARDAR" emerald md />
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
@endsection
