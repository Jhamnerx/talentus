<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Notificación Consolidada de Cobros</title>

    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #052c52;
            text-align: center;
        }

        .section {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #052c52;
            border-radius: 4px;
        }

        .section h3 {
            margin: 0;
            padding-bottom: 5px;
            color: #052c52;
        }

        .section table {
            width: 100%;
            border-collapse: collapse;
        }

        .section table th {
            background-color: #e9ecef;
            text-align: left;
            padding: 8px;
            font-weight: bold;
            color: #052c52;
        }

        .section table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .button {
            display: inline-block;
            width: auto;
            text-align: center;
            background-color: #052c52;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        .stats {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #052c52;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>{{ $mensaje['asunto'] }}</h2>
        <p>{{ $mensaje['body'] }}</p>

        <div class="stats">
            <p>Resumen de vehículos con cobros por vencer:</p>
            @php
                $totalVehiculos = 0;
                foreach ($mensaje['detalles'] as $estado => $vehiculos) {
                    $totalVehiculos += count($vehiculos);
                }
            @endphp
            <p>Total de vehículos: {{ $totalVehiculos }}</p>
        </div>

        @foreach ($mensaje['detalles'] as $estado => $vehiculos)
            <div class="section">
                <h3>{{ $estado }}</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Cobro #</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $detalle)
                            <tr>
                                <td>{{ $detalle['placa'] }}</td>
                                <td>{{ $detalle['fecha_vencimiento']->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ config('app.url') . '/admin/cobros/' . $detalle['cobro_id'] }}">
                                        {{ $detalle['cobro_id'] }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ config('app.url') . '/admin/cobros' }}" class="button">Ver todos los cobros</a>
        </div>

        <div class="footer">
            <p>Esta es una notificación automática consolidada de todos los cobros próximos a vencer.</p>
            <p>Por favor, no respondas a este correo.</p>
            <p>Fecha de envío: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>

</html>
