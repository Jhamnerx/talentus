<div class="overflow-x-auto">
    <table class="w-full">
        <thead class="text-xs font-semibold uppercase text-white bg-slate-800  border-t border-b border-slate-200">
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
                    <div class="font-semibold text-left">Acciones</div>
                </th>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200 listaItems">
            <!-- Seleccionado -->
            <tr class="main bg-slate-50">

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <input wire:model="selected.codigo" type="text" class="form-input" placeholder="codigo" disabled
                        readonly>
                    @if ($errors->has('selected.codigo'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.codigo') }}
                        </p>
                    @endif
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <input type="number" wire:model="selected.cantidad" min="1" step="1"
                        class="form-input cantidad" placeholder="Cantidad">
                    @if ($errors->has('selected.cantidad'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.cantidad') }}
                        </p>
                    @endif
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <input type="text" wire:model="selected.unidad_medida" class="form-input unidad_medida" disabled
                        readonly placeholder="unidad de medida">
                    @if ($errors->has('selected.unidad_medida'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.unidad_medida') }}
                        </p>
                    @endif
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <textarea rows="4" wire:model="selected.descripcion" class="form-input descripcion" placeholder="Descripción"></textarea>
                    @if ($errors->has('selected.descripcion'))
                        <p class="mt-2  text-pink-600 text-sm">
                            {{ $errors->first('selected.descripcion') }}
                        </p>
                    @endif
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                    <div class="space-x-1">

                        <button type="button" wire:click.prevent="addProducto"
                            class="text-white btn bg-cyan-500 hover:text-slate-500 ">
                            <span class="sr-only">Añadir</span>


                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g fill="none" class="nc-icon-wrapper">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"
                                        fill="currentColor">
                                    </path>
                                </g>
                            </svg>
                        </button>
                    </div>
                </td>
                <p class="mt-2 hidden text-pink-600 text-sm vacio">
                    Debes añadir al menos 1 item
                </p>
            </tr>

            {{-- fila para añadir --}}
            @if ($items->count() > 0)
                @foreach ($items->all() as $clave => $item)
                    <tr wire:key="item-{{ $clave }}-{{ $item['producto_id'] }}">
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <input type="text" wire:model="items.{{ $clave }}.codigo" class="form-input"
                                readonly>
                            @if ($errors->has('items.' . $clave . '.codigo'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.codigo') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <input required type="number" wire:model="items.{{ $clave }}.cantidad"
                                min="1" step="0.1" class="form-input cantidad" placeholder="Cantidad">
                            @if ($errors->has('items.' . $clave . '.cantidad'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.cantidad') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <input type="text" wire:model="items.{{ $clave }}.unidad_medida"
                                class="form-input" readonly>
                            @if ($errors->has('items.' . $clave . '.unidad_medida'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('items.' . $clave . '.unidad_medida') }}
                                </p>
                            @endif
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <textarea required wire:model="items.{{ $clave }}.descripcion" class="form-textarea" rows="4"></textarea>
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
            @endif

        </tbody>

    </table>
</div>
