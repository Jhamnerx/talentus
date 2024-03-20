<div class="overflow-x-auto border border-violet-400 rounded-lg">
    <table class="w-full">
        <thead
            class="text-xs font-semibold uppercase text-white  bg-gradient-to-r from-slate-800  to-indigo-500 border-t border-b rounded-lg border-slate-200">
            <tr>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">CODIGO</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">CANTIDAD</div>
                </th>


                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">UNI/MEDIDA</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">DESCRIPCION</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">ACCIONES</div>
                </th>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200 listaItems">
            <!-- Seleccionado -->
            <tr class="main bg-slate-50 pt-4">

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <input wire:model.live="selected.codigo" type="text" class="form-input" placeholder="codigo"
                        disabled readonly>
                    @if ($errors->has('selected.codigo'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.codigo') }}
                        </p>
                    @endif
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.inputs.number wire:model.live="selected.cantidad" min="1" step="1"
                        min='1' placeholder="Cantidad" />
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <input type="text" wire:model.live="selected.unidad_medida" class="form-input unidad_medida"
                        disabled readonly placeholder="unidad de medida">
                    @if ($errors->has('selected.unidad_medida'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.unidad_medida') }}
                        </p>
                    @endif

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <textarea rows="4" wire:model.live="selected.descripcion" class="form-input descripcion"
                        placeholder="Descripción"></textarea>
                    @if ($errors->has('selected.descripcion'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.descripcion') }}
                        </p>
                    @endif
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                    <div class="space-x-1">
                        <x-form.button.circle wire:click="addProducto" spinner="addProducto" teal icon="check" />
                    </div>
                </td>
                <p class="mt-2 hidden text-pink-600 text-sm vacio">
                    Debes añadir al menos 1 item
                </p>
            </tr>

            {{-- fila para añadir --}}

            @foreach ($items->all() as $clave => $item)
                <tr wire:key="item-{{ $clave }}-{{ $item['producto_id'] }}">
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <input type="text" wire:model.live="items.{{ $clave }}.codigo" class="form-input"
                            readonly>
                        @if ($errors->has('items.' . $clave . '.codigo'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.codigo') }}
                            </p>
                        @endif
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.inputs.number wire:model.live="items.{{ $clave }}.cantidad" min="1"
                            step="1" placeholder="Cantidad" />
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.select wire:model.live="items.{{ $clave }}.unidad_medida" :async-data="[
                            'api' => route('api.unidades.index'),
                        ]"
                            option-label="descripcion" option-value="codigo" :clearable="false" class="z-6" />
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <textarea required wire:model.live="items.{{ $clave }}.descripcion" class="form-textarea" rows="4"></textarea>
                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                        <div class="space-x-1">

                            <x-form.button label="Eliminar"
                                wire:click.prevent="eliminarProducto('{{ $clave }}')" outline red sm
                                icon="trash" />
                        </div>
                    </td>
                </tr>
            @endforeach


            @if ($items->count() < 1)
                <tr>
                    <td colspan="4" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="font-normal text-center">
                            AÑADIR PRODUCTOS
                        </div>

                    </td>
                </tr>
            @endif
        </tbody>

    </table>
</div>
