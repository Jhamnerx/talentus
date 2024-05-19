@foreach ($venta->anticipos as $anticipo)
    <tr class="border_top">
        <td align="center">
            1
            UNIDAD
        </td>
        <td align="center">

        </td>
        <td align="center" width="300px">
            <span>{{ $anticipo->descripcion }}</span><br>
        </td>
        <td align="center">
            {{ $venta->divisa == 'PEN' ? 'S/ ' : '$' }}
            -{{ round($anticipo->valor_venta_ref, 2) }}

        </td>
        <td align="center">
            {{ $venta->divisa == 'PEN' ? 'S/ ' : '$' }}
            -{{ round($anticipo->valor_venta_ref, 2) }}
        </td>
    </tr>
@endforeach
