<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden de Trabajo WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?></title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 10px;
        }

        .badge-pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-proceso {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-finalizado {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-cancelado {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-section {
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 12px 15px;
        }

        .info-section h2 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 4px 10px 4px 0;
            font-weight: bold;
            width: 32%;
            color: #6b7280;
            font-size: 11px;
        }

        .info-value {
            display: table-cell;
            padding: 4px 0;
            font-size: 11px;
        }

        #wo-content {
            padding: 4.5cm 1cm 1cm 1cm;
        }
    </style>
</head>

<?php
    $woBgPath = storage_path('app/public/workOrder_bg.png');
    $woBg = file_exists($woBgPath) ? base64_encode(file_get_contents($woBgPath)) : null;
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($woBg): ?>

    <body
        style="background-image: url('data:image/png;base64,<?php echo e($woBg); ?>'); background-size: 100% 100%; background-repeat: no-repeat; background-position: top left;">
    <?php else: ?>

        <body>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($woBg): ?>
    <div
        style="position: absolute; top: 1.2rem; right: 4.5rem; color: #fff; font-weight: bold; font-size: 22px; font-family: Arial, sans-serif;">
        WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?>

    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div id="wo-content">

    <!-- Título -->
    <div style="border-bottom: 2px solid #1e3a5f; padding-bottom: 8px; margin-bottom: 16px; text-align: center;">
        <h1 style="margin: 0 0 6px 0; color: #000; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">
            ORDEN DE TRABAJO
        </h1>
        <span class="badge badge-<?php echo e(strtolower($workOrder->estado->value)); ?>">
            <?php echo e($workOrder->estado->label()); ?>

        </span>
    </div>

    <!-- Información General -->
    <div class="info-section">
        <h2>Información General</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Tipo de Orden:</div>
                <div class="info-value"><?php echo e($workOrder->tipo_data['nombre'] ?? $workOrder->tipo->nombre); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Vehículo:</div>
                <div class="info-value"><?php echo e($workOrder->vehiculo->placa); ?> - <?php echo e($workOrder->vehiculo->marca); ?>

                    <?php echo e($workOrder->vehiculo->modelo); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value"><?php echo e($workOrder->cliente->razon_social); ?> -
                    <?php echo e($workOrder->cliente->numero_documento); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Técnico Asignado:</div>
                <div class="info-value"><?php echo e($workOrder->tecnico->name); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha Programada:</div>
                <div class="info-value"><?php echo e($workOrder->fecha_programada->format('d/m/Y H:i')); ?></div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_inicio): ?>
                <div class="info-row">
                    <div class="info-label">Fecha Inicio:</div>
                    <div class="info-value"><?php echo e($workOrder->fecha_inicio->format('d/m/Y H:i')); ?></div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_finalizacion): ?>
                <div class="info-row">
                    <div class="info-label">Fecha Finalización:</div>
                    <div class="info-value"><?php echo e($workOrder->fecha_finalizacion->format('d/m/Y H:i')); ?></div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Mantenimiento Vinculado -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->mantenimiento): ?>
        <?php $mt = $workOrder->mantenimiento; ?>
        <div class="info-section" style="border-left: 4px solid #2563eb; background: #f0f4ff;">
            <h2 style="color: #1e3a8a;">Mantenimiento Programado Vinculado</h2>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">N° Mantenimiento:</div>
                    <div class="info-value" style="font-weight: bold; font-family: monospace;"><?php echo e($mt->numero); ?>

                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha Programada:</div>
                    <div class="info-value">
                        <?php echo e($mt->fecha_hora_mantenimiento ? $mt->fecha_hora_mantenimiento->format('d/m/Y') : 'No definida'); ?>

                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">
                        <span
                            style="padding: 2px 10px; border-radius: 10px; font-size: 10px; font-weight: bold;
                            background: <?php echo e($mt->estado->value === 'PENDIENTE' ? '#fef3c7' : ($mt->estado->value === 'COMPLETADA' ? '#d1fae5' : '#fee2e2')); ?>;
                            color: <?php echo e($mt->estado->value === 'PENDIENTE' ? '#92400e' : ($mt->estado->value === 'COMPLETADA' ? '#065f46' : '#991b1b')); ?>;">
                            <?php echo e($mt->estado->value); ?>

                        </span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mt->nota): ?>
                    <div class="info-row">
                        <div class="info-label">Nota:</div>
                        <div class="info-value" style="font-style: italic;"><?php echo e($mt->nota); ?></div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Observaciones Iniciales -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones): ?>
        <div class="info-section">
            <h2>Observaciones</h2>
            <p style="margin: 0; font-size: 11px;"><?php echo e($workOrder->observaciones); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Footer portada -->
    <div
        style="margin-top: 20px; text-align: center; color: #9ca3af; font-size: 9px; border-top: 1px solid #e5e7eb; padding-top: 8px;">
        Generado el <?php echo e(now()->format('d/m/Y H:i')); ?> · <?php echo e(config('app.name')); ?>

    </div>

</div><!-- fin wo-content -->
</body>

</html>
<?php /**PATH C:\laragon2\www\talentus\resources\views/pdf/workOrder/informe.blade.php ENDPATH**/ ?>