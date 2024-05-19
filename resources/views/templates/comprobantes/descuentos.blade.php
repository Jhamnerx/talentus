<tr>
    <td align="right"><strong>
            Descuento:
        </strong></td>
    <td width="120" align="right">
        <span>{{ $venta->divisa == 'PEN' ? 'S/ ' : '$' }}
            {{ $venta->descuento }}
        </span>
    </td>
</tr>
