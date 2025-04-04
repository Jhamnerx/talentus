<div>
    <div x-data="{ modalCreateTask: @entangle('modalCreateTask').live }">

        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalCreateTask"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalCreateTask"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalCreateTask = false">

                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">CREAR TAREA</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalCreateTask = false">
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
                                <label class="block text-sm font-medium mb-1" for="tipo_tarea_id">Tipo de
                                    Tarea:</label>
                                <div class="relative">

                                    <select class="form-select w-full pl-9" id="tipo_tarea_id"
                                        wire:model.live="tipo_tarea_id">

                                        <option value="5">MANTENIMIENTO</option>

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
                                    SERVICIO: MANTENIMIENTO EQUIPO GPS.
                                </div>
                            </div>

                            {{-- vehiculo --}}
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="vehiculos_id">
                                    Vehiculo:
                                </label>
                                <div class="relative" wire:ignore>

                                    <input type="text" wire:model.live="placa" placeholder="PLACA" disabled readonly
                                        class="form-input w-full pl-9">
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
                                @error('vehiculo_id')
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            {{-- fecha --}}
                            <div class="col-span-12 sm:col-span-6">


                                <x-form.datetime.picker label=" Fecha y Hora de la Tarea:" id="fecha_hora"
                                    name="fecha_hora" wire:model.live="fecha_hora" parse-format="YYYY-MM-DD"
                                    display-format="DD-MM-YYYY" :clearable="false" />
                            </div>


                            {{-- dispositivo --}}
                            <div class="col-span-12 sm:col-span-6 dispositivo">
                                <label class="block text-sm font-medium mb-1" for="modelo_dispositivo_id">
                                    Dispositivo:
                                </label>
                                <div class="relative" wire:ignore>

                                    <input type="text" placeholder="FMB920" wire:model.live="dispositivo"
                                        class="form-input w-full pl-9">
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
                                                <rect x="165.444" y="496.07" style="fill:#999999;" width="181.135"
                                                    height="15.946" />
                                            </g>
                                            <path style="fill:#E21B1B;"
                                                d="M256.008,365.419l-15.467-20.426c-11.377-14.917-111.006-147.872-111.006-214.135
                                                                    C129.535,51.369,179.15,0,256.008,0s126.473,51.369,126.473,130.858c0,66.175-99.661,199.154-110.918,214.143L256.008,365.419z" />
                                            <circle style="fill:#FFFFFF;" cx="255.936" cy="131.727" r="40.956" />
                                        </svg>
                                    </div>
                                </div>
                                @error('dispositivo')
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