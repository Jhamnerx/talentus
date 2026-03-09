<table>
    <thead>
        <tr>
            @foreach ($headings as $heading)
                <th
                    style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold; white-space: nowrap; padding: 4px 8px;">
                    {{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            @php
                $obs = $row['observacion'] ?? '';
                if ($obs === 'ANULADA') {
                    $bg = '#FEE2E2'; // rojo claro
                } elseif ($obs === 'CON NOTA CREDITO') {
                    $bg = '#FEF3C7'; // amarillo claro
                } elseif ($loop->index % 2 !== 0) {
                    $bg = '#EFF6FF'; // azul muy claro (zebra)
                } else {
                    $bg = '#FFFFFF';
                }
            @endphp
            <tr style="background-color: {{ $bg }};">
                @foreach ($row['cells'] as $cell)
                    <td style="padding: 3px 6px;">{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
