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
            <h2 class="font-semibold text-slate-800 ">REPORTE VEHICULOS:

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
                                        Resumen de Vehiculos
                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <td>Total Vehiculos</td>
                                <td>#{{$vehiculos->count()}}</td>
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
                    <div class="font-semibold text-center">#</div>

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Placa</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Marca</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Modelo</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Tipo</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Año</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3">
                    <div class="font-semibold text-left">Cliente</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">SIM#</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">Dispositivo#</div>
                </td>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200">

            <!-- Row -->
            @if ($vehiculos->count())
            @foreach ($vehiculos as $key => $vehiculo)
            <tr>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-blue-500">{{ $vehiculo->placa }}</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-slate-800">{{ $vehiculo->marca }}</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-slate-800">{{ $vehiculo->modelo }}</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-slate-800">{{ $vehiculo->tipo }}</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-slate-800">{{ $vehiculo->year }}</div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3">
                    <div class="font-medium text-sky-500">
                        @if ($vehiculo->cliente)
                        {{ $vehiculo->cliente->razon_social }}
                        @else
                        Sin Cliente Registrado
                        @endif

                    </div>
                    @if ($vehiculo->cliente)
                    <div class="font-sm text-slate-900">
                        <p class="text-xs">
                            {{ $vehiculo->cliente->numero_documento }}
                        </p>

                    </div>
                    @endif

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    @if ($vehiculo->sim_card)
                    @if ($vehiculo->sim_card->linea)
                    <div class="font-medium text-emerald-600">
                        #{{ $vehiculo->sim_card->linea->numero }}
                    </div>
                    @else
                    <div class="font-medium text-red-200">
                        {{ $vehiculo->sim_card->sim_card }}
                    </div>
                    @endif
                    @else
                    <div class="font-medium text-red-300">
                        {{ $vehiculo->old_sim_card }}
                    </div>
                    @endif

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-medium text-slate-800">
                        @if ($vehiculo->dispositivos)
                        {{ $vehiculo->dispositivos->modelo->modelo . ' | ' . $vehiculo->dispositivos->imei
                        }}
                        @else
                        {{ $vehiculo->dispositivo_imei }}
                        @endif

                    </div>
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
