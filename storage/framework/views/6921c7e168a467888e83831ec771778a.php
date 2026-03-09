<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?></title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 10mm 10mm 12mm 10mm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .info-section {
            margin-bottom: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 10px 14px;
        }

        .info-section h2 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }

        .section-header {
            background: #1e3a5f;
            color: #fff;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 3px;
        }

        /* Timeline */
        .timeline-item {
            padding: 7px 10px;
            margin-bottom: 7px;
            border-left: 3px solid #2563eb;
            background: #f9fafb;
        }

        .timeline-item .tl-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .timeline-item .tl-date {
            color: #6b7280;
            font-size: 10px;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10px;
        }

        th {
            background: #f3f4f6;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Firmas */
        .signature-box {
            border: 1px solid #d1d5db;
            padding: 10px;
            margin-top: 12px;
            text-align: center;
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #9ca3af;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="section-header">
        WO-<?php echo e(str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)); ?> &mdash; Detalle de Actividades
    </div>

    <!-- Timeline -->
    <div class="info-section">
        <h2>Timeline de Progreso</h2>

        <div class="timeline-item">
            <div class="tl-title">Orden Creada</div>
            <div class="tl-date"><?php echo e($workOrder->created_at->format('d/m/Y H:i')); ?></div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_inicio): ?>
            <div class="timeline-item">
                <div class="tl-title">Trabajo Iniciado</div>
                <div class="tl-date"><?php echo e($workOrder->fecha_inicio->format('d/m/Y H:i')); ?></div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_finalizacion): ?>
            <div class="timeline-item">
                <div class="tl-title">Trabajo Finalizado</div>
                <div class="tl-date"><?php echo e($workOrder->fecha_finalizacion->format('d/m/Y H:i')); ?></div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->fecha_cerrado): ?>
            <div class="timeline-item">
                <div class="tl-title">Orden Cerrada y Bloqueada</div>
                <div class="tl-date"><?php echo e($workOrder->fecha_cerrado->format('d/m/Y H:i')); ?></div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->estado === \App\Enums\WorkOrderStatus::CANCELADO): ?>
            <div class="timeline-item" style="border-left-color: #dc2626;">
                <div class="tl-title">Orden Cancelada</div>
                <div class="tl-date"><?php echo e($workOrder->updated_at->format('d/m/Y H:i')); ?></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->motivo_cancelacion): ?>
                    <div style="margin-top: 3px;">Motivo: <?php echo e($workOrder->motivo_cancelacion); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Checklist -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->checklists->count() > 0): ?>
        <?php
            $checklistBefore = $workOrder->checklists->where('fase', 'before');
            $checklistAfter = $workOrder->checklists->where('fase', 'after');
        ?>
        <div class="info-section">
            <h2>Checklist de Inspección</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checklistBefore->count() > 0): ?>
                <h3 style="margin: 10px 0 5px; font-size: 12px; color: #2563eb;">Antes del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $checklistBefore->groupBy('template.categoria'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 5px 8px;">
                                    <?php echo e(strtoupper($categoria)); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr>
                                    <td style="padding-left: 16px;"><?php echo e($item->template->nombre); ?></td>
                                    <td style="text-align: center;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->resultado->value === 'ok'): ?>
                                            <span
                                                style="background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OK</span>
                                        <?php elseif($item->resultado->value === 'observado'): ?>
                                            <span
                                                style="background:#fef3c7;color:#92400e;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OBSERVADO</span>
                                        <?php else: ?>
                                            <span
                                                style="background:#e5e7eb;color:#6b7280;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">N/A</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->observaciones ?? '-'); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checklistAfter->count() > 0): ?>
                <h3 style="margin: 14px 0 5px; font-size: 12px; color: #10b981;">Después del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $checklistAfter->groupBy('template.categoria'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 5px 8px;">
                                    <?php echo e(strtoupper($categoria)); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <tr>
                                    <td style="padding-left: 16px;"><?php echo e($item->template->nombre); ?></td>
                                    <td style="text-align: center;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->resultado->value === 'ok'): ?>
                                            <span
                                                style="background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OK</span>
                                        <?php elseif($item->resultado->value === 'observado'): ?>
                                            <span
                                                style="background:#fef3c7;color:#92400e;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OBSERVADO</span>
                                        <?php else: ?>
                                            <span
                                                style="background:#e5e7eb;color:#6b7280;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">N/A</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td><?php echo e($item->observaciones ?? '-'); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Historial de Dispositivos -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->deviceHistory->count() > 0): ?>
        <div class="info-section">
            <h2>Historial de Dispositivos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Identificador</th>
                        <th>Acción</th>
                        <th>Ubicación</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->deviceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_imei !== 'ninguna'): ?>
                            <tr>
                                <td>IMEI</td>
                                <td style="font-family: monospace;"><?php echo e($history->imei); ?></td>
                                <td><?php echo e(ucfirst($history->accion_imei)); ?></td>
                                <td><?php echo e($history->ubicacion ?? '-'); ?></td>
                                <td><?php echo e(optional($history->fecha_instalacion)->format('d/m/Y H:i')); ?></td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_sim !== 'ninguna'): ?>
                            <tr>
                                <td>SIM</td>
                                <td style="font-family: monospace;"><?php echo e($history->numero_linea); ?></td>
                                <td><?php echo e(ucfirst($history->accion_sim)); ?></td>
                                <td><?php echo e($history->ubicacion ?? '-'); ?></td>
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
            <h2>Accesorios Instalados / Retirados</h2>
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
                    <tr style="font-weight: bold; background: #f9fafb;">
                        <td colspan="4" style="text-align: right;">TOTAL:</td>
                        <td>S/ <?php echo e(number_format($workOrder->accessories->sum('subtotal'), 2)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Observaciones técnicas -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_inicial || $workOrder->observaciones_tecnico || $workOrder->observaciones_final): ?>
        <div class="info-section">
            <h2>Observaciones</h2>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_inicial): ?>
                <div style="margin-bottom: 8px;">
                    <strong>Iniciales:</strong><br><?php echo e($workOrder->observaciones_inicial); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_tecnico): ?>
                <div style="margin-bottom: 8px;">
                    <strong>Del Técnico:</strong><br><?php echo e($workOrder->observaciones_tecnico); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrder->observaciones_final): ?>
                <div>
                    <strong>Finales:</strong><br><?php echo e($workOrder->observaciones_final); ?>

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
                                        style="font-size: 9px; color: #6b7280;">(<?php echo e(ucfirst($signature->tipo_firmante)); ?>)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td><?php echo e($signature->documento_firmante ?? '-'); ?></td>
                            <td><?php echo e($signature->firmado_at->format('d/m/Y H:i')); ?></td>
                            <td style="text-align: center;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($signature->verificarIntegridad()): ?>
                                    <span
                                        style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:bold;">VERIFICADA</span>
                                <?php else: ?>
                                    <span
                                        style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:bold;">COMPROMETIDA</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrder->signatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php $signaturePath = storage_path('app/private/' . $signature->path); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists($signaturePath)): ?>
                    <div class="signature-box">
                        <h3 style="margin: 0 0 8px 0; font-size: 11px;">
                            Firma de <?php echo e(ucfirst($signature->tipo)); ?> — <?php echo e($signature->nombre_firmante); ?>

                        </h3>
                        <div style="border: 1px solid #d1d5db; padding: 8px; background: #fff;">
                            <img src="<?php echo e($signaturePath); ?>" alt="Firma"
                                style="max-width: 280px; max-height: 130px; display: block; margin: 0 auto;">
                        </div>
                        <div style="margin-top: 6px; font-size: 9px; color: #6b7280;">
                            <strong>IP:</strong> <?php echo e($signature->ip_address); ?> &nbsp;|&nbsp;
                            <strong>Hash:</strong> <?php echo e(substr($signature->hash, 0, 16)); ?>...
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Footer -->
    <div class="footer">
        <p>Generado automáticamente el <?php echo e(now()->format('d/m/Y H:i')); ?> &nbsp;·&nbsp; <?php echo e(config('app.name')); ?></p>
    </div>

</body>

</html>
<?php /**PATH C:\laragon2\www\talentus\resources\views/pdf/workOrder/detalle.blade.php ENDPATH**/ ?>