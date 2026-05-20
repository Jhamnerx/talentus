<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket->code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 32px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .header {
            background: #4f46e5;
            padding: 24px 32px;
        }

        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 20px;
        }

        .header p {
            color: #c7d2fe;
            margin: 4px 0 0;
            font-size: 13px;
        }

        .body {
            padding: 32px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .meta-row {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13px;
            color: #374151;
        }

        .meta-label {
            color: #9ca3af;
            min-width: 110px;
        }

        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }

        .message-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 16px;
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .btn {
            display: inline-block;
            background: #4f46e5;
            color: #fff;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 20px;
        }

        .footer {
            background: #f9fafb;
            padding: 16px 32px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Ticket de soporte: {{ $ticket->code }}</h1>
            <p>{{ $ticket->subject }}</p>
        </div>

        <div class="body">
            <p style="font-size:15px;color:#111827;margin-bottom:20px;">
                Estimado/a <strong>{{ $ticket->customer->razon_social ?? 'cliente' }}</strong>,
            </p>

            <div class="meta-row">
                <span class="meta-label">Código:</span>
                <strong>{{ $ticket->code }}</strong>
            </div>
            <div class="meta-row">
                <span class="meta-label">Estado:</span>
                <span>{{ $ticket->status->label() }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Prioridad:</span>
                <span>{{ $ticket->priority->label() }}</span>
            </div>
            @if ($ticket->assignedTo)
                <div class="meta-row">
                    <span class="meta-label">Asignado a:</span>
                    <span>{{ $ticket->assignedTo->name }}</span>
                </div>
            @endif
            <div class="meta-row">
                <span class="meta-label">Última actividad:</span>
                <span>{{ $ticket->last_activity_at?->format('d/m/Y H:i') ?? 'N/A' }}</span>
            </div>

            <hr class="divider">

            <p
                style="font-size:13px;color:#6b7280;margin-bottom:8px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">
                @if ($eventType === 'created')
                    Descripción del ticket
                @else
                    Actualización
                @endif
            </p>
            <div class="message-box">{{ $messageBody }}</div>

            @if (config('app.url'))
                <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn">Ver ticket completo</a>
            @endif
        </div>

        <div class="footer">
            Este correo es generado automáticamente. Por favor no responda directamente a este mensaje.<br>
            Si tiene dudas, comuníquese con nuestro equipo de soporte.
        </div>
    </div>
</body>

</html>
