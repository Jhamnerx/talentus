<div class="p-6 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-3 text-right sm:px-6 col-span-12 mb-2 gap-2 ">

        <button type="button" wire:click.prevent="update"
            class="btn bg-emerald-500 hover:bg-emerald-600 text-white">GUARDAR</button>

    </div>
    {!! Form::open([
        'class' => 'formularioGuia',
        'autocomplete' => 'on',
    ]) !!}
    <div class="px-4 py-2 bg-gray-100 sm:p-6">

        <div class="grid grid-cols-12 gap-2 mb-4">

            <div class="col-span-12 sm:col-span-6 xl:col-span-3 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>
                        Serie y Número Correlativo
                        <span class="text-sm text-red-500"> * </span>
                    </div>
                </label>
                <div class="relative">
                    <input name="serie_numero" id="serie_numero" wire:model.live='serie_numero'
                        class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm"
                        type="text" placeholder="T001-002" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                        <svg class="w-4 h-4 fill-current shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path
                                    d="M38,23a1,1,0,0,1-.707-.293l-6-6a1,1,0,0,1,0-1.414l8-8a1,1,0,0,1,1.414,0l6,6a1,1,0,0,1,0,1.414l-2,2a1,1,0,0,1-1.414,0L41,14.414,38.414,17l2.293,2.293a1,1,0,0,1,0,1.414l-2,2A1,1,0,0,1,38,23Z"
                                    fill="#eba40a"></path>
                                <path
                                    d="M44.061,3.939a1.5,1.5,0,0,0-2.122,0L17.923,27.956a10.027,10.027,0,1,0,2.121,2.121L44.061,6.061A1.5,1.5,0,0,0,44.061,3.939ZM12,43a7,7,0,1,1,4.914-11.978c.011.012.014.027.025.039s.027.014.039.025A6.995,6.995,0,0,1,12,43Z"
                                    fill="#ffd764"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('serie_numero')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <div class="col-span-12 sm:col-span-6 xl:col-span-4 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Fecha Emisión <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">
                    <input name="fecha_emision" autocomplete="nope" id="fecha_emision" wire:model.live='fecha_emision'
                        class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm fecha_emision"
                        type="text" placeholder="2022-09-28" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M2,41a5,5,0,0,0,5,5H41a5,5,0,0,0,5-5V16H2Z" fill="#e3e3e3"></path>
                                <path d="M41,6H7a5,5,0,0,0-5,5v5H46V11A5,5,0,0,0,41,6Z" fill="#ff7163"></path>
                                <path
                                    d="M23.239,38.894H12.359V36.6c2.891-2.922,5.36-5.363,6.175-6.414,1.382-1.784,1.136-3.3.484-3.88-1.287-1.142-3.435-.085-4.913,1.139l-1.788-2.119a7.62,7.62,0,0,1,5.557-2.225c2.88,0,4.928,1.662,4.928,4.216a6.047,6.047,0,0,1-1.549,3.949c-.826,1.032-4.8,4.855-4.8,4.855h6.781Z"
                                    fill="#aeaeae"></path>
                                <path
                                    d="M24.7,32.155q0-4.62,1.954-6.877A7.319,7.319,0,0,1,32.5,23.021a10.653,10.653,0,0,1,2.087.16V25.81a8.524,8.524,0,0,0-1.874-.213c-1.8,0-3.517.431-4.364,2.023a6.926,6.926,0,0,0-.628,2.842,4.211,4.211,0,0,1,3.513-1.809c2.937,0,4.449,2.015,4.449,4.929,0,3.271-1.916,5.4-5.3,5.4C26.6,38.979,24.7,36.12,24.7,32.155Zm5.621,4.194c1.545,0,2.182-1.16,2.182-2.725,0-1.461-.651-2.448-2.118-2.448a2.318,2.318,0,0,0-2.417,2.161C27.965,34.856,28.82,36.349,30.318,36.349Z"
                                    fill="#aeaeae"></path>
                                <path d="M11.5,12A1.5,1.5,0,0,1,10,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,11.5,12Z"
                                    fill="#363636"></path>
                                <path d="M36.5,12A1.5,1.5,0,0,1,35,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,36.5,12Z"
                                    fill="#363636"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('fecha_emision')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>



        </div>
        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DATOS DESTINATARIO:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">

            <div class="col-span-12 sm:col-span-4 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Tipo Documento <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">

                    <select name="tipo_documento" id="tipo_documento" wire:model.live='tipo_documento'
                        @change="cambiarTipoDocumento($event.target.value)"
                        class="form-select w-full pl-9 py-2 text-black text-sm">
                        <option value="RUC">RUC</option>
                        <option value="DNI">DNI</option>
                    </select>

                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                        <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g stroke-linecap="round" fill="none" stroke="currentColor" stroke-linejoin="round"
                                class="nc-icon-wrapper">
                                <path d="M2,50V14a4,4,0,0,1,4-4H58a4,4,0,0,1,4,4V50a4,4,0,0,1-4,4H6A4,4,0,0,1,2,50Z">
                                </path>
                                <line x1="12" y1="44" x2="36" y2="44"></line>
                                <line x1="44" y1="44" x2="52" y2="44"></line>
                                <rect x="12" y="20" width="10" height="8"></rect>
                                <circle cx="40" cy="26" r="2" stroke="none" fill="currentColor">
                                </circle>
                                <path d="M45.02,28.948a4.924,4.924,0,0,0,0-5.9"></path>
                                <path d="M49.861,32.5a10.94,10.94,0,0,0,0-13"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('tipo_documento')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-4 mb-2">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>N° Documento <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">
                    <input type="text" name="numero_documento" wire:model.live='numero_documento'
                        class="form-input w-full pl-2 pr-9" placeholder="Ingresa número documento">
                    <button class="absolute inset-0 left-auto group" type="button"
                        wire:click.prevent="searchCliente" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </div>
                @if ($error_msg)
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $error_msg }}
                    </p>
                @endif

                @error('numero_documento')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-4 mb-2 gap-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>
                        Nombre/Razon Social
                        <span class="text-sm text-red-500"> * </span>
                    </div>
                </label>
                <div class="relative">
                    <input name="razon_social" id="razon_social" wire:model.live='razon_social'
                        class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm"
                        type="text" placeholder="Ingrese Nombre o Razon Social" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                        <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 32 32">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path
                                    d="M29,0H3A1,1,0,0,0,2,1V31a1,1,0,0,0,1,1H29a1,1,0,0,0,1-1V1A1,1,0,0,0,29,0ZM20,7a3,3,0,1,1-3,3A3,3,0,0,1,20,7Zm-8,3a3,3,0,1,1-3,3A3,3,0,0,1,12,10ZM6,24a6,6,0,0,1,12,0Zm13.411-3a8.046,8.046,0,0,0-3.77-4.115A5.995,5.995,0,0,1,26,21Z">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('razon_social')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>


        </div>
        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DATOS DE TRASLADO:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">

            <div class="col-span-12 sm:col-span-4 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Motivo del traslado <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">

                    {!! Form::select('motivo_traslado', $motivos, null, [
                        'class' => 'form-select w-full pl-9 py-2 text-black text-sm',
                        '@change' => 'cambiarMotivo($event.target.value)',
                        'wire:model.live' => 'motivo_traslado',
                    ]) !!}

                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M4 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5zm0-6c-.83 0-1.5.67-1.5 1.5S3.17 7.5 4 7.5 5.5 6.83 5.5 6 4.83 4.5 4 4.5zm0 12c-.83 0-1.5.68-1.5 1.5s.68 1.5 1.5 1.5 1.5-.68 1.5-1.5-.67-1.5-1.5-1.5zM7 19h14v-2H7v2zm0-6h14v-2H7v2zm0-8v2h14V5H7z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('motivo_traslado')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-4 mb-2">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Modalidad del traslado <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">

                    <select name="modalidad_traslado" id="modalidad_traslado" wire:model.live='modalidad_traslado'
                        class="form-select w-full pl-9 py-2 text-black text-sm">
                        <option value="01">TRANSPORTE PRIVADO</option>
                        <option value="02">TRANSPORTE PUBLICO</option>

                    </select>
                    <button class="absolute inset-0 right-auto group" type="button" aria-label="Search">

                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                    fill="#363636"></path>
                                <path d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                    fill="#363636"></path>
                                <path d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                    fill="#e3e3e3"></path>
                                <path
                                    d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                    fill="#38a838"></path>
                                <path d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                    fill="#78d478"></path>
                                <circle cx="40" cy="27" r="3" fill="#fff"></circle>
                                <circle cx="8" cy="27" r="3" fill="#fff"></circle>
                                <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636"></path>
                                <path d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                    fill="#49c549"></path>
                                <circle cx="8" cy="34" r="2" fill="#f7bf26"></circle>
                                <circle cx="40" cy="34" r="2" fill="#f7bf26"></circle>
                            </g>
                        </svg>
                    </button>
                </div>

                @error('modalidad_traslado')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-4 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Fecha Inicio Traslado <span class="text-sm text-red-500"> * </span></div>
                </label>
                <div class="relative">
                    <input name="fecha_inicio_traslado" id="fecha_inicio_traslado" wire:model.live='fecha_inicio_traslado'
                        class="form-input w-full pl-9 py-2 outline-none focus:outline-none rounded-md text-black text-sm fecha_inicio_traslado"
                        type="text" placeholder="2022-09-28" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M2,41a5,5,0,0,0,5,5H41a5,5,0,0,0,5-5V16H2Z" fill="#e3e3e3"></path>
                                <path d="M41,6H7a5,5,0,0,0-5,5v5H46V11A5,5,0,0,0,41,6Z" fill="#ff7163"></path>
                                <path
                                    d="M23.239,38.894H12.359V36.6c2.891-2.922,5.36-5.363,6.175-6.414,1.382-1.784,1.136-3.3.484-3.88-1.287-1.142-3.435-.085-4.913,1.139l-1.788-2.119a7.62,7.62,0,0,1,5.557-2.225c2.88,0,4.928,1.662,4.928,4.216a6.047,6.047,0,0,1-1.549,3.949c-.826,1.032-4.8,4.855-4.8,4.855h6.781Z"
                                    fill="#aeaeae"></path>
                                <path
                                    d="M24.7,32.155q0-4.62,1.954-6.877A7.319,7.319,0,0,1,32.5,23.021a10.653,10.653,0,0,1,2.087.16V25.81a8.524,8.524,0,0,0-1.874-.213c-1.8,0-3.517.431-4.364,2.023a6.926,6.926,0,0,0-.628,2.842,4.211,4.211,0,0,1,3.513-1.809c2.937,0,4.449,2.015,4.449,4.929,0,3.271-1.916,5.4-5.3,5.4C26.6,38.979,24.7,36.12,24.7,32.155Zm5.621,4.194c1.545,0,2.182-1.16,2.182-2.725,0-1.461-.651-2.448-2.118-2.448a2.318,2.318,0,0,0-2.417,2.161C27.965,34.856,28.82,36.349,30.318,36.349Z"
                                    fill="#aeaeae"></path>
                                <path d="M11.5,12A1.5,1.5,0,0,1,10,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,11.5,12Z"
                                    fill="#363636"></path>
                                <path d="M36.5,12A1.5,1.5,0,0,1,35,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,36.5,12Z"
                                    fill="#363636"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('fecha_inicio_traslado')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Peso Bruto (Kg) <span class="text-sm text-red-500"> * </span></div>
                </label>
                <input type="text" name="peso" wire:model.live="peso" class="form-input w-full" placeholder="10">
                @error('peso')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Cantidad Items <span class="text-sm text-red-500"> * </span></div>
                </label>
                <input type="text" name="cantidad_items" wire:model.live="cantidad_items" class="form-input w-full"
                    placeholder="20">
                @error('cantidad_items')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <label for="numero_contenedor"
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Numero Contenedor </div>
                </label>

                <input type="text" name="numero_contenedor" autocomplete="nope" wire:model.live="numero_contenedor"
                    class="form-input w-full" placeholder="opcional">

                @error('numero_contenedor')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-6 sm:col-span-3 mb-2">

                <label for="code_puerto"
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Codigo Puerto</div>
                </label>

                <input type="text" name="code_puerto" autocomplete="nope" wire:model.live="code_puerto"
                    class="form-input w-full" placeholder="Codigo puerto | opcional">

                @error('code_puerto')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
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
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Direccion <span class="text-sm text-red-500"> * </span></div>
                    </label>

                    <input type="text" name="direccion_partida" wire:model.live="direccion_partida"
                        class="form-input w-full" placeholder="Direccion de partida">
                    @error('direccion_partida')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror

                </div>
                <div class="mb-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Ubigeo <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative" wire:ignore>
                        <select name="ubigeo_partida"
                            class="form-select w-full pl-9 py-2 text-black text-sm ubigeoPartida" id="ubigeo_partida">
                            <option selected value="{{ $guia->ubigeo_partida }}">{{ $guia->ubigeo_partida }}</option>
                        </select>
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                            <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 12 12">
                                <g fill="currentColor" class="nc-icon-wrapper">
                                    <path
                                        d="M11.854.146A.5.5,0,0,0,11.329.03l-11,4a.5.5,0,0,0-.015.934l4.8,1.921,1.921,4.8A.5.5,0,0,0,7.5,12h.008a.5.5,0,0,0,.462-.329l4-11A.5.5,0,0,0,11.854.146Z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                    </div>


                    @error('ubigeo_partida')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            <div class="col-span-12 sm:col-span-6 mb-2">
                <div class="border-solid border-b-2 border-gray-200 mb-3">
                    <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                        PUNTO DE LLEGADA:
                    </span>
                </div>
                <div class="mb-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Direccion <span class="text-sm text-red-500"> * </span></div>
                    </label>

                    <input type="text" name="direccion_llegada" autocomplete="nope"
                        wire:model.live="direccion_llegada" class="form-input w-full" placeholder="Direccion de llegada">
                    @error('direccion_llegada')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror

                </div>
                <div class="mb-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Ubigeo <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative" wire:ignore>
                        <select name="ubigeo_llegada" autocomplete="nope"
                            class="form-select w-full pl-9 py-2 text-black text-sm ubigeoLlegada" id="ubigeo_llegada">
                            <option selected value="{{ $guia->ubigeo_llegada }}">{{ $guia->ubigeo_llegada }}</option>
                        </select>
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                            <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 12 12">
                                <g fill="currentColor" class="nc-icon-wrapper">
                                    <path
                                        d="M11.854.146A.5.5,0,0,0,11.329.03l-11,4a.5.5,0,0,0-.015.934l4.8,1.921,1.921,4.8A.5.5,0,0,0,7.5,12h.008a.5.5,0,0,0,.462-.329l4-11A.5.5,0,0,0,11.854.146Z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('ubigeo_llegada')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror

                </div>
            </div>


        </div>
        <div class="border-solid border-b-2 border-gray-200 mb-3">
            <span class="font-semibold  text-base leading-tight font-sans text-gray-800 dark:text-gray-100">
                DOCUMENTO DE REFERENCIA:
            </span>
        </div>

        <div class="grid grid-cols-12 gap-4 mb-3">
            <div class="col-span-12 sm:col-span-6 mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Serie Correlativo <span class="text-sm text-red-500"> * </span></div>
                </label>

                <div class="relative" wire:ignore>

                    <select name="factura_id" wire:model.live='factura_id'
                        class="form-select w-full pl-9 py-2 text-black text-sm facturasSelect" id="factura_id">
                        @if ($guia->factura_id)
                            <option value="{{ $guia->factura_id }}">{{ $guia->factura->serie_numero }}</option>
                        @endif
                    </select>

                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 64 64">
                            <g stroke-linecap="round" fill="none" stroke="currentColor" stroke-linejoin="round"
                                class="nc-icon-wrapper">
                                <polyline data-cap="butt" points="56 20 39 20 39 3"></polyline>
                                <polygon points="56 20 56 61 8 61 8 3 39 3 56 20"></polygon>
                                <line x1="19" y1="49" x2="45" y2="49"></line>
                                <line x1="19" y1="39" x2="45" y2="39"></line>
                                <line x1="19" y1="29" x2="45" y2="29"></line>
                                <line x1="19" y1="19" x2="30" y2="19"></line>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('factura_id')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="col-span-12  {{ $asignarTecnico ? 'sm:col-span-3' : 'sm:col-span-6' }} mb-2">
                <label
                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                    <div>Asignar a Tecnico Instalador? </div>
                </label>
                <div class="relative">

                    <div class="flex items-center">
                        <div class="form-switch">
                            <input value="true" wire:model.live='asignarTecnico' role="switch"
                                @change="Asignar($data)" type="checkbox" id="switch-asign" class="sr-only" />
                            <label class="bg-slate-400" for="switch-asign">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">Estado</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            @if ($asignarTecnico)
                <div class="col-span-12 sm:col-span-3 mb-2">
                    <label
                        class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                        <div>Tecnico <span class="text-sm text-red-500"> * </span></div>
                    </label>
                    <div class="relative" wire:ignore>

                        <select name="user_id" class="form-select w-full pl-9 py-2 text-black text-sm userSelect"
                            id="user_id">
                            @if ($guia->user)
                                <option value="{{ $guia->users_id }}">{{ $guia->user->name }}</option>
                            @endif

                        </select>
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <svg class="w-4 h-4  shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 48 48">
                                <g class="nc-icon-wrapper">
                                    <path
                                        d="M45.521,39.04,27.527,5.134a3.982,3.982,0,0,0-7.054,0L2.479,39.04a4.056,4.056,0,0,0,.108,4.017A3.967,3.967,0,0,0,6.007,45H41.993a3.967,3.967,0,0,0,3.42-1.943A4.056,4.056,0,0,0,45.521,39.04Z"
                                        fill="#f7bf26"></path>
                                    <polygon points="26.286 16 25.143 32.571 22.857 32.571 21.714 16 26.286 16"
                                        fill="#363636"></polygon>
                                    <circle cx="24" cy="38" r="3" fill="#363636"></circle>
                                </g>
                            </svg>
                        </div>
                    </div>
                    @error('user')
                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif


        </div>

        <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-2 py-2">
            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 pb-4 bg-white px-3 mb-2" wire:ignore>
                <div class="col-span-2 sm:col-span-1">
                    <div class="flex">
                        <button id="productos-button"
                            class="flex-shrink-0 z-10 hidden md:inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                        </button>
                        <label for="productos" class="sr-only">Añadir Artículo</label>
                        <select id="productos"
                            class="bg-gray-50 productoSelect border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Añadir Artículo</option>
                        </select>
                    </div>
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
                {{-- <input class="form-input" type="text" wire:model.live='search'> --}}

                <x-admin.guias-remision.lista-imei :imeis="$imei_list" :imeisadd="$imeis_add">
                </x-admin.guias-remision.lista-imei>

            </div>
        @endif
        @if ($asignarTecnico)
            <div class="col-span-12 mt-10 pt-4 bg-white shadow-lg rounded-lg px-3 ">

                <h4>ARRASTRA AL PANEL EN BLACO LOS SIM CARD A ASIGNAR</h4>

                <x-admin.guias-remision.lista-sim-card :sims="$sim_list" :simadd="$sim_add">
                </x-admin.guias-remision.lista-sim-card>

            </div>
        @endif


        <div class="px-4 py-3 text-right sm:px-6 col-span-12 mb-2 gap-2 ">

            <button type="button" wire:click.prevent="update"
                class="btn bg-emerald-500 hover:bg-emerald-600 text-white">GUARDAR</button>

        </div>
    </div>

    {!! Form::close() !!}


