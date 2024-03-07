<html>
<table id="mantenimientos">
    <!-- Table header -->
    <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                EMPRESA
            </th>
            <th>
                VEHICULO
            </th>
            <th>
                DETALLE
            </th>
            <th>
                FECHA PROGRAMADA
            </th>

            <th>
                ESTADO
            </th>
            <th>
                NOTA
            </th>
            <th>
                Registrada por
            </th>

        </tr>
    </thead>
    <!-- Table body -->
    <tbody class="text-sm divide-y divide-slate-200">

        <!-- Row -->
        @if ($mantenimientos->count())
            @foreach ($mantenimientos as $mantenimiento)
                <tr>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="font-medium text-sky-600">

                            #{{ $mantenimiento->numero }}

                        </div>

                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800">
                            {{ $mantenimiento->vehiculo->cliente ? $mantenimiento->vehiculo->cliente->razon_social : '' }}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800">
                            {{ $mantenimiento->vehiculo->placa }}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-emerald-500">
                            {{ $mantenimiento->detalle_trabajo }}

                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800">
                            {{ $mantenimiento->fecha_hora_mantenimiento }}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div
                            class="inline-flex font-medium bg-{{ $mantenimiento->estado->color() }}-100 text-{{ $mantenimiento->estado->color() }}-600 rounded-full text-center px-2.5 py-0.5">
                            {{ $mantenimiento->estado->name }}
                        </div>

                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>{{ $mantenimiento->nota }}</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>
                            @if ($mantenimiento->user)
                                {{ $mantenimiento->user->name }}
                            @endif

                        </div>
                    </td>

                </tr>
            @endforeach
        @else
            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                <div class="text-center">No hay Registros</div>
            </td>
        @endif


    </tbody>
</table>

</html>
