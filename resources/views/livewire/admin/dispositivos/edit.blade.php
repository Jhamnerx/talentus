<x-form.modal.card title="EDITAR DISPOSITIVOS" blur wire:model.live="modalEdit" align="center" max-width="3xl">

    <div class=" relative">
        <table class="table-auto w-full">
            <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                <tr>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">#</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">IMEI</div>
                    </th>

                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-left">MODELO</div>
                    </th>
                    <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-semibold text-center">DE CLIENTE</div>
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
                        <x-form.input placeholder="IMEI DISPOSITIVO" wire:model.live="imei" />
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap  text-left">
                        <x-form.select name="modelo_idd" wire:model.live="modelo_id" placeholder="Selecciona un modelo"
                            :async-data="[
                                'api' => route('api.dispositivos.modelos.index'),
                            ]" option-label="modelo" option-value="id" option-description="marca" />

                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.toggle name="of_client" wire:model.live="of_client" value="true" />

                    </td>

                </tr>

            </tbody>
        </table>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click.prevent='cancel' />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
