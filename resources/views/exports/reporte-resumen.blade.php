@php
    $titulo = match ($contexto) {
        'ventas' => 'RESUMEN DE VENTAS',
        'recibos' => 'RESUMEN DE RECIBOS',
        default => 'RESUMEN VENTAS & RECIBOS',
    };
    $r = $resumen;
    $destinos = array_filter($r['destinos'] ?? [], fn($k) => $k !== '', ARRAY_FILTER_USE_KEY);
    $metodos = array_filter($r['metodos'] ?? [], fn($k) => $k !== '', ARRAY_FILTER_USE_KEY);
@endphp

<table>
    <tbody>

        {{-- TITULO --}}
        <tr>
            <td colspan="6"
                style="background-color: #1E3A5F; color: #FFFFFF; font-weight: bold; font-size: 14pt; text-align: center;">
                {{ $titulo }}</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        {{-- FACTURADO / EMITIDO --}}
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">
                FACTURADO / EMITIDO (activos, excluye anulados y con NC)</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
        </tr>
        <tr>
            <td>Total emitido</td>
            <td>{{ number_format($r['facturado_pen'], 2) }}</td>
            <td>{{ number_format($r['facturado_usd'], 2) }}</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        {{-- COBRADO / PAGADO --}}
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">COBRADO / PAGADO</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
        </tr>
        <tr>
            <td>Total cobrado</td>
            <td>{{ number_format($r['cobrado_pen'], 2) }}</td>
            <td>{{ number_format($r['cobrado_usd'], 2) }}</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        {{-- Destinos de cobro --}}
        @if (!empty($destinos))
            <tr>
                <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">DETALLE POR DESTINO DE COBRO</td>
            </tr>
            <tr>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Destino</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            @foreach ($destinos as $destino => $montos)
                <tr>
                    <td>{{ $destino ?: '(sin destino)' }}</td>
                    <td>{{ number_format($montos['pen'], 2) }}</td>
                    <td>{{ number_format($montos['usd'], 2) }}</td>
                </tr>
            @endforeach
            <tr><td colspan="6">&nbsp;</td></tr>
        @endif

        {{-- Metodos de cobro --}}
        @if (!empty($metodos))
            <tr>
                <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">DETALLE POR METODO DE COBRO</td>
            </tr>
            <tr>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Metodo</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            @foreach ($metodos as $metodo => $montos)
                <tr>
                    <td>{{ $metodo ?: '(sin metodo)' }}</td>
                    <td>{{ number_format($montos['pen'], 2) }}</td>
                    <td>{{ number_format($montos['usd'], 2) }}</td>
                </tr>
            @endforeach
            <tr><td colspan="6">&nbsp;</td></tr>
        @endif
        <tr><td colspan="6">&nbsp;</td></tr>

        {{-- POR COBRAR / PENDIENTE --}}
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">POR COBRAR / PENDIENTE (credito sin pagar)</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <td>Total por cobrar</td>
            <td>{{ number_format($r['por_cobrar_pen'], 2) }}</td>
            <td>{{ number_format($r['por_cobrar_usd'], 2) }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Total vencido (con retraso)</td>
            <td>{{ number_format($r['vencido_pen'], 2) }}</td>
            <td>{{ number_format($r['vencido_usd'], 2) }}</td>
            <td colspan="3"></td>
        </tr>

        {{-- Listado de documentos a credito pendientes --}}
        @php $porCobrarDocs = $r['por_cobrar_docs'] ?? []; @endphp
        @if (!empty($porCobrarDocs))
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Documento</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Cliente</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Vencimiento</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Dias retraso</th>
            </tr>
            @foreach ($porCobrarDocs as $i => $doc)
                @php
                    $bg = $i % 2 === 0 ? '#FFFFFF' : '#EFF6FF';
                    $esVencido = ($doc['dias_retraso'] ?? 0) > 0;
                @endphp
                <tr style="background-color: {{ $esVencido ? '#FEE2E2' : $bg }};">
                    <td>{{ $doc['documento'] }}</td>
                    <td>{{ $doc['cliente'] }}</td>
                    <td>{{ $doc['total_pen'] > 0 ? number_format($doc['total_pen'], 2) : '' }}</td>
                    <td>{{ $doc['total_usd'] > 0 ? number_format($doc['total_usd'], 2) : '' }}</td>
                    <td>{{ $doc['vto'] ?? '' }}</td>
                    <td>{{ ($doc['dias_retraso'] ?? 0) > 0 ? $doc['dias_retraso'] . ' dias' : '' }}</td>
                </tr>
            @endforeach
        @endif
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        {{-- VENTAS ANULADAS --}}
        @if (($r['anuladas_count'] ?? 0) > 0)
            <tr>
                <td colspan="6" style="background-color: #991B1B; color: #FFFFFF; font-weight: bold;">VENTAS ANULADAS (no incluidas en el total)</td>
            </tr>
            <tr>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">Concepto</th>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <tr>
                <td>Total anulado ({{ $r['anuladas_count'] }} doc.)</td>
                <td>{{ number_format($r['anuladas_pen'], 2) }}</td>
                <td>{{ number_format($r['anuladas_usd'], 2) }}</td>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr><td colspan="6">&nbsp;</td></tr>
        @endif

        {{-- VENTAS CON NOTA DE CREDITO --}}
        @if (($r['nc_count'] ?? 0) > 0)
            <tr>
                <td colspan="6" style="background-color: #92400E; color: #FFFFFF; font-weight: bold;">VENTAS CON NOTA DE CREDITO (no incluidas en el total)</td>
            </tr>
            <tr>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">Concepto</th>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <tr>
                <td>Total con NC ({{ $r['nc_count'] }} doc.)</td>
                <td>{{ number_format($r['nc_pen'], 2) }}</td>
                <td>{{ number_format($r['nc_usd'], 2) }}</td>
            </tr>
        @endif

    </tbody>
</table>