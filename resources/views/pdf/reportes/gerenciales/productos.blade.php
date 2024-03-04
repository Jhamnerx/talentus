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
    </style>




</head>

<body>


    <header class="px-5 py-4 flex">

        <div class="flex-auto">
            <h2 class="font-semibold text-slate-800 ">REPORTE PRODUCTOS:

            </h2>

        </div>


    </header>

    <table class="styled-table">
        <thead>
            <tr>
                <td>
                    <div class="font-semibold text-center">CODIGO</div>

                </td>
                <td>
                    <div class="font-semibold text-center">DESCRIPCION</div>
                </td>
                <td>
                    <div class="font-semibold text-left"> VALOR UNITARIO</div>
                </td>
                <td>
                    <div class="font-semibold text-center">STOCK</div>
                </td>
                <td>
                    <div class="font-semibold text-center">VENTAS</div>
                </td>
            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-sm divide-y divide-slate-200">

            <!-- Row -->
            @if ($productos->count())
                @foreach ($productos as $producto)
                    <tr>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="text-blue-700">
                                {{ $producto->codigo }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                            <div class="text-slate-800" style="max-width: 720px">

                                {{ $producto->descripcion }}
                            </div>

                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">

                                {{ $producto->valor_unitario }}
                            </div>
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                {{ $producto->stock }}
                            </div>

                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center text-slate-800">
                                Comprobantes: {{ $producto->detalle_facturas->count() }}
                                <br>
                                Recibos {{ $producto->detalle_recibos->count() }}
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
