<div class="overflow-x-auto border border-violet-400 rounded-lg">
    <table class="w-full">
        <!-- Table header -->
        <thead
            class="text-xs font-semibold uppercase text-white  bg-gradient-to-r from-slate-800  to-indigo-500 border-t border-b rounded-lg border-slate-200">
            <tr>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">CODIGO</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">UNI/MEDIDA</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">CANTIDAD</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">DESCRIPCION</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">VALOR UNITARIO</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">IGV</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">IMPORTE DE VENTA</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">ACCIONES</div>
                </th>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200 listaItems">



            {{-- fila para añadir --}}

            @foreach ($items->all() as $clave => $item)
                <tr class="main bg-slate-100" wire:key="item-{{ $clave }}">
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="font-normal text-center">
                            {{ $items[$clave]['codigo'] }}
                        </div>
                        @if ($errors->has('items.' . $clave . '.codigo'))
                            <p class="mt-2
                                text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.codigo') }}
                            </p>
                        @endif
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="font-normal text-center">
                            {{ $items[$clave]['unit_name'] }}
                        </div>

                        @if ($errors->has('items.' . $clave . '.unit_name'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.unit') }}
                            </p>
                        @endif

                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-36 md:min-w-0">

                        <x-form.inputs.number wire:model.live="items.{{ $clave }}.cantidad" min="1"
                            step="1" placeholder="Cantidad" />
                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <x-form.textarea required wire:model.live="items.{{ $clave }}.descripcion" />

                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-normal text-center">
                            {{ $items[$clave]['valor_unitario'] }}
                        </div>

                        @if ($errors->has('items.' . $clave . '.valor_unitario'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.valor_unitario') }}
                            </p>
                        @endif
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-normal text-center">
                            {{ $items[$clave]['igv'] }}
                        </div>

                        @if ($errors->has('items.' . $clave . '.igv'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.igv') }}
                            </p>
                        @endif
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-normal text-center">
                            {{ $items[$clave]['total'] }}
                        </div>

                        @if ($errors->has('items.' . $clave . '.total'))
                            <p class="mt-2  text-pink-600 text-sm">
                                {{ $errors->first('items.' . $clave . '.total') }}
                            </p>
                        @endif
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
                    <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="font-normal text-center">
                            AÑADIR PRODUCTOS
                        </div>

                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            @error('items')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </tfoot>
    </table>
</div>
