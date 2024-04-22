<div class="mt-2 col-span-12 credito w-full" x-data="{ open: @entangle('showCredit') }">
    <div class="" x-show="open" x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-cloak>

        <div class="overflow-x-auto md:flex md:justify-end" x-show="open">
            <div class="block rounded-lg shadow-lg bg-white text-center border border-gray-300">
                <div class="block md:flex justify-center gap-2 px-2 py-4">
                    <div>
                        <label for="numero_cuotas">N° de cuotas:</label>

                    </div>
                    <div>

                        <x-form.inputs.number autocomplete="false" id="numero_cuotas" name="numero_cuotas"
                            wire:model.live="numero_cuotas" min="0" />

                    </div>

                    <div>
                        <label for="vence_cuotas">Cada cuota vence:</label>
                    </div>
                    <div>

                        <x-form.inputs.number id="vence_cuotas" name="vence_cuotas" wire:model.live="vence_cuotas" />
                    </div>

                </div>
                <div class="flex justify-between gap-2 px-4 py-2">
                    <div class="flex justify-center text-center">
                        <div>
                            @if ($errors->has('numero_cuotas'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('numero_cuotas') }}
                                </p>
                            @endif
                        </div>

                    </div>
                    <div class="flex justify-center text-center">
                        <div>
                            @if ($errors->has('vence_cuotas'))
                                <p class="mt-2  text-pink-600 text-sm">
                                    {{ $errors->first('vence_cuotas') }}
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="overflow-x-auto relative shadow-md rounded-lg m-2 ">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead
                            class="text-xs text-white uppercase bg-gray-200 dark:bg-gray-700 bg-gradient-to-r from-slate-800  to-cyan-600 border-t">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    N° Cuota
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Dias
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Fecha Cuota
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Dia de la semana
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Importe
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!$cuotas->isEmpty())
                                @foreach ($cuotas->all() as $clave => $cuota)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Cuota-{{ $cuota['n_cuota'] }}
                                        </th>
                                        <td class="py-4 px-6">
                                            {{ $cuota['dias'] }}
                                        </td>
                                        <td class="py-4 px-6 min-w-36">
                                            {{ $cuota['fecha'] }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $cuota['dia_semana'] }}
                                        </td>
                                        <td class="py-4 px-6 min-w-36">
                                            <x-form.inputs.currency
                                                wire:model.blur="detalle_cuotas.{{ $clave }}.importe"
                                                precision="4" />

                                        </td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="py-4 px-6" colspan="4">
                                        Total Suma Cuotas:
                                        <div class="inline-flex font-medium text-right text-lg">
                                            {{ $totalcuotas }}
                                        </div>

                                    </td>
                                </tr>
                                @if ($errors->has('detalle_cuotas.*'))
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 text-center" colspan="5">
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('detalle_cuotas.*') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                                @if ($errors->has('total_cuotas'))
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 text-center" colspan="5">
                                            <p class="mt-2  text-pink-600 text-sm">
                                                {{ $errors->first('total_cuotas') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6 text-center" colspan="5">
                                        Por favor ingrese el número de cuotas
                                    </td>
                                </tr>
                            @endif



                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>
</div>
