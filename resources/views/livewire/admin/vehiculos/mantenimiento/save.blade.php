<div>
    <div x-data="{ modalSave: @entangle('modalOpen').live }">
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

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-6/12 max-h-full"
                @keydown.escape.window="modalSave = false">
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REGISTRAR MANTENIMIENTO VEHICULO</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalSave = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form autocomplete="off">
                    <div class="px-8 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-12 gap-6">

                            <div class="col-span-12 sm:col-span-4">

                                <x-form.input wire:model.live="numero" label="Número:" placeholder="MT2-001" />

                            </div>


                            <div class="col-span-12 sm:col-span-4 ">
                                <x-form.select label="Selecciona una Vehiculo:" wire:model.live="vehiculo_id"
                                    placeholder="Selecciona una placa" option-description="option_description"
                                    :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id" />
                            </div>

                            <div class="col-span-12 sm:col-span-4">

                                <x-form.datetime-picker label="Fecha Programada:" id="fecha_hora_mantenimiento"
                                    name="fecha_hora_mantenimiento" wire:model.live="fecha_hora_mantenimiento"
                                    without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                                    :clearable="false" />

                            </div>


                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="descripcion">DETALLE:</label>
                                <div class="relative">
                                    <textarea wire:model.live="detalle_trabajo" class="form-input w-full pl-9" name="descripcion" id="descripcion"
                                        rows="2" placeholder="Ingresar Breve detalle"></textarea>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                                    fill="#fbe5d5"></path>
                                                <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z"
                                                    fill="#ff7163">
                                                </path>
                                                <path
                                                    d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                                    fill="#4c4c4c"></path>
                                                <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b">
                                                </path>
                                                <path
                                                    d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                                    fill="#3d6c7b"></path>
                                                <rect x="33.294" y="5.618" width="2" height="16.142"
                                                    transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55">
                                                </rect>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="descripcion">NOTA:</label>
                                <div class="relative">
                                    <textarea wire:model.live="nota" class="form-input w-full pl-9" name="descripcion" id="descripcion" rows="2"
                                        placeholder="Ingresar Breve nota"></textarea>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                                    fill="#fbe5d5"></path>
                                                <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z"
                                                    fill="#ff7163">
                                                </path>
                                                <path
                                                    d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                                    fill="#4c4c4c"></path>
                                                <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b">
                                                </path>
                                                <path
                                                    d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                                    fill="#3d6c7b"></path>
                                                <rect x="33.294" y="5.618" width="2" height="16.142"
                                                    transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55">
                                                </rect>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="notify_cliente">Notificar Cliente:
                                    <span class="text-rose-500">*</span></label>
                                <div class="flex flex-wrap items-center">

                                    <div class="m-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="notify_client" value="1"
                                                class="form-radio" wire:model.live="notify_client" />
                                            <span class="text-sm ml-2">Si</span>
                                        </label>
                                    </div>

                                    <div class="m-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="notify_client" value="0"
                                                class="form-radio" wire:model.live="notify_client" />
                                            <span class="text-sm ml-2">No</span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="notify_admin">Notificar Admin:
                                    <span class="text-rose-500">*</span></label>
                                <div class="flex flex-wrap items-center">

                                    <div class="m-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="notify_admin" class="form-radio"
                                                wire:model.live="notify_admin" value="1" />
                                            <span class="text-sm ml-2">Si</span>
                                        </label>
                                    </div>

                                    <div class="m-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="notify_admin" class="form-radio"
                                                wire:model.live="notify_admin" value="0" />
                                            <span class="text-sm ml-2">No</span>
                                        </label>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </form>

                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click.prevent="closeModal">Cerrar</button>

                        <button wire:loading.attr="disabled" wire:click.prevent="guardar()"
                            class="btn-sm bg-indigo-500 disabled:bg-indigo-300 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
