<div class="overflow-x-auto">
    <table class="w-full">
        <!-- Table header -->
        <thead class="text-xs font-semibold uppercase text-white bg-slate-700 dark:bg-gray-900 border-t border-b border-slate-200 dark:border-gray-600">
            <tr>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Artículo o Servicio</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Descripción</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">Cantidad</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">Precio</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">Importe</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">Acciones</div>
                </th>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-600 listaItems">

            {{-- FILA DE NUEVO ÍTEM (edición) --}}
            <tr class="main bg-cyan-50 dark:bg-cyan-900/20 border-l-4 border-cyan-400 dark:border-cyan-500">
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.textarea required wire:model.live="selected.producto" />

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.textarea required wire:model.live="selected.descripcion" />
                    <div x-data="{ showPdf: false }" class="mt-1">
                        <a href="#" @click.prevent="showPdf = !showPdf" class="text-xs text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">
                            <span x-text="showPdf ? '▲ Descripción PDF' : '+ Descripción PDF'"></span>
                        </a>
                        <div x-show="showPdf" style="display: none;" class="mt-1">
                            <x-form.textarea wire:model.live="selected.descripcion_pdf" placeholder="Descripción para factura impresa" />
                        </div>
                    </div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.number required wire:model.live="selected.cantidad" min="1" step="1" placeholder="45" />

                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.currency placeholder="100.00" wire:model.live="selected.precio" precision="4" />
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                    <div class="space-x-1">

                        <button type="button" wire:click="addProducto"
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
            {{-- filas de ítems ya añadidos --}}
            @if (app()->environment('local'))
            {{ json_encode($items) }}
            @endif
            @if ($items->count() > 0)
            @foreach ($items->all() as $clave => $item)
            <tr wire:key="item-{{ $clave }}" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.textarea required wire:model.live="items.{{ $clave }}.producto" />

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <x-form.textarea required wire:model.live="items.{{ $clave }}.descripcion" />
                    @php $hasImeis = !empty($items[$clave]['imeis'] ?? null); @endphp
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        @if($hasImeis)
                            <a href="#" wire:click.prevent="editarImeis({{ $clave }})" class="text-xs text-indigo-400 hover:text-indigo-600 dark:text-indigo-400 dark:hover:text-indigo-300 hover:underline">✏️ IMEIs</a>
                        @endif
                        <div x-data="{ showPdf: false }">
                            <a href="#" @click.prevent="showPdf = !showPdf" class="text-xs text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">
                                <span x-text="showPdf ? '▲ Descripción PDF' : '+ Descripción PDF'"></span>
                            </a>
                            <div x-show="showPdf" style="display: none;" class="mt-1">
                                <x-form.textarea wire:model.live="items.{{ $clave }}.descripcion_pdf" placeholder="Descripción para factura impresa" />
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <x-form.number wire:model.live="items.{{ $clave }}.cantidad" min="1" step="1"
                        placeholder="Cantidad" />
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-800 dark:text-gray-200">
                        {{ $items[$clave]['precio'] }}
                    </div>

                    @if ($errors->has('items.' . $clave . '.precio'))
                    <p class="mt-2  text-pink-600 text-sm">
                        {{ $errors->first('items.' . $clave . '.precio') }}
                    </p>
                    @endif
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-800 dark:text-gray-200">
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

                        <x-form.button label="Eliminar" wire:click.prevent="eliminarProducto('{{ $clave }}')" outline
                            red sm icon="trash" />

                    </div>
                </td>
            </tr>
            @endforeach
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