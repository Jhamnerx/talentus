<div>
    <div x-data="{ modalPayment: @entangle('modalPayment').live }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalPayment"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>

        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalPayment"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full"
                @keydown.escape.window="modalPayment = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REGISTRAR PAGO</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalPayment = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->

                <form autocomplete="off" autocapitalize="true">

                    <div class="px-8 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-12 gap-6">
                            {{-- TIPO PAGO --}}

                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="numero">Número: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" lang="es">

                                    <input type="text" class="form-input w-full" wire:model.live='numero' disabled>
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="absolute inset-0 right-auto flex items-center pointer-events-none"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g fill="none" class="nc-icon-wrapper">
                                                <path
                                                    d="M2 11h14v2H2v-2zm16 6h2v.5h-1v1h1v.5h-2v1h3v-4h-3v1zm0-6h1.8L18 13.1v.9h3v-1h-1.8l1.8-2.1V10h-3v1zm2-3V4h-2v1h1v3h1zM2 17h14v2H2v-2zM2 5h14v2H2V5z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('tipo_pago')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="tipo_pago">Tipo Pago: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" lang="es">

                                    <select id="tipo_pago" name="tipo_pago" wire:model.live="tipo_pago"
                                        class="tipo_pago w-full form-input pl-9" required>
                                        <option selected value="FACTURA">FACTURA</option>
                                        <option value="RECIBO">RECIBO</option>

                                    </select>

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M40,47a1,1,0,0,1-.53-.152L24,37.179,8.53,46.848A1,1,0,0,1,7,46V6a5,5,0,0,1,5-5H36a5,5,0,0,1,5,5V46a1,1,0,0,1-1,1Z"
                                                    fill="#ffd764"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('tipo_pago')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- DOCUMENTO --}}

                            <div class="col-span-12 sm:col-span-6">

                                <x-form.select wire:model.live="paymentable_id" label="{{ $titulo_documento }}"
                                    placeholder="Selecciona">

                                    @foreach ($documentos as $documento)
                                        <x-select.option label="{{ $documento['text'] }}"
                                            value="{{ $documento['id'] }}" />
                                    @endforeach

                                </x-form.select>
                            </div>

                            {{-- metodo de pago --}}
                            <div class="col-span-12 sm:col-span-6">

                                <x-form.select wire:model.live="payment_method_id" label="Metodo de pago"
                                    placeholder="Selecciona">

                                    @foreach ($paymentsMethods as $metodo)
                                        <x-select.option label="{{ $metodo['descripcion'] }}"
                                            value="{{ $metodo['codigo'] }}" />
                                    @endforeach

                                </x-form.select>
                            </div>

                            <div class="col-span-12 sm:col-span-12">
                                <label class="block text-sm font-medium mb-1" for="plataforma">
                                    Marcar como pagado:
                                </label>
                                <div class="flex flex-wrap items-center">

                                    <div class="m-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" class="form-checkbox" wire:model.live="pay"
                                                value="true" />
                                            <span class="text-sm ml-2">Si</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- monto --}}
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="monto">Monto:</label>

                                <div class="relative">

                                    <input wire:model.live="monto" type="text" class="form-input w-full pl-12"
                                        placeholder="$199.00">
                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <span class="text-sm text-slate-400 font-medium px-3">S/</span>
                                    </div>
                                </div>
                                @error('monto')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">

                                <label class="block text-sm font-medium mb-1" for="numeronumero_operacion">Numero de
                                    operación:</label>

                                <div class="relative">

                                    <input wire:model.live="numero_operacion" type="text"
                                        class="form-input w-full pl-12" placeholder="45474001">

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current text-slate-600 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                                stroke="currentColor" stroke-linejoin="miter"
                                                class="nc-icon-wrapper">
                                                <line x1="10" y1="33" x2="24" y2="33">
                                                </line>
                                                <line x1="32" y1="33" x2="38" y2="33">
                                                </line>
                                                <path
                                                    d="M43,41H5a2.946,2.946,0,0,1-3-3V12A2.946,2.946,0,0,1,5,9H43a2.946,2.946,0,0,1,3,3V38A2.946,2.946,0,0,1,43,41Z">
                                                </path>
                                                <path d="M31.189,23.392a3.933,3.933,0,0,0,0-4.784"></path>
                                                <path d="M35.991,26.993a9.943,9.943,0,0,0,0-11.986"></path>
                                                <circle cx="26" cy="21" r="2" stroke="none"
                                                    fill="currentColor">
                                                </circle>
                                                <rect x="10" y="17" width="7" height="6">
                                                </rect>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('numero_operacion')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                @error('divisa')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- nota --}}
                            <div class="col-span-12 sm:col-span-12 mb-2">
                                <label class="block text-sm font-medium mb-1" for="nota">
                                    Nota:
                                </label>

                                <div class="relative">
                                    <textarea class="w-full form-input pl-9" wire:model.live="nota" name="nota" id="" rows="4"
                                        placeholder="Ingresa una nota">
                                    </textarea>

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 fill-current  shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path
                                                    d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                                    fill="#e3e3e3"></path>
                                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae">
                                                </path>
                                                <path
                                                    d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                                    fill="#3aace9"></path>
                                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z"
                                                    fill="#aeaeae"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                @error('documentos')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </form>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
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
@section('js')
    <script>
        window.addEventListener('savePayment', event => {
            Swal.fire({
                icon: 'success',
                title: 'Guardado',
                text: 'se ha creado ' + event.detail.payment.numero,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            })

        })
    </script>
@endsection
