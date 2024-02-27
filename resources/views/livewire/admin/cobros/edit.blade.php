<div class="px-4 py-2 bg-gray-50 sm:p-6">
    <form autocomplete="off">
        <div class="grid grid-cols-12 gap-2">

            <div class="col-span-12 grid grid-cols-12 md:col-span-6 border-dashed lg:border-r-2 pr-4 gap-2">
                {{-- CLIENTE --}}
                <div class="col-span-12 mb-2">
                    <div wire:ignore>
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Cliente <span class="text-sm text-red-500"> * </span></div>
                        </label>

                        <select required name="clientes_id" id="" class="form-select w-full clientes_id pl-3">

                        </select>
                    </div>


                    @error('cliente')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- FECHA VENCIMIENTO --}}
                <div class="col-span-6 gap-2">

                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Fecha de vencimiento: <span class="text-sm text-red-500" style="display: none;"> *
                            </span>
                        </div>
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
                        <input required wire:model.live="fecha_vencimiento" name="fecha_vencimiento" type="text"
                            class="form-input fechaVencimiento
                     font-base pl-9 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black input dark:focus:border-blue-500"
                            placeholder="Selecciona la fecha">
                    </div>
                    @error('fecha_vencimiento')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="col-span-12 grid grid-cols-12 gap-3 md:col-span-6 border-red-600 lg:pl-6">

                <div class="col-span-12 sm:col-span-6 mb-2">
                    <label class="block text-sm font-medium mb-1" for="vehiculos_id">Vehiculo: <span
                            class="text-rose-500">*</span></label>

                    <div class="relative" lang="es" wire:ignore>


                        <select id="vehiculos_id" name="vehiculos_id" class="vehiculos_id w-full form-input pl-9 "
                            required></select>


                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                            <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <g class="nc-icon-wrapper">
                                    <path d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                        fill="#363636"></path>
                                    <path
                                        d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                        fill="#363636"></path>
                                    <path d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                        fill="#e3e3e3"></path>
                                    <path
                                        d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                        fill="#38a838"></path>
                                    <path
                                        d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                        fill="#78d478"></path>
                                    <circle cx="40" cy="27" r="3" fill="#fff">
                                    </circle>
                                    <circle cx="8" cy="27" r="3" fill="#fff">
                                    </circle>
                                    <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636">
                                    </path>
                                    <path d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                        fill="#49c549"></path>
                                    <circle cx="8" cy="34" r="2" fill="#f7bf26">
                                    </circle>
                                    <circle cx="40" cy="34" r="2" fill="#f7bf26">
                                    </circle>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('vehiculos_id')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <div class="col-span-12 sm:col-span-6 mb-2">

                    <label
                        class="flex text-sm not-italic items-center mb-1 font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>
                            Periodo:
                        </div>
                    </label>
                    <select wire:model.live="periodo" name="periodo" id="periodo" class="w-full form-input pl-2"
                        required>

                        <option value="MENSUAL" selected>MENSUAL</option>
                        <option value="BIMENSUAL">BIMENSUAL</option>
                        <option value="TRIMESTRAL">TRIMESTRAL</option>
                        <option value="SEMESTRAL">SEMESTRAL</option>
                        <option value="ANUAL">ANUAL</option>

                    </select>
                    @error('periodo')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                <div class="col-span-12 sm:col-span-6 mb-2">

                    <label
                        class="flex text-sm not-italic items-center mb-1 font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>
                            Tipo Pago:
                        </div>
                    </label>
                    <select wire:model.live="tipo_pago" name="tipo_pago" id="tipo_pago" class="w-full form-input pl-2"
                        required>

                        <option value="RECIBO">RECIBO</option>
                        <option value="FACTURA">FACTURA</option>

                    </select>
                    @error('tipo_pago')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-3 mb-2">

                    <label
                        class="flex text-sm not-italic items-center mb-1 font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>
                            Divisa:
                        </div>
                        <!---->
                    </label>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">

                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <g fill="none" class="nc-icon-wrapper">
                                    <path
                                        d="M11.5 17.1c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                        </div>
                        <select name="divisa" wire:model.live="divisa" id="divisa"
                            class="form-select pl-9 py-2 w-full">
                            <option value="PEN">SOLES</option>
                            <option value="USD">DOLARES</option>
                        </select>

                    </div>

                    @error('divisa')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="col-span-12 sm:col-span-3 mb-2">

                    <label class="block text-sm font-medium mb-1" for="monto_unidad">Monto: <span
                            class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">

                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <g fill="none" class="nc-icon-wrapper">
                                    <path
                                        d="M11.5 17.1c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79z"
                                        fill="currentColor"></path>
                                </g>
                            </svg>
                        </div>
                        <input required value="30" type="number" step="0.1" wire:model.live="monto_unidad"
                            class="form-input valid:border-emerald-300
                    required:border-rose-300 invalid:border-rose-300 peer font-base pl-9 py-2 outline-none focus:ring-primary-400 focus:outline-none focus:border-primary-400 block w-full sm:text-sm border-gray-200 rounded-md text-black input dark:focus:border-blue-500">

                    </div>

                    @error('monto_unidad')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
            <div class="col-span-12">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Nota
                    </div>
                    <!---->
                </label>
                <textarea wire:model.live="nota" class="form-input w-full px-4 py-3" name="nota" id="" cols="30"
                    rows="5" placeholder="Ingresar nota (opcional)"></textarea>
            </div>
            <!-- ... -->

        </div>
    </form>
    <div class="px-4 py-3 text-right sm:px-6">
        <button type="button" wire:click.prevent="updateCobro"
            class="btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 text-white">
            GUARDAR
        </button>

    </div>
</div>
