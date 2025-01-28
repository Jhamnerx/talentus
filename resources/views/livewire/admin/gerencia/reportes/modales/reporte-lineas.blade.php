<x-form.modal.card title="REPORTE DE LINEAS" blur wire:model.live="showModal" align="center" persistent>

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Selecciona Operador:" placeholder="Selecciona Operador" wire:model.live="operador">

                @foreach ($operadores as $operador)
                    <x-select.option label="{{ $operador->operador }}" value="{{ $operador->operador }}" />
                @endforeach
            </x-form.select>
        </div>
        <div class="col-span-12 md:col-span-6 gap-2">
            <label class="block text-sm font-medium mb-1" for="plataforma">Suspendidos:
            </label>
            <div class="flex flex-wrap items-center">


                <div class="">
                    <label class=" flex items-center">
                        <input type="checkbox" name="radio-buttons" class="form-radio w-6 h-6"
                            wire:model.live="suspencion" value="true" />

                    </label>
                </div>


            </div>
        </div>
        <div class="col-span-12 mt-2">
            <label
                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                <div>OPCIONES PARA EXPORTAR: </div>

            </label>
            <div class="flex flex-wrap items-center justify-center -m-1.5 gap-3 mt-2">
                {{-- <div class="flex flex-wrap pt-2 -space-x-px gap-3">
                                        <x-form.button wire:click.prevent="exportToPdf" spinner="exportToPdf"
                                            label="PDF" red icon="arrow-down-tray" />

                                    </div> --}}

                <div class="flex flex-wrap pt-2 -space-x-px gap-3">
                    <x-form.button label="EXCEL" wire:click.prevent="exportToExcel" spinner="exportToExcel" emerald
                        icon="arrow-down-tray" />
                </div>
            </div>


        </div>
        <div class="col-span-12">
            <div class="mb-1 text-center w-full" wire:loading wire:target="exportToPdf">

                <div class='loader-download'>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--text-download'></div>
                </div>

            </div>
        </div>
        <div class="col-span-12">
            <div class="mb-1 text-center w-full" wire:loading wire:target="exportToExcel">

                <div class='loader-download'>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--dot-download'></div>
                    <div class='loader--text-download'></div>
                </div>

            </div>
        </div>
    </div>

</x-form.modal.card>
