<x-form.modal.card title="EXPORTAR PROGRAMACIONES" wire:model.live="openModalExport" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-12">

            <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id" placeholder="Selecciona un cliente"
                option-description="numero_documento" :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id">

            </x-form.select>
        </div>
        {{-- <div class="col-span-6 gap-2">
                                <label
                                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                    <div>Fecha de Inicial: <span class="text-sm text-red-500"> * </span></div>

                                </label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input maxlength="10" name="fecha_inicio" wire:model.live='fecha_inicio'
                                        type="text"
                                        class="form-input valid:border-emerald-300
                                    required:border-rose-300 invalid:border-rose-300 peer fechaInicio  font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                                        placeholder="Selecciona la fecha">
                                </div>
                                @error('fecha_inicio')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-6 gap-2">
                                <label
                                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                    <div>Fecha de Fin: <span class="text-sm text-red-500"> * </span></div>

                                </label>
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input maxlength="10" name="fecha_fin" wire:model.live="fecha_fin" type="text"
                                        class="form-input valid:border-emerald-300
                                    required:border-rose-300 invalid:border-rose-300 peer fechaFin  font-base pl-8 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block sm:text-sm border-gray-200 rounded-md text-black input w-full"
                                        placeholder="Selecciona la fecha">
                                </div>
                                @error('fecha_fin')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div> --}}

        <div class="col-span-12 mt-2">
            <label
                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                <div>
                    Estado de programacion:
                </div>

            </label>
            <div class="flex flex-wrap items-center -m-3">

                <div class="m-3">
                    <!-- Start -->
                    <label class="flex items-center">
                        <input checked type="radio" wire:model.live="estado" name="estado" value="COMPLETADA"
                            class="form-radio" />
                        <span class="text-sm ml-2">COMPLETADA</span>
                    </label>
                    <!-- End -->
                </div>
                <div class="m-3">
                    <!-- Start -->
                    <label class="flex items-center">
                        <input type="radio" wire:model.live="estado" name="estado" value="PENDIENTE"
                            class="form-radio" />
                        <span class="text-sm ml-2">PENDIENTE</span>
                    </label>
                    <!-- End -->
                </div>
                <div class="m-3">
                    <!-- Start -->
                    <label class="flex items-center">
                        <input type="radio" wire:model.live="estado" name="estado" value="CANCELADO"
                            class="form-radio" />
                        <span class="text-sm ml-2">CANCELADO</span>
                    </label>
                    <!-- End -->
                </div>
                <div class="m-3">
                    <!-- Start -->
                    <label class="flex items-center">
                        <input type="radio" wire:model.live="estado" name="estado" value="TODAS"
                            class="form-radio" />
                        <span class="text-sm ml-2">TODAS</span>
                    </label>
                    <!-- End -->
                </div>
            </div>


            @error('estado')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

        </div>
        <div class="col-span-12 sm:col-span-12">


        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="exportReport" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
