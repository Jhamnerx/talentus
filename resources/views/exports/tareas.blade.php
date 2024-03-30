<!DOCTYPE html>
<html lang="en">

<body>

    <table class="detalle" border="1">
        <tbody class="text-sm divide-y divide-slate-200">

            <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                    <div class="text-center">
                        {{ $tecnico->name }}
                    </div>

                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>

                <td>Fecha Inicial</td>
                <td>{{ $fechas['fecha_inicial'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Fecha Final</td>
                <td>{{ $fechas['fecha_final'] }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>S/. {{ number_format($total_costo, 2) }}</td>
            </tr>
        </tbody>



    </table>
    <div>

    </div>
    <table>
        <thead>
            <tr>
                <td>
                    #Tarea

                </td>
                <td>
                    Descripción
                </td>
                <td>
                    Empresa
                </td>
                <td>
                    Vehiculo
                </td>
                <td>
                    Estado
                </td>
                <td>
                    Fecha Termino
                </td>
                <td>
                    Costo
                </td>
            </tr>
        </thead>
        <tbody>

            <!-- Row -->
            @if ($tareas->count())
                @foreach ($tareas as $tarea)
                    <tr>

                        <td>

                            {{ $tarea->token }}
                        </td>

                        <td>

                            @php
                                $datos = [
                                    '%placa%' => '<b>' . $tarea->vehiculo->placa . '</b>',
                                    '%velo_modelo%' => '<b>' . $tarea->modelo_velocimetro . '</b>',
                                    '%fecha%' => '<b>' . $tarea->fecha_hora->format('d/m/Y') . '</b>',
                                    '%modelo_gps%' => '<b>' . $tarea->dispositivo . '</b>',
                                    '%hora%' => '<b>' . $tarea->fecha_hora->format('h:i A') . '</b>',
                                ];

                                $info = strtr($tarea->tipo_tarea->descripcion, $datos);
                            @endphp
                            {!! $info !!}

                        </td>
                        <td>

                            {{ $tarea->vehiculo->cliente ? $tarea->vehiculo->cliente->razon_social : 'CLIENTE NO ENCONTRADO' }}

                        </td>
                        <td>


                            {{ $tarea->vehiculo->placa }}

                        </td>

                        <td>

                            {{ $tarea->estado->name() }}

                        </td>
                        <td>


                            {{ $tarea->fecha_termino ? $tarea->fecha_termino->format('d-m-Y') : '-' }}

                        </td>
                        <td>

                            {{ $tarea->tipo_tarea->costo }}

                        </td>

                    </tr>
                @endforeach
            @else
                <td colspan="6" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                    <div class="text-center">No hay Registros</div>
                </td>
            @endif

        </tbody>
    </table>

</body>

</html>
