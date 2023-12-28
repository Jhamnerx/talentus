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
                    <div class="font-semibold text-left">ACCIONES</div>
                </th>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200 listaItems">



            {{-- fila para añadir --}}
            @if ($items->count() > 0)
                @foreach ($items->all() as $clave => $item)
                    <tr class="main bg-slate-100" wire:key="item-{{ $clave }}">
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="font-normal text-center" x-text="$wire.items[{{ $clave }}].codigo">
                            </div>
                            @if ($errors->has('items.' . $clave . '.codigo'))
                                <p class="mt-2
                                text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.codigo') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="font-normal text-center" x-text="$wire.items[{{ $clave }}].unit_name">
                            </div>

                            @if ($errors->has('items.' . $clave . '.unit_name'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.unit') }}
                                </p>
                            @endif

                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-36 md:min-w-0">

                            <x-form.inputs.number wire:model="items.{{ $clave }}.cantidad" min="1"
                                step="1" placeholder="Cantidad" />
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <x-form.textarea required wire:model="items.{{ $clave }}.descripcion" />

                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-normal text-center"
                                x-text="$wire.items[{{ $clave }}].valor_unitario">
                            </div>

                            @if ($errors->has('items.' . $clave . '.valor_unitario'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.valor_unitario') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-normal text-center" x-text="$wire.items[{{ $clave }}].igv">
                            </div>

                            @if ($errors->has('items.' . $clave . '.igv'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.igv') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-normal text-center" x-text="$wire.items[{{ $clave }}].total">
                            </div>

                            @if ($errors->has('items.' . $clave . '.total'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.total') }}
                                </p>
                            @endif
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <div class="space-x-1">
                                <button type="button" wire:click.prevent="eliminarProducto('{{ $clave }}')"
                                    class="text-rose-500 hover:text-rose-600 rounded-full">
                                    <span class="sr-only">Delete</span>
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                        <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                        <path
                                            d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
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
