<div class="m-1 credito w-full col-span-12">
    <div class="overflow-x-auto">
        <div class="rounded-lg shadow-lg bg-white text-center grid grid-cols-12 gap-2">
            {{-- HEADER --}}
            <div class="grid grid-cols-12 gap-2 col-span-12 rounded-sm">
                <div class="col-span-12 xl:col-span-6 p-2">
                    <label for="numero_cuotas">N° de cuotas:</label>

                </div>
                <div class="col-span-12 xl:col-span-6 p-2">

                    <x-form.inputs.number autocomplete="off" errorless='false' id="numero_cuotas" name="numero_cuotas"
                        wire:model.live="numero_cuotas" min="0" />

                </div>

                <div class="col-span-12 xl:col-span-6 p-2">
                    <label for="vence_cuotas">Cada cuota vence:</label>
                </div>

                <div class="col-span-12 xl:col-span-6 p-2">

                    <x-form.inputs.number autocomplete='off' errorless='false' id="vence_cuotas" name="vence_cuotas"
                        wire:model.live="vence_cuotas" />
                </div>
            </div>

            <div class="col-span-12 border rounded-sm">
                <x-form.errors only="numero_cuotas|vence_cuotas" />

            </div>

            <div class="col-span-12 overflow-x-auto relative shadow-md rounded-lg m-2 ">
                <table class="text-sm text-left text-gray-500 dark:text-gray-400 w-full">
                    <thead
                        class="text-2xs text-white uppercase bg-gray-200 dark:bg-gray-700 bg-gradient-to-r from-slate-800  to-cyan-600 border-t">
                        <tr>
                            <th scope="col" class="py-3 px-2">
                                N° Cuota
                            </th>
                            <th scope="col" class="py-3 px-2">
                                Dias
                            </th>
                            <th scope="col" class="py-3 px-2 text-center">
                                Fecha Cuota
                            </th>
                            <th scope="col" class="py-3 px-4">
                                Dia de la semana
                            </th>
                            <th scope="col" class="py-3 px-2 text-center">
                                Importe
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">

                        @if (!$cuotas->isEmpty())
                            @foreach ($cuotas->all() as $clave => $cuota)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row"
                                        class="py-2 px-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Cuota-{{ $cuota['n_cuota'] }}
                                    </td>
                                    <td class="py-2 px-2">
                                        {{ $cuota['dias'] }}
                                    </td>
                                    <td class="py-2 px-2 min-w-36 text-center">
                                        {{ $cuota['fecha'] }}
                                    </td>
                                    <td class="py-2 px-4">
                                        {{ $cuota['dia_semana'] }}
                                    </td>
                                    <td class="py-2 px-2 min-w-36 text-center">
                                        <x-form.inputs.currency class="text-xs"
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
                                <td class="py-2 px-6" colspan="4">
                                    Total Suma Cuotas:
                                    <div class="inline-flex font-medium text-right text-lg">
                                        {{ $totalcuotas }}
                                    </div>

                                </td>
                            </tr>
                            @if ($errors->has('detalle_cuotas.*'))
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-2 px-6 text-center" colspan="5">
                                        <p class="mt-2  text-pink-600 text-sm">
                                            {{ $errors->first('detalle_cuotas.*') }}
                                        </p>
                                    </td>
                                </tr>
                            @endif
                            @if ($errors->has('total_cuotas'))
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-2 px-6 text-center" colspan="5">
                                        <p class="mt-2  text-pink-600 text-sm">
                                            {{ $errors->first('total_cuotas') }}
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-2 px-6 text-center" colspan="5">
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
