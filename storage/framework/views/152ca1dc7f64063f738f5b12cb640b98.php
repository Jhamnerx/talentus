<div class="space-y-6 mb-8">

    
    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
        </svg>
        Reportes del mes — indicadores clave
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    📡 GPS Vendidos — últimos 6 meses
                </h3>
            </div>
            
            <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:240px;" x-data="ventasBarChart('<?php echo e(route('admin.dashboard.chart-ventas', ['tipo' => 'gps'])); ?>')"
                x-init="init()">
                <canvas x-ref="canvas" style="width:100%;height:220px;"></canvas>
            </div>
        </div>

        
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🛰️ Servicio de Monitoreo — últimos 6 meses
                </h3>
            </div>
            
            <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:240px;" x-data="ventasBarChart('<?php echo e(route('admin.dashboard.chart-ventas', ['tipo' => 'monitoreo'])); ?>')"
                x-init="init()">
                <canvas x-ref="canvas" style="width:100%;height:220px;"></canvas>
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    ⚠️ Suspensiones de Líneas
                </h3>
                <div class="flex gap-2">
                    <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Semana:
                        <?php echo e($suspensionesTotalSemana); ?></span>
                    <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">Mes:
                        <?php echo e($suspensionesTotalMes); ?></span>
                </div>
            </div>
            <div class="p-4 max-h-56 overflow-y-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $suspensionesDetallesMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div
                        class="flex items-center justify-between py-1.5 border-b border-slate-50 dark:border-slate-700 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200"><?php echo e($linea->numero); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e($linea->operador); ?></p>
                        </div>
                        <span class="text-xs text-slate-400"><?php echo e($linea->updated_at->format('d/m/Y')); ?></span>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <p class="text-sm text-slate-400 py-2">Sin suspensiones registradas este mes.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        

    </div>

    
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                🧾 Total Ventas Facturadas — últimos 6 meses
            </h3>
        </div>
        <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:260px;" x-data="facturadasBarChart('<?php echo e(route('admin.dashboard.chart-facturadas')); ?>')"
            x-init="init()">
            <canvas x-ref="canvas" style="width:100%;height:240px;"></canvas>
        </div>
    </div>

    
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                ✅ Pagados — Detalle por método de pago (mes)
            </h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <h4 class="text-sm font-semibold text-slate-500 uppercase mb-3 flex items-center justify-between">
                        Facturas pagadas (mes)
                        <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5 rounded-full">
                            <?php echo e($countFacturasMes); ?> docs · S/ <?php echo e(number_format($totalFacturasMes, 2)); ?>

                        </span>
                    </h4>
                    <div class="space-y-2 mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $metodosFacturasMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg px-3 py-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        <?php echo e($metodo->paymentMethod->description ?? '(sin método)'); ?>

                                    </span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs text-slate-400"><?php echo e($metodo->cantidad); ?> pago(s)</span>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-white">S/
                                            <?php echo e(number_format($metodo->total, 2)); ?></span>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($metodo->destination): ?>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        → <?php echo e($metodo->destination_description); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <p class="text-sm text-slate-400">Sin registros de pago este mes.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div>
                    <h4 class="text-sm font-semibold text-slate-500 uppercase mb-3 flex items-center justify-between">
                        Recibos pagados (mes)
                        <span class="bg-violet-100 text-violet-700 text-xs px-2 py-0.5 rounded-full">
                            <?php echo e($countRecibosMes); ?> docs · S/ <?php echo e(number_format($totalRecibosMes, 2)); ?>

                        </span>
                    </h4>
                    <div class="space-y-2 mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $metodosRecibosMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="bg-slate-50 dark:bg-slate-700 rounded-lg px-3 py-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                                        <?php echo e($metodo->paymentMethod->description ?? '(sin método)'); ?>

                                    </span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs text-slate-400"><?php echo e($metodo->cantidad); ?> pago(s)</span>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-white">S/
                                            <?php echo e(number_format($metodo->total, 2)); ?></span>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($metodo->destination): ?>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        → <?php echo e($metodo->destination_description); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <p class="text-sm text-slate-400">Sin registros de pago este mes.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🔴 Ventas por cobrar
                    <span class="text-xs font-normal text-slate-400">sin NC · sin baja</span>
                </h3>
            </div>
            <div class="p-4 space-y-3">
                <?php
                    $fPen = $facturasPorCobrar['PEN'] ?? null;
                    $fUsd = $facturasPorCobrar['USD'] ?? null;
                ?>

                
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/40 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs font-bold px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300">PEN</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            <?php echo e($fPen ? number_format($fPen->cantidad) : 0); ?> doc.
                        </span>
                    </div>
                    <span class="text-lg font-bold text-slate-800 dark:text-white">
                        S/ <?php echo e(number_format($fPen ? $fPen->monto_total : 0, 2)); ?>

                    </span>
                </div>

                
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/40 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs font-bold px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">USD</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            <?php echo e($fUsd ? number_format($fUsd->cantidad) : 0); ?> doc.
                        </span>
                    </div>
                    <span class="text-lg font-bold text-slate-800 dark:text-white">
                        $ <?php echo e(number_format($fUsd ? $fUsd->monto_total : 0, 2)); ?>

                    </span>
                </div>
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🟡 Recibos por cobrar
                </h3>
            </div>
            <div class="p-4 space-y-3">
                <?php
                    $rPen = $recibosPorCobrar['PEN'] ?? null;
                    $rUsd = $recibosPorCobrar['USD'] ?? null;
                ?>

                
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/40 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs font-bold px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300">PEN</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            <?php echo e($rPen ? number_format($rPen->cantidad) : 0); ?> doc.
                        </span>
                    </div>
                    <span class="text-lg font-bold text-slate-800 dark:text-white">
                        S/ <?php echo e(number_format($rPen ? $rPen->monto_total : 0, 2)); ?>

                    </span>
                </div>

                
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/40 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs font-bold px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">USD</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            <?php echo e($rUsd ? number_format($rUsd->cantidad) : 0); ?> doc.
                        </span>
                    </div>
                    <span class="text-lg font-bold text-slate-800 dark:text-white">
                        $ <?php echo e(number_format($rUsd ? $rUsd->monto_total : 0, 2)); ?>

                    </span>
                </div>
            </div>
        </div>

    </div>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/inicio/dashboard-reportes.blade.php ENDPATH**/ ?>