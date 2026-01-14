<div>
    <x-form.modal.card title="REPORTE DE PRODUCTOS" max-width="2xl" wire:model.live="modalReporte" align="center">

        <form autocomplete="off" autocapitalize="true">


            <div class="px-8 py-5 bg-white sm:p-6">

                <div class="grid grid-cols-12 gap-6">

                    <div class="col-span-12 md:col-span-6 gap-2">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>Tipo de Producto: <span class="text-sm text-red-500"> * </span></div>

                        </label>
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <select wire:model.live="tipo" class="form-select w-full pl-9" id="">
                                <option value="null" selected>TODOS</option>
                                <option value="SERVICIO">SERVICIO</option>
                                <option value="PRODUCTO">PRODUCTO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <label
                            class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                            <div>OPCIONES PARA EXPORTAR: </div>

                        </label>
                        <div class="flex flex-wrap items-center -m-1.5">
                            <div class="flex flex-wrap pt-2 -space-x-px gap-3">
                                <x-form.button wire:click.prevent='exportToPdf' spinner="exportToPdf" label="PDF" red
                                    icon="arrow-down-tray>" />


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
