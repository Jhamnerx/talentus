<x-form.modal.card title="ASIGNAR LINEA A PLACA" wire:model.live="openModal" align="center">
    <div class="text-sm">

        <div class="mb-4">
            Modificaras la siguiente Linea: <span
                class="s text-base font-medium">{{ $linea ? $linea->numero : '' }}</span>
            <br>
            Tiene el Siguiente Sim Card: <span
                class="s text-base font-medium">{{ $linea ? $linea->sim_card->sim_card : '' }}</span>
        </div>
    </div>


    @if ($asignado)
        <div class="overflow-x-auto mb-2">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>

                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">PLACA</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">CLIENTE</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">ACCION</div>
                        </th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y divide-slate-200">

                    <tr>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left font-medium text-sky-500">
                                {{ $linea->sim_card->vehiculos->placa }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">
                                {{ $linea->sim_card->vehiculos->cliente ? $linea->sim_card->vehiculos->cliente->razon_social : '' }}
                            </div>
                        </td>
                        <td>
                            <div class="space-x-1">

                                @if ($confirm)
                                    <x-form.button wire:click.prevent="confirmation()" icon="exclamation" warning
                                        label="Confirmar" />
                                @else
                                    <x-form.button wire:click.prevent="removeLinea()" icon="x" negative
                                        label="Remover Linea" />
                                @endif

                            </div>

                        </td>

                    </tr>
                    @if ($confirm)
                        <tr>
                            <td colspan="3">
                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    Confirma la acción haciendo click nuevamente en el boton

                                </p>
                                <p>Se Guardara los datos de la linea en el vehiculo</p>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
        @if (!$confirm)
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                Debes eliminar el número del actual vehiculo para asignar a otro
            </p>
        @endif
    @endif
    <div class="px-8 py-5 bg-white sm:p-6">

        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 sm:col-span-6">
                <x-form.select id="vehiculo_id" name="vehiculo_id" label="Selecciona un vehiculo"
                    wire:model.live="vehiculo_id" placeholder="Selecciona un vehiculo" :async-data="[
                        'api' => route('api.vehiculos.index'),
                    ]"
                    option-label="placa" option-value="id" />
            </div>
        </div>

    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" class="{{ $asignado ? 'hidden' : '' }}" wire:click="asign" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>

@push('scripts')
    <script></script>
@endpush
