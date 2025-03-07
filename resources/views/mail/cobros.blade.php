<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Notificación de Detalles de Cobro</title>

    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
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

        .section ul {
            padding: 0;
            list-style: none;
        }

        .section ul li {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        .button {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #052c52;
            color: #ffffff;
            padding: 10px;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>{{ $mensaje['asunto'] }}</h2>
        <p>{{ $mensaje['body'] }}</p>

        @foreach ($mensaje['detalles'] as $estado => $vehiculos)
            <div class="section">
                <h3>{{ $estado }}</h3>
                <ul>
                    @foreach ($vehiculos as $detalle)
                        <li><strong>Placa:</strong> {{ $detalle['placa'] }} | <strong>Fecha de vencimiento:</strong>
                            {{ $detalle['fecha_vencimiento']->format('d-m-Y') }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <a href="{{ config('app.url') . '/admin/cobros/' . $mensaje['id_cobro'] }}" class="button">Ver detalles</a>

        <div class="footer">
            <p>Esta es una notificación automática. Por favor, no respondas a este correo.</p>
        </div>
    </div>
</body>

</html>
