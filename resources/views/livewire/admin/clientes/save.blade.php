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
                        <div class="font-semibold text-slate-800">REGISTRAR CLIENTE</div>
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



                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="numero">DNI/RUC: <span
                                        class="text-rose-500">*</span></label>
                                <input x-mask="99999999999" placeholder="Escribe el N° de documento"
                                    class="form-input w-full" required type="text"
                                    wire:model.live.blur="numero_documento" maxlength="11">
                                @if ($errorConsulta)
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $errorConsulta }}
                                    </p>
                                @endif
                                @error('numero_documento')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="numero">Razon Social o Nombre:
                                    <span class="text-rose-500">*</span></label>
                                <input id="razon_social" placeholder="Razon Social o Nombre" class="form-input w-full"
                                    required type="text" wire:model.live="razon_social">

                                @error('razon_social')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="telefono">Telefono: </label>

                                <input x-mask="999999999" type="tel" placeholder="987654321"
                                    class="form-input w-full" type="text" wire:model.live="telefono" maxlength="9">

                                @error('telefono')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <label class="block text-sm font-medium mb-1" for="email">Correo: </label>

                                <input id="email" placeholder="clientes@correo.com" class="form-input w-full"
                                    type="email" wire:model.live="email">

                                @error('email')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="col-span-12">
                                <label class="block text-sm font-medium mb-1" for="email">Dirección: </label>

                                <input id="direccion" placeholder="Escribe la direccion..." class="form-input w-full"
                                    type="email" wire:model.live="direccion">

                                @error('direccion')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                    </form>

                </div>

                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click.prevent="closeModal">Cerrar</button>
                        <button wire:click.prevent="saveCliente()"
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
        window.addEventListener('save-cliente', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'CLIENTE REGISTRADO',
                    message: 'Cliente ' + event.detail.razon_social + ' Registrado correctamente!',
                });
            });
        })
    </script>
@endpush