</div>

@section('js')
    {{--
<x-laravel-blade-sortable::scripts /> --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('laravelBladeSortable', () => ({
                name: '',
                sortOrder: [],
                animation: 150,
                ghostClass: '',
                dragHandle: null,
                group: null,
                allowSort: true,
                allowDrop: true,

                wireComponent: null,
                wireOnSortOrderChange: null,
                init() {
                    this.sortOrder = this.computeSortOrderFromChildren()
                    window.Sortable.create(this.$refs.root, {
                        handle: this.dragHandle,
                        animation: this.animation,
                        ghostClass: this.ghostClass,
                        group: {
                            name: this.group,
                            put: this.allowDrop,
                        },
                        sort: this.allowSort,
                        onSort: evt => {
                            const previousSortOrder = [...this.sortOrder]
                            this.sortOrder = this.computeSortOrderFromChildren()

                            if (!this.wireComponent) {
                                return
                            }

                            const from = evt?.from?.dataset?.name
                            const to = evt?.to?.dataset?.name

                            this.$wire.call(
                                this.wireOnSortOrderChange,
                                this.sortOrder,
                                previousSortOrder,
                                this.name,
                                from,
                                to,
                            )
                        },
                    });
                },

                computeSortOrderFromChildren() {
                    return [].slice.call(this.$refs.root.children)
                        .map(child => child.dataset.sortKey)
                        .filter(sortKey => sortKey)
                }
            }))
        })
    </script>

    <script>
        window.addEventListener('asignar-tecnico', event => {
            $('.userSelect').select2({
                placeholder: 'Seleccionar Tecnico',
                language: "es",
                selectionCssClass: 'pl-9',
                width: '100%',
                ajax: {
                    url: '{{ route('search.users') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    data: function(params) {

                        var query = {
                            term: params.term,
                        }

                        return query;
                    },
                    processResults: function(data, params) {

                        var suggestions = $.map(data.suggestions, function(obj) {

                            obj.id = obj.id || obj.data;
                            obj.text = obj.value;
                            return obj;

                        });
                        return {
                            results: suggestions,
                        };
                    },

                }
            });

            $('.userSelect').on('select2:select', function(e) {

                console.log(this.value);
                @this.set('users_id', this.value)

            });
        })
    </script>

    @if ($asignarTecnico)
        <script>
            $('.userSelect').select2({
                placeholder: 'Seleccionar Tecnico',
                language: "es",
                selectionCssClass: 'pl-9',
                width: '100%',
                ajax: {
                    url: '{{ route('search.users') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    data: function(params) {

                        var query = {
                            term: params.term,
                        }

                        return query;
                    },
                    processResults: function(data, params) {

                        var suggestions = $.map(data.suggestions, function(obj) {

                            obj.id = obj.id || obj.data;
                            obj.text = obj.value;
                            return obj;

                        });
                        return {
                            results: suggestions,
                        };
                    },

                }
            });

            $('.userSelect').on('select2:select', function(e) {

                console.log(this.value);
                @this.set('user', this.value)

            });
        </script>
    @endif




    <script>
        $('.facturasSelect').select2({
            placeholder: 'Buscar Factura',
            language: "es",
            selectionCssClass: 'pl-9',
            width: '100%',
            templateResult: formatFactura,
            ajax: {
                url: '{{ route('search.facturas') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {

                    var query = {
                        term: params.term,
                    }

                    return query;
                },
                processResults: function(data, params) {

                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data;
                        obj.text = obj.value;
                        return obj;

                    });
                    return {
                        results: suggestions,
                    };
                },

            }
        });

        function formatFactura(factura) {
            if (factura.loading) {
                return factura.text;
            }

            var $container = $(

                "<div class='select2-result-facturas clearfix'>" +
                "<div class='select2-result-facturas__meta'>" +
                "<div class='select2-result-facturas__title border-b text-base font-bold'></div>" +
                "<div class='select2-result-facturas__description text-xs '></div>" +
                "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks text-xs'><i class='fal fa-money-bill'></i> </div>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-facturas__title").text(factura.serie_numero);
            $container.find(".select2-result-facturas__description").text(factura.cliente);
            $container.find(".select2-result-repository__forks").append("S/. " + factura.total);


            return $container;
        }


        // UBIGEOS
        $('.ubigeoPartida').select2({
            placeholder: 'SELECCIONA UN UBIGEO',
            language: "es",
            selectionCssClass: 'pl-9',
            minimumInputLength: 2,
            width: '100%',
            templateResult: formatUbigeo,
            ajax: {
                url: '{{ route('search.ubigeos') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {

                    var query = {
                        term: params.term,
                    }

                    return query;
                },
                processResults: function(data, params) {

                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data;
                        obj.text = obj.value;
                        return obj;

                    });
                    return {
                        results: suggestions,
                    };
                },

            }
        });
        $('.ubigeoPartida').on('select2:select', function(e) {

            @this.set('ubigeo_partida', this.value)

        });

        $('.ubigeoLlegada').select2({
            placeholder: 'SELECCIONA UN UBIGEO',
            language: "es",
            selectionCssClass: 'pl-9',
            minimumInputLength: 2,
            width: '100%',
            templateResult: formatUbigeo,
            ajax: {
                url: '{{ route('search.ubigeos') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {

                    var query = {
                        term: params.term,
                    }

                    return query;
                },
                processResults: function(data, params) {

                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data;
                        obj.text = obj.value;
                        return obj;

                    });
                    return {
                        results: suggestions,
                    };
                },

            }
        });
        $('.ubigeoLlegada').on('select2:select', function(e) {

            @this.set('ubigeo_llegada', this.value)

        });


        function formatUbigeo(ubigeo) {
            if (ubigeo.loading) {
                return ubigeo.text;
            }

            var $container = $(

                "<div class='select2-result-ubigeos clearfix'>" +
                "<div class='select2-result-ubigeos__meta'>" +
                "<div class='select2-result-ubigeos__title border-b text-base font-bold'></div>" +
                "<div class='select2-result-ubigeos__description text-xs '></div>" +
                "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks text-xs'></i> </div>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-ubigeos__title").text(ubigeo.value);
            $container.find(".select2-result-ubigeos__description").text(ubigeo.departamento + " - " + ubigeo.provincia +
                " - " + ubigeo.distrito);
            $container.find(".select2-result-repository__forks").append(ubigeo.value);


            return $container;
        }
        $('.productoSelect').select2({
            placeholder: 'Añadir Artículo',
            language: "es",
            width: '100%',
            ajax: {
                url: '{{ route('search.productos') }}',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    console.log(params);

                    var query = {
                        term: params.term,
                        tipo: 'producto',
                    }
                    return query;
                },
                processResults: function(data, params) {

                    var suggestions = $.map(data.suggestions, function(obj) {

                        obj.id = obj.id || obj.data;
                        obj.text = obj.value;
                        return obj;
                    });
                    return {
                        results: suggestions,
                    };

                },


            }
        });


        $('.productoSelect').on('select2:select', function(e) {

            @this.call('selectProduct', this.value)

        });

        function cambiarMotivo(value) {

            console.log(value);

        };

        function Asignar({
            checked
        }) {

            console.log(checked);

        };

        function cambiarTipoDocumento(e) {

            console.log(e);

        };

        $(document).ready(function() {

            flatpickr('.fecha_emision', {
                mode: 'single',
                minDate: "today",
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });

            flatpickr('.fecha_inicio_traslado', {
                mode: 'single',
                disableMobile: "true",
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });

        })
    </script>
@endsection
