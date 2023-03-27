<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ modalOpen: @entangle('modalOpen') }">

        <div class="relative inline-flex">

            <!-- Create button -->

            <button type="button" wire:click="openModal" aria-controls="basic-modal"
                class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
            </button>

        </div>
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalOpen" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalOpen = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REGISTRO RAPIDO DISPOSITIVO</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
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

                    <div class="grid grid-cols-12 gap-6">

                        <div class="shadow overflow-hidden sm:rounded-md col-span-12">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-12 gap-6">

                                    <div class="col-span-6 sm:col-span-6">

                                        {!! Html::decode(
                                            Form::label('imei', 'Imei <span class="text-rose-500">*</span>', ['class' => 'block text-sm font-medium mb-1']),
                                        ) !!}

                                        <input type="text" wire:model="imei" class="form-input w-full"
                                            placeholder="Ingresa el imei">
                                        @error('imei')
                                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-span-12 sm:col-span-6">


                                        {!! Form::label('modelo_id', 'Modelo:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                        <select name="modelo_id" id="modelo_id" wire:model="modelo_id"
                                            class="form-select w-full">
                                            <option>Selecciona un modelo</option>
                                            @foreach ($modelos as $key => $modelo)
                                                <option value="{{ $key }}">{{ $modelo }}</option>
                                            @endforeach
                                        </select>


                                    </div>

                                    @error('modelo_id')
                                        <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="col-span-12 mt-2">
                                        <label for="of_client"
                                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                            <div>
                                                De cliente?:
                                            </div>

                                        </label>
                                        <div class="flex flex-wrap items-center -m-3">

                                            <div class="m-3">
                                                <!-- Start -->
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="of_client" wire:model="of_client"
                                                        class="form-checkbox" />
                                                    <span class="text-sm ml-2">SI</span>
                                                </label>
                                                <!-- End -->
                                            </div>
                                            {{ $of_client }}

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button type="button" class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click="closeModal">Cerrar</button>
                        <button wire:click.prevent='save'
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End -->

</div>
@push('scripts')
    <script>
        window.addEventListener('save-quick-imei', event => {
            iziToast.success({
                title: 'DISPOSITIVO GUARDADO',
                message: 'se ha registrado el siguiente imei ' + event.detail.imei + '!',
                position: 'topRight'
            });
        })
    </script>
@endpush
