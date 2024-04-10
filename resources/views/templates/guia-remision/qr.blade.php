@php

    $qrImage = base64_encode(
        QrCode::format('svg')
            ->size(120)
            ->gradient(10, 88, 147, 5, 44, 82, 'vertical')
            ->style('square')
            ->encoding('UTF-8')
            ->generate($qr),
    );

@endphp

<td width="15%" align="right">
    <img src="data:image/jpeg;base64, {{ $qrImage }}" alt="Qr Image">
</td>
