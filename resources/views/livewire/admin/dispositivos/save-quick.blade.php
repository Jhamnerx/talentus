<div>
    <div class="relative inline-flex">
        <button type="button" wire:click="openModal" aria-controls="basic-modal"
            class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                <path
                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
            </svg>
        </button>
    </div>

    <x-form.modal.card title="REGISTRO RAPIDO DISPOSITIVO" max-width="2xl" wire:model.live="modalOpen" align="center">

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

                                <input type="text" wire:model.live="imei" class="form-input w-full"
                                    placeholder="Ingresa el imei">
                                @error('imei')
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-span-12 sm:col-span-6">


                                {!! Form::label('modelo_id', 'Modelo:', ['class' => 'block text-sm font-medium mb-1']) !!}

                                <select name="modelo_id" id="modelo_id" wire:model.live="modelo_id"
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
                                            <input type="checkbox" name="of_client" wire:model.live="of_client"
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

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
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
