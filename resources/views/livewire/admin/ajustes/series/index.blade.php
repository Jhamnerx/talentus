<div class="w-full flex flex-col shadow-md rounded-lg bg-white dark:bg-secondary-800 ">

    <div class="px-2 py-5 md:px-4 text-secondary-700 rounded-b-xl grow dark:text-secondary-400">
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <span class="font-medium">¡Alerta de información!</span> Si no generas un número de serie para cada
            documento, no podrás emitir todos los comprobantes de pago disponibles.
        </div>

        <div class="flex items-center mb-8">
            <hr class="w-12">

            <span class="mx-4 text-xl font-semibold">Documentos y series</span>

            <hr class="flex-1">
        </div>

        <form class="mb-4">

            <div class="grid grid-cols-4 gap-6">

                <div class="col-span-4 lg:col-span-1">
                    <div class="">

                        <x-form.select id="tipo_comprobante_id" name="tipo_comprobante_id" :searchable="false"
                            :clearable="false" wire:model="tipo_comprobante_id" placeholder="Tipo de documento"
                            :async-data="[
                                'api' => route('api.comprobantes.index'),
                            ]" option-label="descripcion" option-value="codigo" />

                    </div>
                </div>

                <div class="col-span-2 lg:col-span-1">

                    <div>
                        <div class="">

                            <div class="relative rounded-md  shadow-sm ">

                                <x-form.inputs.maskable maxlength="4" autocomplete="off" mask="XXXX"
                                    placeholder="F001" wire:model='serie' />

                            </div>


                        </div>
                    </div>

                </div>

                <div class="col-span-2 lg:col-span-1">

                    <div class="">

                        <div class="relative rounded-md  shadow-sm ">


                            <x-form.inputs.number autocomplete="off" wire:model.live='correlativo' name="correlativo"
                                min="0" />
                        </div>


                    </div>

                </div>

                <div class="col-span-4 lg:col-span-1 pt-[0.5px]">

                    <x-form.button wire:click.prevent='addSerie' rounded squared primary label="Agregar comprobante" />
                </div>

            </div>

        </form>

        <div>
            @foreach ($series as $serie)
                <div class="grid grid-cols-4 gap-6 items-center py-3 border-t" wire:key="serie-{{ $serie->id }}">

                    <div class="col-span-4 lg:col-span-1">
                        {{ $serie->tipoComprobante->descripcion }}
                    </div>

                    <div class="flex lg:justify-center col-span-2 lg:col-span-1">
                        Serie: {{ $serie->serie }}
                    </div>

                    <div class="flex justify-end lg:justify-center col-span-2 lg:col-span-1">
                        Correlativo: {{ $serie->correlativo }}
                    </div>

                    <div class="col-span-4 lg:col-span-1">

                        <x-form.button outline rose label="Eliminar"
                            wire:click.prevent="deleteSerie({{ $serie->id }})" />

                    </div>

                </div>
            @endforeach

            {{ $series->links() }}
        </div>
    </div>

</div>
