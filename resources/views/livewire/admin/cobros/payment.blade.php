<div>

    <!-- Basic Modal -->
    <div class="mb-4">
        <button class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white" wire:click.prevent="openModal">
            Pagar - ${{ $cobro->monto_unidad }}
        </button>
    </div>
    <!-- Start -->
    <div x-data="{ modalPayment: @entangle('modalPayment') }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalPayment"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
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
                                <label class="block text-sm font-medium mb-1" for="tipo_pago">Tipo Pago: <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative" lang="es">

                                    <select id="tipo_pago" name="tipo_pago" wire:model="tipo_pago"
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
                                <label class="block text-sm font-medium mb-1" for="documento">{{ $titulo_documento }}:
                                    <span class="text-rose-500">*</span></label>

                                <div class="relative" lang="es" wire:ignore>


                                    <select id="documentos" name="documentos" class="documentos w-full form-input pl-9 "
                                        required>
                                        <option selected disabled value="">Selecciona <-- </option>
                                    </select>

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path d="M1,13V40a4,4,0,0,0,4,4H43a4,4,0,0,0,4-4V13Z" fill="#6cc4f5">
                                                </path>
                                                <path d="M47,14H1V6A2,2,0,0,1,3,4H13l4,4H43a4,4,0,0,1,4,4Z"
                                                    fill="#2594d0"></path>
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

                            <div class="col-span-12 sm:col-span-12 mb-2">
                                <label class="block text-sm font-medium mb-1" for="nota">
                                    Nota:
                                </label>

                                <div class="relative">



                                    <textarea class="w-full form-input pl-9 " name="nota" id="" rows="4" placeholder="Ingresa una nota">


                                    </textarea>

                                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                                        <svg class="w-4 h-4 fill-current text-slate-800 shrink-0 ml-3 mr-2"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                            <g class="nc-icon-wrapper">
                                                <path d="M1,13V40a4,4,0,0,0,4,4H43a4,4,0,0,0,4-4V13Z" fill="#6cc4f5">
                                                </path>
                                                <path d="M47,14H1V6A2,2,0,0,1,3,4H13l4,4H43a4,4,0,0,1,4,4Z"
                                                    fill="#2594d0"></path>
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
        window.addEventListener('dataDocumentos', event => {

            // $('.vehiculos_id').select2('destroy');
            console.log(event.detail.data);
            data = []
            data = event.detail.data;
            //  $('.vehiculos_id').innerHTML = "";

            $(".documentos option").remove();

            $('.documentos').select2({
                placeholder: '    Buscar un documento',
                language: "es",
                selectionCssClass: 'pl-9',
                width: '100%',
                // minimumInputLength: 2,
                data: data
            });

            $('.documentos').val(null).trigger('change');

        })


        $('.documentos').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data.id);

            //@this.set('documentos', data.id)
        });
    </script>
@endsection
