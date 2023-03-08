<html>

<head>
    <title> TAREA REPORTE #{{ $tarea->token }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @php $fondo=base64_encode(file_get_contents(asset("storage/". $fondo))) @endphp
    <style>
        .page-break {
            page-break-after: always;
        }

        .w-7 {
            width: 1.75rem
                /* 28px */
            ;
        }

        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead {
            font-size: 16px;
            line-height: 1.5;
            color: rgb(100 116 139);
            border-top-width: 1px;
            border-bottom-width: 1px;
            border-bottom-width: 1px;
            font-weight: 600;
        }

        .styled-table thead tr {
            background-color: #052c52;
            color: #ffffff;
            text-align: left;
            text-transform: uppercase;
        }

        .styled-table thead tr th {
            font-weight: 600;
            margin-right: 2px;
            margin-left: 2px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #141D38;
        }

        .text-sm {
            font-size: 0.875rem
                /* 14px */
            ;
            line-height: 1.5715;
        }

        .px-2 {
            padding-left: 0.5rem
                /* 8px */
            ;
            padding-right: 0.5rem
                /* 8px */
            ;
        }

        .first\:pl-5:first-child {
            padding-left: 1.25rem
                /* 20px */
            ;
        }

        .last\:pr-5:last-child {
            padding-right: 1.25rem
                /* 20px */
            ;
        }

        .py-3 {
            padding-top: 0.75rem
                /* 12px */
            ;
            padding-bottom: 0.75rem
                /* 12px */
            ;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .descripcion {
            width: 120px;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-slate-800 {
            --tw-text-opacity: 1;
            color: rgb(30 41 59 / var(--tw-text-opacity));
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .text-blue-700 {
            --tw-text-opacity: 1;
            color: rgb(29 78 216 / var(--tw-text-opacity));
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-center {
            text-align: center;
        }

        .px-5 {
            padding-left: 1.25rem
                /* 20px */
            ;
            padding-right: 1.25rem
                /* 20px */
            ;
        }

        .block {
            display: block;
        }

        .flex {
            display: flex;
        }

        .flex-auto {
            flex: 1 1 auto;
        }

        .text-slate-400 {
            --tw-text-opacity: 1;
            color: rgb(148 163 184 / var(--tw-text-opacity));
        }

        .font-medium {
            font-weight: 500;
        }

        .relative {
            position: relative;
        }

        .m-1\.5 {
            margin: 0.375rem
                /* 6px */
            ;
        }

        .detalle {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 25%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);

        }

        .detalle tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .detalle tbody tr:last-of-type {
            border-bottom: 2px solid #141D38;
        }

        .text-left {
            text-align: left;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .cont-table {
            margin-left: 10px;
            width: 500px;
            margin-right: 10px;
        }

        .tabla1 {
            position: relative;
            width: 500px;
            top: 4rem;

            margin-right: 3rem;
        }

        .tabla2 {
            position: absolute;
            width: 100%;
            top: 27rem;
            width: 100%;
        }

        body:before {
            display: block;
            position: fixed;
            top: -65px;
            right: -28px;
            bottom: -84px;
            left: -98px;

            background-image:

                url(data:image/jpeg;base64,{{ $fondo }});
            background-size: 100%;
            background-repeat: no-repeat;
            /* opacity: .2; */
            content: "";
            z-index: -1000;
        }

        @page {
            display: block;
            flex-wrap: wrap;
            overflow: hidden;

            margin-top: 3.8rem;
            margin-left: 6rem;
            margin-right: 2rem;
            margin-bottom: 3.8rem;
            padding-bottom: 1rem;
        }
    </style>




</head>

<body>


    <header class="px-5 py-4 flex">

        <div class="flex-auto">

            <h2 class="font-semibold text-slate-800 uppercase " style="text-align: center">REPORTE TAREA
                {{$tarea->token}}:

            </h2>

        </div>


        <div class="flex-auto">

            <div class="relative">
                <div class="m-1.5">
                    <!-- Start -->
                    <table class="detalle">
                        <tbody class="text-sm divide-y divide-slate-200">
                            <tr>
                                <td colspan="2">
                                    <div class="text-center">
                                        {{$tarea->tecnico->name}}
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>Fecha Tarea</td>
                                <td>{{$tarea->created_at->format('d-m-Y h:i A')}}</td>
                            </tr>
                            <tr>
                                <td>Fecha Terminada</td>
                                <td>{{$tarea->fecha_termino ? $tarea->fecha_termino->format('d-m-Y h:i A') : ''}}</td>
                            </tr>
                            <tr>
                                <td>Fecha y hora Validacion:</td>
                                <td>{{$tarea->fecha_validacion ? $tarea->fecha_validacion->format('d-m-Y h:i A') : '' }}
                                </td>
                            </tr>
                        </tbody>



                    </table>
                    <!-- End -->
                </div>
            </div>
        </div>


    </header>

    <div class="cont-table">
        <table class="styled-table tabla1">
            <thead>
                <tr>
                    <td>
                        <div class="font-semibold text-center">#Tarea</div>

                    </td>
                    <td>
                        <div class="font-semibold text-center">Descripción</div>
                    </td>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-sm divide-y divide-slate-200">

                <tr>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap" style="max-width: 150px">

                        <div class="text-blue-700">
                            {{ $tarea->token }}
                        </div>
                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                        <div class="text-slate-800" style="max-width: 536px">

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
                        </div>

                    </td>


                </tr>

            </tbody>
        </table>

    </div>


    <div class="cont-table">
        <table class="styled-table tabla2">
            <thead>
                <tr>
                    <td>
                        <div class="font-semibold text-left"> Vehiculo</div>
                    </td>
                    <td>
                        <div class="font-semibold text-center">Estado</div>
                    </td>
                    <td>
                        <div class="font-semibold text-center">Fecha Termino</div>
                    </td>
                    <td>
                        <div class="font-semibold text-center"> Validacion Cliente</div>
                    </td>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-sm divide-y divide-slate-200">

                <tr>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800">

                            {{$tarea->vehiculo->placa}}
                        </div>
                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div
                            class="text-sm inline-flex font-medium bg-{{$tarea->estado->color()}}-100 text-{{$tarea->estado->color()}}-600 rounded-full text-center px-2.5 py-1">
                            {{$tarea->estado->name()}}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                        <div class=" text-slate-800">

                            {{$tarea->fecha_termino ? $tarea->fecha_termino->format('d-m-Y') : '-'}}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                        <div class="text-center">
                            @if ($tarea->respuesta)

                            <img src="{{asset('images/valid.png')}}" class="w-7" alt="">
                            @else
                            <img src="{{asset('images/invalid.png')}}" class="w-7" alt="">
                            @endif
                        </div>
                    </td>


                </tr>

            </tbody>
        </table>
    </div>

    <div class="page-break"></div>
    {!!$tarea->informe ? html_entity_decode($tarea->informe->message) : ''!!}

</body>


</html>
