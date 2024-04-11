<x-form.modal.card title="Editar Linea" blur wire:model.live="modalEdit" align="center" max-width="3xl">


    <div class=" relative">
        <table class="table-auto w-full">
            <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                <tr>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">#</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">NUMERO</div>
                    </th>

                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">OPERADOR</div>
                    </th>

                </tr>
            </thead>

            <tbody class="text-sm divide-y divide-slate-200">


                <tr>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="col-span-1 sm:col-span-1 flex items-center justify-center">
                            <span>1</span>
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.input placeholder="número de linea" wire:model.live="numero" />
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.input placeholder="ingresa operador" wire:model.change="operador" />
                    </td>

                </tr>

            </tbody>
        </table>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click.prevent='closeModal' />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
