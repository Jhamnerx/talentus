{{-- <html>
{{-- {{ HTML::style('stilos.css')
<table class="blueTable">
    <thead>
        <tr>
            <th>head1</th>
            <th>head2</th>
            <th>head3</th>
            <th>head4</th>
            <th>head5</th>
            <th>head6</th>
            <th>head7</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>cell1_1</td>
            <td>cell2_1</td>
            <td>cell3_1</td>
            <td>cell4_1</td>
            <td>cell5_1</td>
            <td>cell6_1</td>
            <td>cell7_1</td>
        </tr>
    </tbody>

</table>

</html> --}}

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
                    <a href="{{ route('admin.ventas.recibos.show', $recibo) }}">
                        #{{ $recibo->serie_numero }}
                    </a>
                </div>
                @else
                <div class="font-medium text-sky-600">
                    <a href="{{ route('admin.ventas.recibos.show', $recibo) }}">
                        #{{ $recibo->serie_numero }}
                    </a>
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
</table>

</html>
