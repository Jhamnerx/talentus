<!DOCTYPE html>
<html lang="es">

<body>

    <table class="detalle" border="1">
        <tbody class="text-sm divide-y divide-slate-200">

            <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                    <div class="text-center">
                        <strong><?php echo e($tecnico->name); ?></strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Fecha Inicial</strong></td>
                <td><?php echo e(\Carbon\Carbon::parse($fechas['fecha_inicial'])->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Fecha Final</strong></td>
                <td><?php echo e(\Carbon\Carbon::parse($fechas['fecha_final'])->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Estado</strong></td>
                <td><?php echo e($estado ? ucfirst(str_replace('_', ' ', $estado)) : 'Todos'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total a Pagar (Finalizadas):</strong></td>
                <td>S/. <?php echo e(number_format($total_costo_finalizadas, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">

    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($workOrders->count()): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $workOrdersGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estadoKey => $ordenes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $estadoLabel = ucfirst(str_replace('_', ' ', $estadoKey));
                $totalEstado = $totales_por_estado[$estadoKey] ?? 0;
            ?>

            
            <table border="1" style="margin-top: 15px;">
                <tr style="background-color: #e5e7eb;">
                    <td colspan="7" style="padding: 8px;">
                        <strong style="font-size: 14px;">ESTADO: <?php echo e(strtoupper($estadoLabel)); ?></strong>
                    </td>
                    <td colspan="6" style="padding: 8px; text-align: right;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($estadoKey === 'finalizado'): ?>
                            <strong>Total a Pagar: S/. <?php echo e(number_format($totalEstado, 2)); ?></strong>
                        <?php else: ?>
                            <strong><?php echo e($ordenes->count()); ?> órdenes</strong>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
            </table>

            
            <table border="1">
                <thead>
                    <tr>
                        <td><strong>Código</strong></td>
                        <td><strong>Tipo de Orden</strong></td>
                        <td><strong>Cliente</strong></td>
                        <td><strong>Vehículo</strong></td>
                        <td><strong>Placa</strong></td>
                        <td><strong>Fecha Programada</strong></td>
                        <td><strong>Fecha Inicio</strong></td>
                        <td><strong>Fecha Finalización</strong></td>
                        <td><strong>IMEI</strong></td>
                        <td><strong>ICCID</strong></td>
                        <td><strong>Costo Base</strong></td>
                        <td><strong>Total</strong></td>
                        <td><strong>Observaciones</strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $costo_base = floatval($orden->tipo_data['costo_base'] ?? 0);
                            $costo_accesorios = $orden->accessories->sum('subtotal');
                            $total = $costo_base + $costo_accesorios;
                        ?>
                        <tr>
                            <td><?php echo e(str_pad($orden->id, 5, '0', STR_PAD_LEFT)); ?></td>
                            <td><?php echo e($orden->tipo_data['nombre'] ?? $orden->tipo->nombre); ?></td>
                            <td><?php echo e($orden->cliente->razon_social); ?></td>
                            <td><?php echo e($orden->vehiculo->marca); ?> <?php echo e($orden->vehiculo->modelo); ?></td>
                            <td><?php echo e($orden->vehiculo->placa); ?></td>
                            <td><?php echo e($orden->fecha_programada->format('d/m/Y H:i')); ?></td>
                            <td><?php echo e($orden->fecha_inicio ? $orden->fecha_inicio->format('d/m/Y H:i') : '-'); ?></td>
                            <td><?php echo e($orden->fecha_finalizacion ? $orden->fecha_finalizacion->format('d/m/Y H:i') : '-'); ?>

                            </td>
                            <td><?php echo e($orden->imei ?? '-'); ?></td>
                            <td><?php echo e($orden->iccid ?? '-'); ?></td>
                            <td>S/. <?php echo e(number_format($costo_base, 2)); ?></td>
                            <td>S/. <?php echo e(number_format($total, 2)); ?></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->observaciones_inicial): ?>
                                    <strong>Inicial:</strong> <?php echo e($orden->observaciones_inicial); ?><br>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->observaciones_tecnico): ?>
                                    <strong>Técnico:</strong> <?php echo e($orden->observaciones_tecnico); ?><br>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->observaciones_final): ?>
                                    <strong>Final:</strong> <?php echo e($orden->observaciones_final); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$orden->observaciones_inicial && !$orden->observaciones_tecnico && !$orden->observaciones_final): ?>
                                    -
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->accessories->count() > 0): ?>
                            <tr>
                                <td colspan="13" style="background-color: #f3f4f6; padding-left: 20px;">
                                    <strong>Accesorios:</strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orden->accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <?php echo e($accessory->nombre); ?> (<?php echo e($accessory->cantidad); ?> x S/.
                                        <?php echo e(number_format($accessory->precio_unitario, 2)); ?>)<?php echo e($loop->last ? '' : ', '); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->deviceHistory->count() > 0): ?>
                            <tr>
                                <td colspan="13" style="background-color: #f9fafb; padding-left: 20px;">
                                    <strong>Historial Dispositivos:</strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orden->deviceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_imei !== 'ninguna'): ?>
                                            IMEI <?php echo e($history->imei); ?>

                                            (<?php echo e(ucfirst($history->accion_imei)); ?>)
                                            <?php echo e($loop->last ? '' : ', '); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->accion_sim !== 'ninguna'): ?>
                                            SIM <?php echo e($history->numero_linea); ?>

                                            (<?php echo e(ucfirst($history->accion_sim)); ?>)<?php echo e($loop->last ? '' : ', '); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($estadoKey === 'finalizado'): ?>
                        <tr style="background-color: #fef3c7; font-weight: bold;">
                            <td colspan="11" style="text-align: right; padding: 8px;">SUBTOTAL
                                <?php echo e(strtoupper($estadoLabel)); ?>:</td>
                            <td colspan="2" style="padding: 8px;">S/. <?php echo e(number_format($totalEstado, 2)); ?></td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        
        <table border="1" style="margin-top: 20px;">
            <tr style="background-color: #10b981; color: white;">
                <td colspan="11" style="text-align: right; padding: 10px; font-size: 14px;">
                    <strong>TOTAL A PAGAR AL TÉCNICO (Solo Finalizadas):</strong>
                </td>
                <td colspan="2" style="padding: 10px; font-size: 14px;">
                    <strong>S/. <?php echo e(number_format($total_costo_finalizadas, 2)); ?></strong>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <table border="1">
            <tr>
                <td colspan="13" style="text-align: center; padding: 20px;">
                    No se encontraron órdenes de trabajo con los parámetros especificados
                </td>
            </tr>
        </table>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</body>

</html>
<?php /**PATH C:\laragon2\www\talentus\resources\views/exports/work-orders.blade.php ENDPATH**/ ?>