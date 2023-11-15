<div>
    <div x-data="{ modalSave: @entangle('modalSave').live }">

        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalSave"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalSave" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalSave = false">

                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">CREAR TAREA</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalSave = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="px-8 py-5 bg-white sm:p-6">
                    <form autocomplete="off">


                        <div class="grid grid-cols-12 gap-6">

                            <div class="col-span-12">
                                <label class="block text-sm font-medium mb-1" for="tipo_tarea_id">Seleccionar Tipo de
                                    Tarea:</label>
                                <div class="relative">

                                    <select class="form-select w-full pl-9" id="tipo_tarea_id"
                                        wire:model.live="tipo_tarea_id">

                                        <option class="text-slate-400" value="0" disabled selected>Selecciona una
                                            opción...
                                        </option>

                                        @foreach ($tipo_tareas as $key => $tarea)
                                            <option value="{{ $key }}">{{ $tarea }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M43.989,35.373,30.167,23.437,23,30.389l12.373,13.6q.1.115.213.225a6.1,6.1,0,0,0,8.627,0h0c.073-.073.144-.148.213-.224A6.1,6.1,0,0,0,43.989,35.373Z"
                                                    fill="#ff7163"></path>
                                                <path
                                                    d="M8.414,14H11l8.847,8.847L23,20l-9-9V8.414a1,1,0,0,0-.293-.707L8,2,2,8l5.707,5.707A1,1,0,0,0,8.414,14Z"
                                                    fill="#949494"></path>
                                                <path
                                                    d="M35.629,24.383A11.321,11.321,0,0,0,45.977,14.034a12.35,12.35,0,0,0-.485-4.291L39.48,15.754,32.251,8.525l6.011-6.012a12.342,12.342,0,0,0-4.29-.477,11.321,11.321,0,0,0-10.35,10.348,12.345,12.345,0,0,0,.479,4.295L3.046,35.688a3.171,3.171,0,0,0-.226,4.478c.036.04.072.078.11.115l4.793,4.794a3.17,3.17,0,0,0,4.483-.008c.037-.036.072-.074.107-.112L31.333,23.9A12.353,12.353,0,0,0,35.629,24.383Z"
                                                    fill="#c8c8c8"></path>
                                                <path
                                                    d="M39,40a1,1,0,0,1-.707-.293l-7-7a1,1,0,0,1,1.414-1.414l7,7A1,1,0,0,1,39,40Z"
                                                    fill="#f74b3b"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('tipo_tarea_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- titulo --}}
                            <div class="col-span-12">
                                <div class="text-center font-semibold text-slate-800">
                                    SERVICIO: {{ $titulo }}.
                                </div>
                            </div>

                            {{-- vehiculo --}}
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="vehiculos_id">
                                    Vehiculo:
                                </label>
                                <div class="relative" wire:ignore>

                                    <select class="form-select w-full pl-9 selectVehiculo" name="vehiculos_id"
                                        id="vehiculos_id">
                                    </select>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                                    fill="#363636">
                                                </path>
                                                <path
                                                    d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                                    fill="#363636"></path>
                                                <path
                                                    d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                                    fill="#e3e3e3">
                                                </path>
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
                                                <path
                                                    d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                                    fill="#49c549">
                                                </path>
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
                                @if ($ErrorMsgVehiculo)
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $ErrorMsgVehiculo }}
                                    </p>
                                @endif
                            </div>

                            {{-- dispositivo --}}
                            <div
                                class="col-span-12 sm:col-span-6 dispositivo {{ $tipo_tarea_id == 2 || $tipo_tarea_id == 4 ? 'hidden' : 'cambio' }}">
                                <label class="block text-sm font-medium mb-1" for="modelo_dispositivo_id">
                                    Dispositivo:
                                </label>
                                <div class="relative" wire:ignore>

                                    <select class="form-select w-full pl-9 selectModelDispositivo">

                                    </select>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512.016 512.016"
                                            style="enable-background:new 0 0 512.016 512.016;" xml:space="preserve">
                                            <g>
                                                <polygon style="fill:#999999;"
                                                    points="368.632,461.946 169.208,461.946 169.208,446.001 362.031,446.001 402.174,405.858
                                                                    		490.122,405.858 490.122,421.803 408.776,421.803 	" />
                                                <polygon style="fill:#999999;"
                                                    points="342.808,461.946 143.384,461.946 103.24,421.803 21.893,421.803 21.893,405.858
                                                                    		109.842,405.858 149.985,446.001 342.808,446.001 	" />
                                                <rect x="165.444" y="496.07" style="fill:#999999;"
                                                    width="181.135" height="15.946" />
                                            </g>
                                            <path style="fill:#E21B1B;"
                                                d="M256.008,365.419l-15.467-20.426c-11.377-14.917-111.006-147.872-111.006-214.135
                                                                    	C129.535,51.369,179.15,0,256.008,0s126.473,51.369,126.473,130.858c0,66.175-99.661,199.154-110.918,214.143L256.008,365.419z" />
                                            <circle style="fill:#FFFFFF;" cx="255.936" cy="131.727"
                                                r="40.956" />
                                        </svg>
                                    </div>
                                </div>
                                @error('dispositivo')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- velocimetro --}}
                            <div
                                class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 ? 'velocimetro' : 'hidden' }}">
                                <label class="block text-sm font-medium mb-1" for="modelo_dispositivo_id">
                                    Modelo Velocimetro:
                                </label>
                                <div class="relative">

                                    <select class="form-select w-full pl-9 select-modelo-velocimetro"
                                        wire:model.live="modelo_velocimetro" id="modelo_velocimetro">
                                        <option value="0" disabled selected>Selecciona un modelo</option>
                                        @foreach ($velocimetros as $velocimetro)
                                            <option value="{{ $velocimetro->nombre }}">
                                                {{ $velocimetro->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512.016 512.016"
                                            style="enable-background:new 0 0 512.016 512.016;" xml:space="preserve">
                                            <g>
                                                <polygon style="fill:#999999;"
                                                    points="368.632,461.946 169.208,461.946 169.208,446.001 362.031,446.001 402.174,405.858
                                                                                                		490.122,405.858 490.122,421.803 408.776,421.803 	" />
                                                <polygon style="fill:#999999;"
                                                    points="342.808,461.946 143.384,461.946 103.24,421.803 21.893,421.803 21.893,405.858
                                                                                                		109.842,405.858 149.985,446.001 342.808,446.001 	" />
                                                <rect x="165.444" y="496.07" style="fill:#999999;"
                                                    width="181.135" height="15.946" />
                                            </g>
                                            <path style="fill:#E21B1B;"
                                                d="M256.008,365.419l-15.467-20.426c-11.377-14.917-111.006-147.872-111.006-214.135
                                                                                                	C129.535,51.369,179.15,0,256.008,0s126.473,51.369,126.473,130.858c0,66.175-99.661,199.154-110.918,214.143L256.008,365.419z" />
                                            <circle style="fill:#FFFFFF;" cx="255.936" cy="131.727"
                                                r="40.956" />
                                        </svg>
                                    </div>
                                </div>
                                @error('modelo_velocimetro')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- numero --}}
                            <div
                                class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 || $tipo_tarea_id == 5 ? 'hidden' : 'velo' }}">
                                <label class="block text-sm font-medium mb-1" for="modelo_dispositivo_id">
                                    Número:
                                </label>
                                <div class="relative">
                                    <input type="text" class="form-input pl-9 w-full numero" wire:model.live="numero"
                                        placeholder="Ingresa o busca un numero">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M46,21a1,1,0,0,1-1-1A17.018,17.018,0,0,0,28,3a1,1,0,0,1,0-2A19.021,19.021,0,0,1,47,20,1,1,0,0,1,46,21Z"
                                                    fill="#49c549"></path>
                                                <path
                                                    d="M38,21a1,1,0,0,1-1-1,9.011,9.011,0,0,0-9-9,1,1,0,0,1,0-2A11.013,11.013,0,0,1,39,20,1,1,0,0,1,38,21Z"
                                                    fill="#9ee09e"></path>
                                                <path
                                                    d="M31.376,29.175,27.79,33.658A37.835,37.835,0,0,1,14.343,20.212l4.483-3.586a3.047,3.047,0,0,0,.88-3.614l-4.087-9.2A3.045,3.045,0,0,0,12.068,2.1L4.29,4.115A3.066,3.066,0,0,0,2.029,7.5,45.2,45.2,0,0,0,40.5,45.971a3.062,3.062,0,0,0,3.383-2.26L45.9,35.932a3.047,3.047,0,0,0-1.712-3.551L34.99,28.3A3.046,3.046,0,0,0,31.376,29.175Z"
                                                    fill="#3d6c7b"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('numero')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- sim card --}}
                            <div
                                class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 || $tipo_tarea_id == 5 ? 'hidden' : 'velo' }}">
                                <label class="block text-sm font-medium mb-1" for="sim_card">
                                    Sim Card:
                                </label>
                                <div class="relative">
                                    <input type="text" class="form-input pl-9 w-full sim_card"
                                        placeholder="Ingresa o busca un sim card" wire:model.live="sim_card">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M44.539,41.4,36.861,28.489A1,1,0,0,0,36,28H12a1,1,0,0,0-.86.489l-7.671,12.9Z"
                                                    fill="#636363"></path>
                                                <path d="M6,46a3,3,0,0,1,0-6H42a3,3,0,0,1,0,6" fill="#363636"></path>
                                                <polygon points="39.594 37 35.432 30 12.568 30 8.406 37 39.594 37"
                                                    fill="#c2eff4"></polygon>
                                                <path
                                                    d="M32.887,6.556a1,1,0,0,0-.44-.451l-8-4a1,1,0,0,0-.894,0l-8,4a1,1,0,0,0-.44.451L24,11Z"
                                                    fill="#c2eff4">
                                                </path>
                                                <path
                                                    d="M24,11V22a1,1,0,0,0,.447-.105l8-4A1,1,0,0,0,33,17V7a1,1,0,0,0-.113-.444Z"
                                                    fill="#7ed3dd">
                                                </path>
                                                <path
                                                    d="M15.113,6.556A1,1,0,0,0,15,7V17a1,1,0,0,0,.553.895l8,4A1,1,0,0,0,24,22V11Z"
                                                    fill="#a0e6ee">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('sim_card')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- numero nuevo --}}
                            <div
                                class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 2 && $tipo_tarea_id !== 4 ? 'cambio' : 'hidden' }}">
                                <label class="block text-sm font-medium mb-1" for="nuevo_numero">
                                    Número Nuevo:
                                </label>
                                <div class="relative">
                                    <input type="text" class="form-input pl-9 w-full nuevo_numero"
                                        wire:model.live="nuevo_numero" placeholder="Ingresa o busca un numero">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M46,21a1,1,0,0,1-1-1A17.018,17.018,0,0,0,28,3a1,1,0,0,1,0-2A19.021,19.021,0,0,1,47,20,1,1,0,0,1,46,21Z"
                                                    fill="#49c549"></path>
                                                <path
                                                    d="M38,21a1,1,0,0,1-1-1,9.011,9.011,0,0,0-9-9,1,1,0,0,1,0-2A11.013,11.013,0,0,1,39,20,1,1,0,0,1,38,21Z"
                                                    fill="#9ee09e"></path>
                                                <path
                                                    d="M31.376,29.175,27.79,33.658A37.835,37.835,0,0,1,14.343,20.212l4.483-3.586a3.047,3.047,0,0,0,.88-3.614l-4.087-9.2A3.045,3.045,0,0,0,12.068,2.1L4.29,4.115A3.066,3.066,0,0,0,2.029,7.5,45.2,45.2,0,0,0,40.5,45.971a3.062,3.062,0,0,0,3.383-2.26L45.9,35.932a3.047,3.047,0,0,0-1.712-3.551L34.99,28.3A3.046,3.046,0,0,0,31.376,29.175Z"
                                                    fill="#3d6c7b"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('nuevo_numero')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- nuevo sim card --}}
                            <div
                                class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 2 && $tipo_tarea_id !== 5 ? 'cambio' : 'hidden' }}">
                                <label class=" block text-sm font-medium mb-1" for="nuevo_sim_card">
                                    Sim Card Nuevo:
                                </label>
                                <div class="relative">
                                    <input type="text" class="form-input pl-9 w-full nuevo_sim_card"
                                        placeholder="Ingresa o busca un sim card" wire:model.live="nuevo_sim_card">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M44.539,41.4,36.861,28.489A1,1,0,0,0,36,28H12a1,1,0,0,0-.86.489l-7.671,12.9Z"
                                                    fill="#636363"></path>
                                                <path d="M6,46a3,3,0,0,1,0-6H42a3,3,0,0,1,0,6" fill="#363636"></path>
                                                <polygon points="39.594 37 35.432 30 12.568 30 8.406 37 39.594 37"
                                                    fill="#c2eff4"></polygon>
                                                <path
                                                    d="M32.887,6.556a1,1,0,0,0-.44-.451l-8-4a1,1,0,0,0-.894,0l-8,4a1,1,0,0,0-.44.451L24,11Z"
                                                    fill="#c2eff4">
                                                </path>
                                                <path
                                                    d="M24,11V22a1,1,0,0,0,.447-.105l8-4A1,1,0,0,0,33,17V7a1,1,0,0,0-.113-.444Z"
                                                    fill="#7ed3dd">
                                                </path>
                                                <path
                                                    d="M15.113,6.556A1,1,0,0,0,15,7V17a1,1,0,0,0,.553.895l8,4A1,1,0,0,0,24,22V11Z"
                                                    fill="#a0e6ee">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('nuevo_sim_card')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>



                            {{-- fecha --}}
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="fecha_hora">
                                    Fecha y Hora de la Tarea:
                                </label>
                                <div class="relative">
                                    <input type="text" class="form-input pl-9 w-full fecha-tarea"
                                        wire:model.live="fecha_hora" placeholder="2023-05-12 03:00">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path d="M2,41a5,5,0,0,0,5,5H41a5,5,0,0,0,5-5V16H2Z" fill="#e3e3e3">
                                                </path>
                                                <path d="M41,6H7a5,5,0,0,0-5,5v5H46V11A5,5,0,0,0,41,6Z"
                                                    fill="#ff7163">
                                                </path>
                                                <path
                                                    d="M23.239,38.894H12.359V36.6c2.891-2.922,5.36-5.363,6.175-6.414,1.382-1.784,1.136-3.3.484-3.88-1.287-1.142-3.435-.085-4.913,1.139l-1.788-2.119a7.62,7.62,0,0,1,5.557-2.225c2.88,0,4.928,1.662,4.928,4.216a6.047,6.047,0,0,1-1.549,3.949c-.826,1.032-4.8,4.855-4.8,4.855h6.781Z"
                                                    fill="#aeaeae"></path>
                                                <path
                                                    d="M24.7,32.155q0-4.62,1.954-6.877A7.319,7.319,0,0,1,32.5,23.021a10.653,10.653,0,0,1,2.087.16V25.81a8.524,8.524,0,0,0-1.874-.213c-1.8,0-3.517.431-4.364,2.023a6.926,6.926,0,0,0-.628,2.842,4.211,4.211,0,0,1,3.513-1.809c2.937,0,4.449,2.015,4.449,4.929,0,3.271-1.916,5.4-5.3,5.4C26.6,38.979,24.7,36.12,24.7,32.155Zm5.621,4.194c1.545,0,2.182-1.16,2.182-2.725,0-1.461-.651-2.448-2.118-2.448a2.318,2.318,0,0,0-2.417,2.161C27.965,34.856,28.82,36.349,30.318,36.349Z"
                                                    fill="#aeaeae"></path>
                                                <path
                                                    d="M11.5,12A1.5,1.5,0,0,1,10,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,11.5,12Z"
                                                    fill="#363636"></path>
                                                <path
                                                    d="M36.5,12A1.5,1.5,0,0,1,35,10.5v-7a1.5,1.5,0,0,1,3,0v7A1.5,1.5,0,0,1,36.5,12Z"
                                                    fill="#363636"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('fecha_hora')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-span-12">
                                <label class="block text-sm font-medium mb-1" for="plataforma">Selecciona El Tecnico:
                                    <span class="text-rose-500">*</span></label>
                                <div class="flex flex-wrap items-center">

                                    @foreach ($tecnicos as $tecnico)
                                        <div class="m-3">
                                            <label class="flex items-center">
                                                <input type="radio" name="radio-buttons" class="form-radio"
                                                    wire:model.live="tecnico_id" value="{{ $tecnico->id }}" />
                                                <span class="text-sm ml-2">{{ $tecnico->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                                @error('tecnico_id')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            @if ($tipo_tarea_id == '0')
                                <div class="col-span-12">

                                    <div class="text-center font-medium text-rose-600">
                                        SELECCIONA EL TIPO DE TAREA.
                                    </div>
                                </div>
                            @endif

                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click.prevent="closeModal">Cerrar</button>
                        <button wire:click.prevent="save()"
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End -->

</div>

@once
    @push('scripts')
        <script>
            window.addEventListener('save-task', event => {
                $('.selectVehiculo').val(null).trigger('change');
                $('.selectModelDispositivo').val(null).trigger('change');
            })
        </script>

        <script>
            $(document).ready(function() {
                selects();
                autocompleteNumero();
                initFechaHora();

            })
            window.addEventListener('change-tipo-tarea', event => {
                if (event.detail.value == 4) {
                    $('.dispositivo').hide()
                }
                selects();
                autocompleteNumero();
                initFechaHora();

            })

            function selects() {
                $('.selectVehiculo').select2({
                    placeholder: 'Buscar un Vehiculo',
                    language: "es",
                    minimumInputLength: 2,
                    selectionCssClass: 'pl-9',
                    width: '100%',
                    ajax: {
                        url: '{{ route('search.vehiculos') }}',
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
                                obj.id = obj.id || obj.value;
                                obj.text = obj.data;
                                return obj;
                            });

                            return {
                                results: suggestions,
                            };

                        },


                    }
                });

                $('.selectVehiculo').on('select2:select', function(e) {

                    var data = e.params.data;
                    @this.set('vehiculos_id', data.id)

                });

                $('.selectModelDispositivo').select2({
                    placeholder: 'Buscar un Dispositivo',
                    language: "es",
                    selectionCssClass: 'pl-9',
                    width: '100%',
                    ajax: {
                        url: '{{ route('search.dispositivos.modelos') }}',
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

                $('.selectModelDispositivo').on('select2:select', function(e) {

                    var data = e.params.data;
                    @this.set('dispositivo', data.modelo)

                });
            }
        </script>

        <script>
            function autocompleteNumero() {
                $('.numero').devbridgeAutocomplete({
                    lookup: function(query, done) {
                        $.ajax({
                            url: "{{ route('search.lineas') }}",
                            dataType: 'json',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                done(data);
                            }
                        })

                    },
                    minChars: 2,
                    autoSelectFirst: false,
                    deferRequestBy: 10,
                    onSelect: function(suggestion) {

                        // $('.operador').val(suggestion.operador);
                        // @this.set('operador', suggestion.operador)
                        @this.set('numero', suggestion.value)
                        // $('.sim_card').val(suggestion.sim_card);
                        @this.set('sim_card', suggestion.sim_card)
                        // $('.sim_card_id').val(suggestion.sim_card_id);
                        // @this.set('sim_card_id', suggestion.sim_card_id)

                    },
                    onHint: function(hint) {
                        //console.log(hint);
                    },
                    onSearchComplete: function(query, suggestions) {

                    }

                });
            }

            function initFechaHora() {
                $(document).ready(function() {
                    flatpickr('.fecha-tarea', {
                        enableTime: true,
                        disableMobile: "true",
                        dateFormat: "Y-m-d H:i",
                        prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                        nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
                    });
                })
            }
        </script>
    @endpush
@endonce
