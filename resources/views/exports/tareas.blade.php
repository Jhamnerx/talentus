<!DOCTYPE html>
<html lang="en">

<body>

    <table class="detalle">
        <tbody class="text-sm divide-y divide-slate-200">
            <tr>
                <td colspan="2">
                    <div class="text-center">
                        {{$tecnico->name}}
                    </div>

                </td>
            </tr>
            <tr>
                <td>Fecha Inicial</td>
                <td>{{$fechas['fecha_inicial']}}</td>
            </tr>
            <tr>
                <td>Fecha Final</td>
                <td>{{$fechas['fecha_final']}}</td>
            </tr>

            <tr>
                <td>Total:</td>
                <td>S/. {{number_format($total_costo, 2)}}</td>
            </tr>
        </tbody>



    </table>

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

                    @switch($tarea->tipo_tarea_id)
                    @case(1)

                    Instalación de GPS {{$tarea->dispositivo}} en vehículo:
                    <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                    instalación: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                    <b>{{$tarea->fecha_hora->format('h:i A')}}</b>

                    @break

                    @case(2)
                    Cambio de chip en el vehículo: <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                    Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                    <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                    @break
                    @case(3)
                    Desinstalación de GPS {{$tarea->dispositivo}} en el vehículo:
                    <b>{{$tarea->vehiculo->placa}}</b>, Fecha Tarea:
                    <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                    <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                    @break
                    @case(4)
                    Instalación de Velocimetro <b>{{$tarea->modelo_velocimetro}}</b> en el vehículo:
                    <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                    Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                    <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                    @break
                    @case(5)
                    Mantenimiento GPS {{$tarea->dispositivo}} en el vehículo:
                    <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                    Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                    <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                    @break

                    @endswitch


                </td>

                <td>


                    {{$tarea->vehiculo->placa}}

                </td>

                <td>

                    {{$tarea->estado->name()}}

                </td>
                <td>


                    {{$tarea->fecha_termino ? $tarea->fecha_termino->format('d-m-Y') : '-'}}

                </td>
                <td>

                    {{$tarea->tipo_tarea->costo}}



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

</body>

</html>
