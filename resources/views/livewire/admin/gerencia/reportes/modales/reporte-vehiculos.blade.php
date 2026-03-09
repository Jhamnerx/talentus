<div>
    <x-form.modal.card title="REPORTE DE VEHICULOS" max-width="2xl" wire:model.live="modalReporte" align="center">

        <form autocomplete="off" autocapitalize="true">


            <div class="px-8 py-5 bg-white sm:p-6 divide-y">

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-6 gap-2">
                        <label class="block text-sm font-medium mb-1" for="plataforma">Solo Activos:
                        </label>
                        <div class="flex flex-wrap items-center">


                            <div class="">
                                <label class=" flex items-center">
                                    <input type="checkbox" name="radio-buttons" class="form-radio w-6 h-6"
                                        wire:model.live="is_active" value="true" />
                                    {{-- <span class="text-sm ml-2">{{$tecnico->name}}</span> --}}
                                </label>
                            </div>


                        </div>
                    </div>
                    <div class="col-span-12">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>OPCIONES PARA EXPORTAR: </div>

                        </label>
                        <div class="flex flex-wrap items-center justify-center -m-1.5">
                            <div class="flex flex-wrap pt-2 -space-x-px gap-3">
                                <button wire:click.prevent="exportToPdf"
                                    class="btn bg-white border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-indigo-600 rounded-none first:rounded-l last:rounded-r">PDF</button>
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
                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
