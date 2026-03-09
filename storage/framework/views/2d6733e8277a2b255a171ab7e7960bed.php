<?php
    $titulo = match ($contexto) {
        'ventas' => 'RESUMEN DE VENTAS',
        'recibos' => 'RESUMEN DE RECIBOS',
        default => 'RESUMEN VENTAS & RECIBOS',
    };
    $r = $resumen;
    $destinos = array_filter($r['destinos'] ?? [], fn($k) => $k !== '', ARRAY_FILTER_USE_KEY);
    $metodos = array_filter($r['metodos'] ?? [], fn($k) => $k !== '', ARRAY_FILTER_USE_KEY);
?>

<table>
    <tbody>

        
        <tr>
            <td colspan="6"
                style="background-color: #1E3A5F; color: #FFFFFF; font-weight: bold; font-size: 14pt; text-align: center;">
                <?php echo e($titulo); ?></td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">
                FACTURADO / EMITIDO (activos, excluye anulados y con NC)</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
        </tr>
        <tr>
            <td>Total emitido</td>
            <td><?php echo e(number_format($r['facturado_pen'], 2)); ?></td>
            <td><?php echo e(number_format($r['facturado_usd'], 2)); ?></td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">COBRADO / PAGADO</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
        </tr>
        <tr>
            <td>Total cobrado</td>
            <td><?php echo e(number_format($r['cobrado_pen'], 2)); ?></td>
            <td><?php echo e(number_format($r['cobrado_usd'], 2)); ?></td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($destinos)): ?>
            <tr>
                <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">DETALLE POR DESTINO DE COBRO</td>
            </tr>
            <tr>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Destino</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $destinos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destino => $montos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($destino ?: '(sin destino)'); ?></td>
                    <td><?php echo e(number_format($montos['pen'], 2)); ?></td>
                    <td><?php echo e(number_format($montos['usd'], 2)); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr><td colspan="6">&nbsp;</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($metodos)): ?>
            <tr>
                <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">DETALLE POR METODO DE COBRO</td>
            </tr>
            <tr>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Metodo</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $metodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo => $montos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($metodo ?: '(sin metodo)'); ?></td>
                    <td><?php echo e(number_format($montos['pen'], 2)); ?></td>
                    <td><?php echo e(number_format($montos['usd'], 2)); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr><td colspan="6">&nbsp;</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <tr><td colspan="6">&nbsp;</td></tr>

        
        <tr>
            <td colspan="6" style="background-color: #1E40AF; color: #FFFFFF; font-weight: bold;">POR COBRAR / PENDIENTE (credito sin pagar)</td>
        </tr>
        <tr>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">Concepto</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
            <th style="background-color: #3B82F6; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <td>Total por cobrar</td>
            <td><?php echo e(number_format($r['por_cobrar_pen'], 2)); ?></td>
            <td><?php echo e(number_format($r['por_cobrar_usd'], 2)); ?></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Total vencido (con retraso)</td>
            <td><?php echo e(number_format($r['vencido_pen'], 2)); ?></td>
            <td><?php echo e(number_format($r['vencido_usd'], 2)); ?></td>
            <td colspan="3"></td>
        </tr>

        
        <?php $porCobrarDocs = $r['por_cobrar_docs'] ?? []; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($porCobrarDocs)): ?>
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Documento</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Cliente</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Vencimiento</th>
                <th style="background-color: #0EA5E9; color: #FFFFFF; font-weight: bold;">Dias retraso</th>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $porCobrarDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $bg = $i % 2 === 0 ? '#FFFFFF' : '#EFF6FF';
                    $esVencido = ($doc['dias_retraso'] ?? 0) > 0;
                ?>
                <tr style="background-color: <?php echo e($esVencido ? '#FEE2E2' : $bg); ?>;">
                    <td><?php echo e($doc['documento']); ?></td>
                    <td><?php echo e($doc['cliente']); ?></td>
                    <td><?php echo e($doc['total_pen'] > 0 ? number_format($doc['total_pen'], 2) : ''); ?></td>
                    <td><?php echo e($doc['total_usd'] > 0 ? number_format($doc['total_usd'], 2) : ''); ?></td>
                    <td><?php echo e($doc['vto'] ?? ''); ?></td>
                    <td><?php echo e(($doc['dias_retraso'] ?? 0) > 0 ? $doc['dias_retraso'] . ' dias' : ''); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($r['anuladas_count'] ?? 0) > 0): ?>
            <tr>
                <td colspan="6" style="background-color: #991B1B; color: #FFFFFF; font-weight: bold;">VENTAS ANULADAS (no incluidas en el total)</td>
            </tr>
            <tr>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">Concepto</th>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #DC2626; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <tr>
                <td>Total anulado (<?php echo e($r['anuladas_count']); ?> doc.)</td>
                <td><?php echo e(number_format($r['anuladas_pen'], 2)); ?></td>
                <td><?php echo e(number_format($r['anuladas_usd'], 2)); ?></td>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr><td colspan="6">&nbsp;</td></tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($r['nc_count'] ?? 0) > 0): ?>
            <tr>
                <td colspan="6" style="background-color: #92400E; color: #FFFFFF; font-weight: bold;">VENTAS CON NOTA DE CREDITO (no incluidas en el total)</td>
            </tr>
            <tr>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">Concepto</th>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">SOLES (S/)</th>
                <th style="background-color: #D97706; color: #FFFFFF; font-weight: bold;">DOLARES ($)</th>
            </tr>
            <tr>
                <td>Total con NC (<?php echo e($r['nc_count']); ?> doc.)</td>
                <td><?php echo e(number_format($r['nc_pen'], 2)); ?></td>
                <td><?php echo e(number_format($r['nc_usd'], 2)); ?></td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </tbody>
</table><?php /**PATH C:\laragon2\www\talentus\resources\views/exports/reporte-resumen.blade.php ENDPATH**/ ?>