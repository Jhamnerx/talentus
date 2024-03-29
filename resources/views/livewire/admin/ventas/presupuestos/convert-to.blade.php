<x-form.modal.card title="Convertir a Comprobante COTIZACION: {{ $presupuesto ? $presupuesto->serie_correlativo : '' }}"
    wire:model.live="modalConvert" align="center">
    @if ($presupuesto)
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>

                        <th class="px-2 first:pl-5 last:pr-5 py-3 ">
                            <div class="font-semibold text-left">#Número</div>
                        </th>

                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Total</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Cliente</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">FORMA PAGO</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Emitido el</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Vence el</div>
                        </th>

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">

                    <!-- Row -->

                    <tr>

                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-medium text-sky-500">
                                #{{ $presupuesto->numero ? $presupuesto->numero : $presupuesto->serie_correlativo }}
                            </div>
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-emerald-500">
                                @if ($presupuesto->divisa == 'PEN')
                                    S/. {{ $presupuesto->total }}
                                @else
                                    ${{ $presupuesto->total }}
                                @endif

                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div
                                class="inline-flex font-medium bg-{{ $presupuesto->estado->color() }}-100 text-{{ $presupuesto->estado->color() }}-600 rounded-full text-center px-2.5 py-0.5">
                                {{ $presupuesto->estado->name }}
                            </div>

                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-medium text-slate-900">
                                {{ $presupuesto->clientes->razon_social }}
                            </div>
                            <div class="font-sm text-slate-700">
                                <p class="text-xs">
                                    {{ $presupuesto->clientes->numero_documento }}
                                </p>

                            </div>

                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            @if ($presupuesto->forma_pago == 'CREDITO')
                                <div>
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <button class="inline-flex justify-center items-center group"
                                            aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                            <div class="flex items-center truncate">
                                                <span
                                                    class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">
                                                    {{ $presupuesto->forma_pago }}
                                                </span>
                                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                    viewBox="0 0 12 12">
                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                </svg>
                                            </div>
                                        </button>
                                        <div class="origin-top-right z-10 absolute top-full left-0 min-w-44 bg-white border border-slate-300 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                                            @click.outside="open = false" @keydown.escape.window="open = false"
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200 transform"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            x-cloak>
                                            <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
                                                <div class="font-medium text-slate-800">Detalle de cuotas.
                                                </div>
                                                <div class="text-sm text-slate-600">
                                                    Adelanto:
                                                    {{ $presupuesto->divisa == 'USD' ? "$ " . $presupuesto->adelanto : 'S/. ' . $presupuesto->adelanto }}
                                                </div>

                                            </div>
                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">
                                                            N° Cuota
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Fecha
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Importe
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($presupuesto->detalle_cuotas as $key => $cuota)
                                                        <tr
                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                            <th scope="row"
                                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                                                Cuota-{{ $key + 1 }}

                                                            </th>
                                                            <td class="px-6 py-4">
                                                                {{ $cuota['fecha'] }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $presupuesto->divisa == 'PEN' ? 'S/ ' : '$ ' }}
                                                                {{ $cuota['importe'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- End -->
                                </div>
                            @else
                                <div class="font-medium text-slate-800">
                                    {{ $presupuesto->forma_pago }}
                                </div>
                            @endif


                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div>{{ $presupuesto->fecha->format('Y-m-d') }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div>{{ $presupuesto->fecha_caducidad->format('Y-m-d') }}</div>
                        </td>

                    </tr>



                </tbody>
            </table>
        </div>
    @endif
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 mb-2">

            <span class="font-semibold">DATOS PARA EL COMPROBANTE</span>
        </div>
        {{--    tipoo --}}
        <div class="col-span-12 md:col-span-4 mb-2">

            <x-form.select label="Tipo Comprobante:" id="tipo_comprobante_id" name="tipo_comprobante_id"
                :options="$docs" option-label="name" option-value="id" wire:model.live="tipo_comprobante_id"
                :clearable="false" icon="document-search" />

        </div>


        {{-- SERIE --}}
        <div class="col-span-12 md:col-span-4 xl:col-span-4">

            <x-form.select id="serie" name="serie" label="Serie:" wire:model.live="serie"
                placeholder="Selecciona una serie" :async-data="[
                    'api' => route('api.series.index'),
                    'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                ]" option-label="serie" option-value="serie" />
        </div>

        {{-- CORRELATIVO --}}
        <div class="col-span-12 md:col-span-4 xl:col-span-4">

            <x-form.inputs.number id="correlativo" readonly name="correlativo" wire:model.live="correlativo"
                label="Correlativo:" />

        </div>
        <div class="col-span-12 md:col-span-4 xl:col-span-4">
            @error('serie_correlativo')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
