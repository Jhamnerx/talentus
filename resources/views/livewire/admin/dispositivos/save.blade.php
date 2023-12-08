<x-form.modal.card title="REGISTRAR DISPOSITIVOS" blur wire:model.live="modalCreate" align="center" max-width="3xl">

    <div class="flex flex-auto gap-2 mx-4 py-2">
        <div class=""></div>
        <div class="w-full">
            <x-form.button.circle wire:click.prevent="addItem" spinner="addItem" primary label="+"
                class="float-right" />
        </div>
    </div>
    <div class=" relative">
        <table class="table-auto w-full">
            <thead
                class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
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
                        <div class="font-semibold text-center">ACCIONES</div>
                    </th>
                </tr>
            </thead>

            <tbody class="text-sm divide-y divide-slate-200">
                @foreach ($items->all() as $clave => $item)
                    <tr wire:key="{{ $clave }}">
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="col-span-1 sm:col-span-1 flex items-center justify-center">
                                <span>{{ $clave + 1 }}</span>
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <x-form.input placeholder="IMEI DISPOSITIVO"
                                wire:model.live="items.{{ $clave }}.imei" />
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <x-form.select name="modelo_id" wire:model.live="items.{{ $clave }}.modelo_id"
                                placeholder="Selecciona un modelo" :async-data="[
                                    'api' => route('api.dispositivos.index'),
                                ]" option-label="modelo"
                                option-value="id" option-description="marca" />

                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <x-form.button.circle negative icon="x"
                                wire:click.prevent="eliminarItem('{{ $clave }}')" />
                        </td>

                    </tr>
                @endforeach
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
