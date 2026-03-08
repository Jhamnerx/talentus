<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?></title>
    <style>
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
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
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
        }

        .info-section h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
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
            padding: 5px 10px 5px 0;
            font-weight: bold;
            width: 30%;
            color: #6b7280;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .timeline {
            margin: 20px 0;
        }

        .timeline-item {
            padding: 10px;
            margin-bottom: 10px;
            border-left: 3px solid #2563eb;
            background: #f9fafb;
        }

        .timeline-item .title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .timeline-item .date {
            color: #6b7280;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }

        .signature-box {
            border: 1px solid #d1d5db;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
        }

        @page {
            size: A4;
            margin-top: 15mm;
            margin-bottom: 5mm;
            margin-left: 0;
            margin-right: 0;
            padding: 0;
        }

        body {
            position: relative;
        }

        #wo-overlay {
            position: absolute;
            top: -15mm;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
        }

        #wo-content {
            padding: 5.5cm 1cm 1cm 1cm;
        }
    </style>
</head>

<?php
    $woBgPath = storage_path('app/public/workOrder_bg.png');
    $woBg = file_exists($woBgPath) ? base64_encode(file_get_contents($woBgPath)) : null;
?>

<body>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($woBg): ?>
        <div id="wo-overlay">
            <img src="data:image/png;base64,<?php echo e($woBg); ?>" style="width:100%; height:100%; display:block;" />
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div
        style="position: absolute; top: 1rem; right: 8rem; color: #fff; font-weight: bold; font-size: 26px; font-family: Arial, sans-serif; z-index: 10;">
        WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?>

    </div>

    <div id="wo-content">

        <!-- Header título -->
        <div style="border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; margin-bottom: 20px; text-align: center;">
            <h1
                style="margin: 0 0 8px 0; color: #000000; font-size: 22px; font-weight: bold; font-family: 'Arial', sans-serif;">
                ORDEN DE TRABAJO</h1>
            <div>
                <span class="badge badge-<?php echo e(strtolower($workOrder->estado->value)); ?>">
                    <?php echo e($workOrder->estado->label()); ?>

                </span>
            </div>
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
            </div>
        </div>

        <!-- Mantenimiento Programado Vinculado -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->mantenimiento): ?>
            <?php $mt = $workOrder->mantenimiento; ?>
            <div class="info-section" style="border-left: 4px solid #2563eb; background: #f0f4ff;">
                <h2 style="color: #1e3a8a;">Mantenimiento Programado Vinculado</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">N° Mantenimiento:</div>
                        <div class="info-value" style="font-weight: bold; font-family: monospace; font-size: 13px;">
                            <?php echo e($mt->numero); ?></div>
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
                            <div class="info-value" style="font-style: italic; color: #374151;"><?php echo e($mt->nota); ?>

                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Timeline -->
        <div class="info-section">
            <h2>Timeline de Progreso</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="title">Orden Creada</div>
                    <div class="date"><?php echo e($workOrder->created_at->format('d/m/Y H:i')); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_inicio): ?>
                        <div class="timeline-item">
                            <div class="title">Trabajo Iniciado</div>
                            <div class="date"><?php echo e($workOrder->fecha_inicio->format('d/m/Y H:i')); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_finalizacion): ?>
                        <div class="timeline-item">
                            <div class="title">Trabajo Finalizado</div>
                            <div class="date"><?php echo e($workOrder->fecha_finalizacion->format('d/m/Y H:i')); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_cerrado): ?>
                        <div class="timeline-item">
                            <div class="title">Orden Cerrada y Bloqueada</div>
                            <div class="date"><?php echo e($workOrder->fecha_cerrado->format('d/m/Y H:i')); ?></div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->estado === \App\Enums\WorkOrderStatus::CANCELADO): ?>
                        <div class="timeline-item" style="border-left-color: #dc2626;">
                            <div class="title">Orden Cancelada</div>
                            <div class="date"><?php echo e($workOrder->updated_at->format('d/m/Y H:i')); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->motivo_cancelacion): ?>
                                <div style="margin-top: 5px;">Motivo: <?php echo e($workOrder->motivo_cancelacion); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Checklist -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->checklists->count() > 0): ?>
                <div class="info-section">
                    <h2>Checklist de Inspección</h2>

                    <?php
                        $checklistBefore = $workOrder->checklists->where('fase', 'before');
                        $checklistAfter = $workOrder->checklists->where('fase', 'after');
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checklistBefore->count() > 0): ?>
                        <h3 style="margin-top: 15px; font-size: 14px; color: #2563eb;">Antes del Trabajo</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Categoría / Ítem</th>
                                    <th style="width: 15%; text-align: center;">Resultado</th>
                                    <th style="width: 50%;">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $checklistBefore->groupBy('template.categoria'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr style="background: #f9fafb;">
                                        <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 6px 8px;">
                                            <?php echo e(strtoupper($categoria)); ?>

                                        </td>
                                    </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <tr>
                                            <td style="padding-left: 20px;"><?php echo e($item->template->nombre); ?></td>
                                            <td style="text-align: center;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->resultado->value === 'ok'): ?>
                                                    <span
                                                        style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">OK</span>
                                                <?php elseif($item->resultado->value === 'observado'): ?>
                                                    <span
                                                        style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">OBSERVADO</span>
                                                <?php else: ?>
                                                    <span
                                                        style="background: #e5e7eb; color: #6b7280; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">N/A</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td style="font-size: 11px;"><?php echo e($item->observaciones ?? '-'); ?></td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checklistAfter->count() > 0): ?>
                        <h3 style="margin-top: 20px; font-size: 14px; color: #10b981;">Después del Trabajo</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Categoría / Ítem</th>
                                    <th style="width: 15%; text-align: center;">Resultado</th>
                                    <th style="width: 50%;">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $checklistAfter->groupBy('template.categoria'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr style="background: #f9fafb;">
                                        <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 6px 8px;">
                                            <?php echo e(strtoupper($categoria)); ?>

                                        </td>
                                    </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <tr>
                                            <td style="padding-left: 20px;"><?php echo e($item->template->nombre); ?></td>
                                            <td style="text-align: center;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->resultado->value === 'ok'): ?>
                                                    <span
                                                        style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">OK</span>
                                                <?php elseif($item->resultado->value === 'observado'): ?>
                                                    <span
                                                        style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">OBSERVADO</span>
                                                <?php else: ?>
                                                    <span
                                                        style="background: #e5e7eb; color: #6b7280; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">N/A</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td style="font-size: 11px;"><?php echo e($item->observaciones ?? '-'); ?></td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Dispositivos -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->deviceHistory->count() > 0): ?>
                <div class="info-section">
                    <h2>Historial de Dispositivos</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Identificador</th>
                                <th>Acción</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->deviceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_imei !== 'ninguna'): ?>
                                    <tr>
                                        <td>IMEI</td>
                                        <td><?php echo e($history->imei); ?></td>
                                        <td><?php echo e(ucfirst($history->accion_imei)); ?></td>
                                        <td><?php echo e(optional($history->fecha_instalacion)->format('d/m/Y H:i')); ?></td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_sim !== 'ninguna'): ?>
                                    <tr>
                                        <td>SIM</td>
                                        <td><?php echo e($history->numero_linea); ?></td>
                                        <td><?php echo e(ucfirst($history->accion_sim)); ?></td>
                                        <td><?php echo e(optional($history->fecha_instalacion)->format('d/m/Y H:i')); ?></td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Accesorios -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->accessories->count() > 0): ?>
                <div class="info-section">
                    <h2>Accesorios Instalados/Retirados</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Acción</th>
                                <th>P. Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr>
                                    <td><?php echo e($accessory->nombre); ?></td>
                                    <td><?php echo e($accessory->cantidad); ?></td>
                                    <td><?php echo e(ucfirst($accessory->accion)); ?></td>
                                    <td>S/ <?php echo e(number_format($accessory->precio_unitario, 2)); ?></td>
                                    <td>S/ <?php echo e(number_format($accessory->subtotal, 2)); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr style="font-weight: bold;">
                                <td colspan="4" style="text-align: right;">TOTAL:</td>
                                <td>S/ <?php echo e(number_format($workOrder->accessories->sum('subtotal'), 2)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Observaciones -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_inicial || $workOrder->observaciones_tecnico || $workOrder->observaciones_final): ?>
                <div class="info-section">
                    <h2>Observaciones</h2>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_inicial): ?>
                        <div style="margin-bottom: 10px;">
                            <strong>Observaciones Iniciales:</strong><br>
                            <?php echo e($workOrder->observaciones_inicial); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_tecnico): ?>
                        <div style="margin-bottom: 10px;">
                            <strong>Observaciones del Técnico:</strong><br>
                            <?php echo e($workOrder->observaciones_tecnico); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_final): ?>
                        <div style="margin-bottom: 10px;">
                            <strong>Observaciones Finales:</strong><br>
                            <?php echo e($workOrder->observaciones_final); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Firmas -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->signatures->count() > 0): ?>
                <div class="info-section" style="page-break-inside: avoid;">
                    <h2>Firmas Digitales</h2>

                    <table>
                        <thead>
                            <tr>
                                <th style="width: 15%;">Tipo</th>
                                <th style="width: 25%;">Firmante</th>
                                <th style="width: 15%;">Documento</th>
                                <th style="width: 20%;">Fecha</th>
                                <th style="width: 25%; text-align: center;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->signatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo e(ucfirst($signature->tipo)); ?></td>
                                    <td><?php echo e($signature->nombre_firmante); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($signature->tipo_firmante): ?>
                                            <br><span
                                                style="font-size: 10px; color: #6b7280;">(<?php echo e(ucfirst($signature->tipo_firmante)); ?>)</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td><?php echo e($signature->documento_firmante ?? '-'); ?></td>
                                    <td><?php echo e($signature->firmado_at->format('d/m/Y H:i')); ?></td>
                                    <td style="text-align: center;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($signature->verificarIntegridad()): ?>
                                            <span
                                                style="background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold;">VERIFICADA</span>
                                        <?php else: ?>
                                            <span
                                                style="background: #fee2e2; color: #991b1b; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold;">COMPROMETIDA</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Mostrar imágenes de firmas -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->signatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $signaturePath = storage_path('app/private/' . $signature->path);
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists($signaturePath)): ?>
                            <div class="signature-box" style="margin-top: 20px; page-break-inside: avoid;">
                                <h3 style="margin: 0 0 10px 0; font-size: 12px;">Firma de
                                    <?php echo e(ucfirst($signature->tipo)); ?>

                                    -
                                    <?php echo e($signature->nombre_firmante); ?></h3>
                                <div style="border: 1px solid #d1d5db; padding: 10px; background: #fff;">
                                    <img src="<?php echo e($signaturePath); ?>" alt="Firma"
                                        style="max-width: 300px; max-height: 150px; display: block; margin: 0 auto;">
                                </div>
                                <div style="margin-top: 10px; font-size: 10px; color: #6b7280;">
                                    <strong>IP:</strong> <?php echo e($signature->ip_address); ?> |
                                    <strong>Hash:</strong> <?php echo e(substr($signature->hash, 0, 16)); ?>...
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Footer -->
            <div class="footer">
                <p>Este documento fue generado automáticamente el <?php echo e(now()->format('d/m/Y H:i')); ?></p>
                <p><?php echo e(config('app.name')); ?> - Sistema de Gestión de Órdenes de Trabajo</p>
            </div>

        </div><!-- Cierre del div wo-content -->

</body>

</html>
<?php /**PATH C:\laragon2\www\talentus\resources\views/pdf/workOrder/informe.blade.php ENDPATH**/ ?>