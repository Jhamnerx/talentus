<div>
    <x-form.modal.card title="REGISTRAR MANTENIMIENTO VEHICULO" max-width="3xl" wire:model.live="modalOpen" align="center">

        <form autocomplete="off">
            <div class="px-8 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-12 gap-6">

                    <div class="col-span-12 sm:col-span-4 ">
                        <x-form.select label="Selecciona una Vehiculo:" wire:model.live="vehiculo_id"
                            placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                            option-label="placa" option-value="id" />
                    </div>

                    <div class="col-span-12 sm:col-span-4">

                        <x-form.datetime.picker label="Fecha Programada:" id="fecha_hora_mantenimiento"
                            name="fecha_hora_mantenimiento" wire:model.live="fecha_hora_mantenimiento" without-time
                            parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

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
                                        <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z" fill="#ff7163">
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
                                        <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z" fill="#ff7163">
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
                                    <input type="radio" name="notify_client" value="1" class="form-radio"
                                        wire:model.live="notify_client" />
                                    <span class="text-sm ml-2">Si</span>
                                </label>
                            </div>

                            <div class="m-3">
                                <label class="flex items-center">
                                    <input type="radio" name="notify_client" value="0" class="form-radio"
                                        wire:model.live="notify_client" />
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

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
                <x-form.button primary label="Guardar" wire:click.prevent="guardar()" wire:loading.attr="disabled" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
