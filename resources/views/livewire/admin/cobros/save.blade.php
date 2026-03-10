<div class="shadow overflow-hidden sm:rounded-md">
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

                <div class="col-span-12 sm:col-span-6 mb-2">
                    <x-form.select label="Tipo de Comprobante:" wire:model.live="tipo_pago" :clearable="false"
                        icon="document-text" :options="[
                            ['label' => 'Factura / Boleta (con IGV)', 'value' => 'FACTURA'],
                            ['label' => 'Recibo', 'value' => 'RECIBO'],
                        ]" option-label="label" option-value="value"
                        hint="Factura/Boleta aplica IGV 18%. Recibo no incluye IGV." />
                    @error('tipo_pago')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="col-span-12">
                <x-form.textarea label="Nota" wire:model.live="nota" rows="5"
                    placeholder="Ingresar nota (opcional)" />
            </div>

            <div class="col-span-12 sm:col-span-4">
                <x-form.input type="number" wire:model.live="descuento_global" label="Descuento Global (por vehículo)"
                    min="0" step="0.01" hint="Se resta del monto final de todos los vehículos" />
            </div>


            <div class="col-span-12 sm:col-span-12 mt-4 lg:flex lg:items-center lg:justify-between ">
                <div class="flex-1 min-w-0 grid grid-cols-12 gap-2">
                    <div class="mt-1 col-span-12">
                        <h2
                            class="text-2xl font-bold leading-7 text-gray-900 dark:text-gray-100 sm:text-3xl sm:truncate">
                            Lista de Vehiculos
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            📦 Producto: <span class="font-semibold">Servicio de Cobro</span> (automático)
                        </p>
                    </div>

                    <div class="mt-1 col-span-12 sm:col-span-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <x-form.select label="Selecciona un Vehiculo:" wire:model.live="vehiculo_selected"
                                placeholder="Busca una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                                option-label="placa" option-value="id" />
                        </div>
                    </div>

                    <div class="mt-10 col-span-12 sm:col-span-6">
                        <x-form.button full="true" label="Agregar Vehículo" wire:click.prevent="agregarVehiculo"
                            icon="plus" />
                    </div>
                </div>

            </div>

            <div
                class="col-span-12 mt-10 pt-4 border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg rounded-lg px-3 mb-5">

                <div class="flex -mx-1 border-b border-gray-200 dark:border-gray-700 px-2 py-2 ">
                    <div class="flex-none px-2 w-16 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">ACTIVO</span>
                        </p>
                    </div>
                    <div class="flex-auto px-2 xl:w-24 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">PLACA</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-32 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">PLAN</span>
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
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">DESC.</span>
                        </p>
                    </div>
                    <div class="flex-auto xl:w-24 text-center">
                        <p class="leading-none">
                            <span
                                class="block uppercase tracking-wide text-sm font-bold text-gray-800 dark:text-gray-200">MONTO</span>
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
                    {{ json_encode($items) }}
                    @if ($items->count() >= 1)
                        @foreach ($items->all() as $placa => $vehiculo)
                            <div wire:key="item-{{ $placa }}"
                                class="flex -mx-1 px-2 py-4 border-b border-gray-200 dark:border-gray-700 box-border items-center gap-2 {{ isset($vehiculo['estado']) && $vehiculo['estado'] == 0 ? 'bg-red-50 dark:bg-red-900/20' : 'bg-white dark:bg-gray-800' }}">

                                <div class="flex-none w-16 text-center">
                                    <label class="inline-flex flex-col items-center gap-1 cursor-pointer">
                                        <input type="checkbox" @checked(($vehiculo['estado'] ?? 0) == 1)
                                            wire:click="$set('items.{{ $placa }}.estado', {{ ($vehiculo['estado'] ?? 0) == 1 ? 0 : 1 }})"
                                            class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer" />
                                        <span
                                            class="text-xs {{ isset($vehiculo['estado']) && $vehiculo['estado'] == 0 ? 'text-red-500 font-semibold' : 'text-green-600 font-semibold' }}">
                                            {{ isset($vehiculo['estado']) && $vehiculo['estado'] == 0 ? 'Inactivo' : 'Activo' }}
                                        </span>
                                    </label>
                                </div>

                                <div class="flex-auto px-1 xl:w-24 text-center">
                                    <p class="text-gray-800 dark:text-gray-200 xs:text-base font-semibold">
                                        {{ $vehiculo['placa'] }}
                                    </p>
                                </div>

                                <div class="flex-auto xl:w-32 text-center">
                                    <x-form.select wire:model.live="items.{{ $placa }}.plan_id"
                                        :options="$planes
                                            ->map(
                                                fn($p) => [
                                                    'id' => $p->id,
                                                    'name' =>
                                                        $p->name .
                                                        ' - ' .
                                                        ($p->currency ?? 'PEN') .
                                                        ' ' .
                                                        number_format($p->price, 2),
                                                ],
                                            )
                                            ->values()" option-label="name" option-value="id"
                                        placeholder="Seleccionar..." :clearable="false" />
                                </div>

                                <div class="flex-auto xl:w-28 text-center">
                                    <x-form.select wire:model.live="items.{{ $placa }}.periodo"
                                        :options="[
                                            ['value' => 'MENSUAL', 'label' => 'MENSUAL'],
                                            ['value' => 'BIMENSUAL', 'label' => 'BIMENSUAL'],
                                            ['value' => 'TRIMESTRAL', 'label' => 'TRIMESTRAL'],
                                            ['value' => 'SEMESTRAL', 'label' => 'SEMESTRAL'],
                                            ['value' => 'ANUAL', 'label' => 'ANUAL'],
                                        ]" option-label="label" option-value="value"
                                        :clearable="false" />
                                </div>

                                <div class="flex-auto xl:w-24 text-center">
                                    <x-form.input type="number"
                                        wire:model.live="items.{{ $placa }}.descuento" min="0"
                                        step="0.01" placeholder="0.00" />
                                </div>
                                <div class="flex-auto xl:w-24 text-center">
                                    <div
                                        class="px-2 py-2 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 rounded text-emerald-800 dark:text-emerald-200 font-bold text-sm">
                                        {{ $divisa }} {{ number_format($vehiculo['monto'] ?? 0, 2) }}
                                    </div>
                                </div>

                                <div class="flex-auto xl:w-32 text-center">
                                    <x-form.datetime.picker wire:model.live="items.{{ $placa }}.fecha_inicio"
                                        without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                                        :clearable="false" />
                                    @if ($errors->has('items.' . $placa . '.fecha_inicio'))
                                        <p class="mt-1 text-pink-600 text-xs">
                                            {{ $errors->first('items.' . $placa . '.fecha_inicio') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex-auto xl:w-32 text-center">
                                    <x-form.datetime.picker
                                        wire:model.live="items.{{ $placa }}.fecha_vencimiento" without-time
                                        parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                                    @if ($errors->has('items.' . $placa . '.fecha_vencimiento'))
                                        <p class="mt-1 text-pink-600 text-xs">
                                            {{ $errors->first('items.' . $placa . '.fecha_vencimiento') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex-auto xl:w-20 text-center">
                                    <x-form.button label="Eliminar"
                                        wire:click.prevent="eliminarVehiculo('{{ $placa }}')" outline red sm
                                        icon="trash" />
                                </div>

                            </div>
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
