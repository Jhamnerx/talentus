<x-form.modal.card title="EDITAR TAREA" wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">

            <x-form.select label="Seleccionar Tipo de Tarea:" wire:model.live="tipo_tarea_id"
                placeholder="Selecciona una opción..." option-label="name" option-value="id">
                @foreach ($tipo_tareas as $key => $tarea)
                <x-form.select.option label="{{ $tarea }}" value="{{ $key }}" />
                @endforeach
            </x-form.select>


        </div>

        {{-- titulo --}}
        <div class="col-span-12">
            <div class="text-center font-semibold text-slate-800">
                SERVICIO: {{ $titulo }}.
            </div>
        </div>

        {{-- vehiculo --}}
        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Selecciona un Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" :clearable="false" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id" />
        </div>

        {{-- dispositivo --}}
        <div
            class="col-span-12 sm:col-span-6 dispositivo {{ $tipo_tarea_id == 2 || $tipo_tarea_id == 4 ? 'hidden' : 'cambio' }}">

            <x-form.select label="Dipositivo:" name="dispositivo" wire:model.live="dispositivo"
                placeholder="Selecciona un modelo" :async-data="[
                    'api' => route('api.dispositivos.modelos.index'),
                    'params' => ['modelo' => true], // default is []
                ]" option-label="modelo" option-value="modelo" option-description="marca" />
        </div>

        {{-- velocimetro --}}
        <div class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 ? 'velocimetro' : 'hidden' }}">
            <label class="block text-sm font-medium mb-1" for="modelo_dispositivo_id">
                Modelo Velocimetro:
            </label>
            <div class="relative">

                <select class="form-select w-full pl-9 select-modelo-velocimetro" wire:model.live="modelo_velocimetro"
                    id="modelo_velocimetro">
                    <option value="0" disabled selected>Selecciona un modelo</option>
                    @foreach ($velocimetros as $velocimetro)
                    <option value="{{ $velocimetro->nombre }}">
                        {{ $velocimetro->nombre }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 ml-3 mr-2" version="1.1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 512.016 512.016" style="enable-background:new 0 0 512.016 512.016;"
                        xml:space="preserve">
                        <g>
                            <polygon style="fill:#999999;"
                                points="368.632,461.946 169.208,461.946 169.208,446.001 362.031,446.001 402.174,405.858
                                                                                                		490.122,405.858 490.122,421.803 408.776,421.803 	" />
                            <polygon style="fill:#999999;"
                                points="342.808,461.946 143.384,461.946 103.24,421.803 21.893,421.803 21.893,405.858
                                                                                                		109.842,405.858 149.985,446.001 342.808,446.001 	" />
                            <rect x="165.444" y="496.07" style="fill:#999999;" width="181.135" height="15.946" />
                        </g>
                        <path style="fill:#E21B1B;"
                            d="M256.008,365.419l-15.467-20.426c-11.377-14.917-111.006-147.872-111.006-214.135
                                                                                                C129.535,51.369,179.15,0,256.008,0s126.473,51.369,126.473,130.858c0,66.175-99.661,199.154-110.918,214.143L256.008,365.419z" />
                        <circle style="fill:#FFFFFF;" cx="255.936" cy="131.727" r="40.956" />
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
        <div class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 || $tipo_tarea_id == 5 ? 'hidden' : 'velo' }}">
            <x-form.select label="Selecciona una linea:" name="numero" wire:model.live="numero"
                placeholder="Selecciona una linea" option-description="option_description"
                :async-data="route('api.lineas.index')" option-label="numero" option-value="numero">

            </x-form.select>
        </div>
        {{-- sim card --}}
        <div class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 4 || $tipo_tarea_id == 5 ? 'hidden' : 'velo' }}">
            <label class="block text-sm font-medium mb-1" for="sim_card">
                Sim Card:
            </label>
            <div class="relative">
                <input type="text" class="form-input pl-9 w-full sim_card" placeholder="Ingresa o busca un sim card"
                    wire:model.live="sim_card">
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g class="nc-icon-wrapper">
                            <path d="M44.539,41.4,36.861,28.489A1,1,0,0,0,36,28H12a1,1,0,0,0-.86.489l-7.671,12.9Z"
                                fill="#636363"></path>
                            <path d="M6,46a3,3,0,0,1,0-6H42a3,3,0,0,1,0,6" fill="#363636"></path>
                            <polygon points="39.594 37 35.432 30 12.568 30 8.406 37 39.594 37" fill="#c2eff4">
                            </polygon>
                            <path
                                d="M32.887,6.556a1,1,0,0,0-.44-.451l-8-4a1,1,0,0,0-.894,0l-8,4a1,1,0,0,0-.44.451L24,11Z"
                                fill="#c2eff4">
                            </path>
                            <path d="M24,11V22a1,1,0,0,0,.447-.105l8-4A1,1,0,0,0,33,17V7a1,1,0,0,0-.113-.444Z"
                                fill="#7ed3dd">
                            </path>
                            <path d="M15.113,6.556A1,1,0,0,0,15,7V17a1,1,0,0,0,.553.895l8,4A1,1,0,0,0,24,22V11Z"
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
        <div class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 2 && $tipo_tarea_id !== 4 ? 'cambio' : 'hidden' }}">

            <x-form.select label=" Número Nuevo:" name="nuevo_numero" wire:model.live="nuevo_numero"
                placeholder="Selecciona una linea" option-description="option_description"
                :async-data="route('api.lineas.index')" option-label="numero" option-value="numero">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent='addLinea(`${search}`)' x-on:click="close" primary flat full>
                        <span x-html="`Registrar Linea <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>
        </div>

        {{-- nuevo sim card --}}
        <div class="col-span-12 sm:col-span-6 {{ $tipo_tarea_id == 2 && $tipo_tarea_id !== 5 ? 'cambio' : 'hidden' }}">
            <label class=" block text-sm font-medium mb-1" for="nuevo_sim_card">
                Sim Card Nuevo:
            </label>
            <div class="relative">
                <input type="text" class="form-input pl-9 w-full nuevo_sim_card"
                    placeholder="Ingresa o busca un sim card" wire:model.live="nuevo_sim_card">
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g class="nc-icon-wrapper">
                            <path d="M44.539,41.4,36.861,28.489A1,1,0,0,0,36,28H12a1,1,0,0,0-.86.489l-7.671,12.9Z"
                                fill="#636363"></path>
                            <path d="M6,46a3,3,0,0,1,0-6H42a3,3,0,0,1,0,6" fill="#363636"></path>
                            <polygon points="39.594 37 35.432 30 12.568 30 8.406 37 39.594 37" fill="#c2eff4">
                            </polygon>
                            <path
                                d="M32.887,6.556a1,1,0,0,0-.44-.451l-8-4a1,1,0,0,0-.894,0l-8,4a1,1,0,0,0-.44.451L24,11Z"
                                fill="#c2eff4">
                            </path>
                            <path d="M24,11V22a1,1,0,0,0,.447-.105l8-4A1,1,0,0,0,33,17V7a1,1,0,0,0-.113-.444Z"
                                fill="#7ed3dd">
                            </path>
                            <path d="M15.113,6.556A1,1,0,0,0,15,7V17a1,1,0,0,0,.553.895l8,4A1,1,0,0,0,24,22V11Z"
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

            <x-form.datetime.picker label="Fecha y Hora de la Tarea:" placeholder="Fecha y Hora"
                parse-format="YYYY-MM-DD HH:mm" display-format="DD-MM-YYYY HH:mm" wire:model.live="fecha_hora" />
        </div>


        @role('admin')
        <div class="col-span-12">
            <label class="block text-sm font-medium mb-1" for="plataforma">Selecciona El Tecnico:
                <span class="text-rose-500">*</span></label>
            <div class="flex flex-wrap items-center">

                @foreach ($tecnicos as $tecnico)
                <div class="m-3">
                    <label class="flex items-center">
                        <input type="radio" name="radio-buttons" class="form-radio" wire:model.live="tecnico_id"
                            value="{{ $tecnico->id }}" />
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
        @endrole


        @if ($tipo_tarea_id == '0')
        <div class="col-span-12">

            <div class="text-center font-medium text-rose-600">
                SELECCIONA EL TIPO DE TAREA.
            </div>
        </div>
        @endif

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>