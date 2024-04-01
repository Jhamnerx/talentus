<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
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

        .border-separate {
            border-collapse: separate;
        }

        .border {
            border-width: 1px;
        }

        .border-slate-400 {
            --tw-border-opacity: 1;
            border-color: rgb(148 163 184 / var(--tw-border-opacity));
        }

        .border-slate-800 {
            --tw-border-opacity: 1;
            border-color: rgb(30 41 59 / var(--tw-border-opacity));
        }
    </style>




</head>

<body>


    <header class="px-5 py-4 flex">

        <div class="flex-auto">
            <h2 class="font-semibold text-slate-800 ">REPORTE TAREAS:

            </h2>

        </div>


        <div class="flex flex-auto">
            <div>
                <img src="{{ public_path('/images/logo-excel.png') }}" height="100" alt="">
            </div>
            <div class="relative">
                <div class="m-1.5">
                    <!-- Start -->
                    <table class="detalle border-separate border  border-slate-800">
                        <tbody class="text-sm divide-y divide-slate-200">
                            <tr>
                                <td colspan="2" class="border border-slate-800">
                                    <div class="text-center">
                                        {{ $tecnico->name }}
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td class="border">Fecha Inicial</td>
                                <td class="border">{{ $fechas['fecha_inicial'] }}</td>
                            </tr>
                            <tr>
                                <td class="border">Fecha Final</td>
                                <td class="border">{{ $fechas['fecha_final'] }}</td>
                            </tr>

                            <tr>
                                <td class="border">Total:</td>
                                <td class="border">S/. {{ number_format($total_costo, 2) }}</td>
                            </tr>
                        </tbody>



                    </table>
                    <!-- End -->
                </div>
            </div>
        </div>


    </header>

    <table class="styled-table">
        <thead>
            <tr>
                <td>
                    <div class="font-semibold text-center">#Tarea</div>

                </td>
                <td>
                    <div class="font-semibold text-center">Descripción</div>
                </td>
                <td>
                    <div class="font-semibold text-left"> Empresa</div>
                </td>
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
                    <div class="font-semibold text-center"> Costo</div>
                </td>
                <td>
                    <div class="font-semibold text-center"> Validacion Cliente</div>
                </td>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200">

            <!-- Row -->
            @if ($tareas->count())
                @foreach ($tareas as $tarea)
                    <tr>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="text-blue-700">
                                {{ $tarea->token }}
                            </div>
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="text-slate-800" style="max-width: 560px">
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

                            </div>

                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="text-slate-800">

                                {{ $tarea->vehiculo->cliente ? $tarea->vehiculo->cliente->razon_social : 'CLIENTE NO ENCONTRADO' }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">

                                {{ $tarea->vehiculo->placa }}
                            </div>
                        </td>


                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div
                                class="text-sm inline-flex font-medium bg-{{ $tarea->estado->color() }}-100 text-{{ $tarea->estado->color() }}-600 rounded-full text-center px-2.5 py-1">
                                {{ $tarea->estado->name() }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                            <div class=" text-slate-800">

                                {{ $tarea->fecha_termino ? $tarea->fecha_termino->format('d-m-Y') : '-' }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                {{ $tarea->tipo_tarea->costo }}
                            </div>


                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="text-center">
                                @if ($tarea->respuesta)
                                    <img src="{{ public_path('images/valid.png') }}" class="w-7" alt="">
                                @else
                                    <img src="{{ public_path('images/invalid.png') }}" class="w-7" alt="">
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
</body>


</html>
