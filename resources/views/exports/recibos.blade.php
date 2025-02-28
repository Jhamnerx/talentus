<html>
<table id="recibos">
    <!-- Table header -->
    <thead>
        <tr>
            <th>
                #Recibo
            </th>
            <th>
                Cliente
            </th>
            <th>
                Total
            </th>
            <th>
                Estado
            </th>

            <th>
                Emitido el
            </th>
            <th>
                Registrado por
            </th>
            <th>
                Fecha de pago
            </th>
            <th>
                Tipo de Pago
            </th>
        </tr>
    </thead>
    <!-- Table body -->
    <tbody class="text-sm divide-y divide-slate-200">

        <!-- Row -->
        @if ($recibos->count())
            @foreach ($recibos as $recibo)
                <tr>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        @if ($recibo->estado == 'BORRADOR')
                            <div class="font-medium text-red-500">

                                #{{ $recibo->serie_numero }}

                            </div>
                        @else
                            <div class="font-medium text-sky-600">

                                #{{ $recibo->serie_numero }}

                            </div>
                        @endif


                    </td>

                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-slate-800">{{ $recibo->clientes->razon_social }}
                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div class="font-medium text-emerald-500">
                            @if ($recibo->divisa == 'PEN')
                                S/. {{ $recibo->total }}
                            @else
                                ${{ $recibo->total }}
                            @endif

                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        @switch($recibo->pago_estado)
                            @case('UNPAID')
                                <div
                                    class="inline-flex font-medium bg-orange-100 text-orange-600 rounded-full text-center px-2.5 py-0.5">
                                    Por Pagar</div>
                            @break

                            @case('PAID')
                                <div
                                    class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                    Pagado</div>
                            @break
                        @endswitch


                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>{{ $recibo->fecha_emision->format('d-m-Y') }}</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>{{ $recibo->user->name }}</div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>
                            @if ($recibo->fecha_pago)
                                {{ $recibo->fecha_pago->format('d-m-Y') }}
                            @endif

                        </div>
                    </td>
                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                        <div>{{ $recibo->tipo_venta }}</div>
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                <div class="text-center">No hay Registros</div>
            </td>
        @endif
    </tbody>

    <!-- Table footer -->
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">Total en USD:</td>
            <td>{{ number_format($total_dolares, 2) }}</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">Total en Soles:</td>
            <td>{{ number_format($total_soles, 2) }}</td>
            <td colspan="5"></td>
        </tr>
    </tfoot>
</table>

</html>
