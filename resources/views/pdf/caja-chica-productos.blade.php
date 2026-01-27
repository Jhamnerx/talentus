<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Productos - {{ $caja->nombre }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{ header('Content-type:application/pdf') }}
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #10B981;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #10B981;
            margin: 0;
            font-size: 24px;
        }

        .info-box {
            background: #F3F4F6;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #10B981;
            color: white;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #D1D5DB;
        }

        table tbody tr:nth-child(even) {
            background: #F9FAFB;
        }

        .text-right {
            text-align: right;
        }

        .totales {
            background: #D1FAE5;
            border: 2px solid #10B981;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            text-align: right;
        }

        .totales strong {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📦 Reporte de Productos Vendidos</h1>
        <p><strong>{{ $caja->nombre }}</strong></p>
    </div>

    <div class="info-box">
        <p><strong>Usuario:</strong> {{ $caja->user->name }}</p>
        <p><strong>Fecha:</strong> {{ $caja->fecha_apertura->format('d/m/Y') }}</p>
        <p><strong>Moneda:</strong> {{ $caja->moneda }}</p>
    </div>

    <h2 style="color: #10B981; margin-top: 30px; margin-bottom: 15px;">Productos Vendidos</h2>

    @if ($productos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Documento</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">P. Unitario</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $index => $producto)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $producto['documento'] }}</td>
                        <td class="text-right">{{ number_format($producto['cantidad'], 2) }}</td>
                        <td class="text-right">{{ $caja->moneda }} {{ number_format($producto['precio'], 2) }}</td>
                        <td class="text-right">{{ $caja->moneda }} {{ number_format($producto['total'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totales">
            <strong>TOTAL:</strong> {{ $caja->moneda }} {{ number_format($total_productos, 2) }}
        </div>
    @else
        <p style="text-align: center; color: #6B7280; padding: 30px;">
            No se vendieron productos en esta caja
        </p>
    @endif

    <div
        style="margin-top: 30px; text-align: center; color: #6B7280; font-size: 10px; border-top: 1px solid #E5E7EB; padding-top: 15px;">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestión - Talentus</p>
    </div>
</body>

</html>
