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

        .items-center {
            align-items: center;
        }

        .text-emerald-500 {
            --tw-text-opacity: 1;
            color: rgb(16 185 129 / var(--tw-text-opacity));
        }
    </style>




</head>

<body>


    <header class="px-5 py-4 flex">

        <div class="flex-auto">
            <h2 class="font-semibold text-slate-800 ">REPORTE LINEAS:

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
                                        Resumen de operadores
                                    </div>

                                </td>
                            </tr>
                            @foreach ($operadores as $operador)
                            <tr>
                                <td>{{$operador->operador}}</td>
                                <td>#{{$operador->count_row}}</td>
                            </tr>
                            @endforeach

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
                    <div class="font-semibold text-center">NUMERO</div>

                </td>
                <td>
                    <div class="font-semibold text-center">OPERADOR</div>
                </td>
                <td>
                    <div class="font-semibold text-center"> SIM CARD</div>
                </td>
                <td>
                    <div class="font-semibold text-center">EMPRESA ACTUAL</div>
                </td>
                <td>
                    <div class="font-semibold text-center">PLACA</div>
                </td>
                <td>
                    <div class="font-semibold text-center">ESTADO</div>
                </td>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200">

            <!-- Row -->
            @if ($lineas->count())
            @foreach ($lineas as $linea)
            <tr>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        @if (!empty($linea->numero))
                        <div class="font-medium text-slate-800">#{{ $linea->numero }}</div>
                        @else
                        <div class="font-medium text-slate-800"></div>
                        @endif
                    </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="text-center">{{ $linea->operador }}</div>

                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    @if (!empty($linea->sim_card))
                    <div class="text-center font-medium text-slate-800">
                        {{ $linea->sim_card->sim_card }}</div>
                    @else
                    <div class="text-center font-medium text-red-300">SIN ASIGNAR</div>
                    @endif


                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="text-center font-medium text-slate-800">

                    </div>
                    @if (!empty($linea->sim_card))
                    <div class="text-center font-medium text-slate-800">
                        @if (!empty($linea->sim_card->vehiculos))
                        {{ $linea->sim_card->vehiculos->cliente->razon_social }}
                        @endif
                    </div>
                    @else
                    <div class="text-center font-medium text-red-300"></div>
                    @endif


                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="text-center font-medium text-slate-800">

                    </div>
                    @if (!empty($linea->sim_card))
                    <div class="text-center font-medium text-slate-800">
                        @if (!empty($linea->sim_card->vehiculos))
                        {{ $linea->sim_card->vehiculos->placa }}
                        @endif
                    </div>
                    @else
                    <div class="text-center font-medium text-red-300"></div>
                    @endif


                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    @if ($linea->estado->name == 'SUSPENDIDA')
                    <div class="font-medium text-red-500">
                        @php
                        $dias = $linea->now->diffInDays($linea->date_to_suspend);
                        @endphp

                        Suspendido <br>

                        @if ($dias > 0)
                        {{ $dias }} Dias Restantes
                        @else
                        -
                        @endif

                    </div>
                    @else
                    <div class="font-medium text-emerald-500 text-center">
                        {{ $linea->estado->name }}
                    </div>
                    @endif
                </td>

            </tr>
            @endforeach
            @else
            <td colspan="4" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                <div class="text-center">No hay Registros</div>
            </td>
            @endif


        </tbody>
    </table>
</body>


</html>
