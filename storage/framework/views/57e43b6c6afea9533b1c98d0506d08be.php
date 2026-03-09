<div class="space-y-6 mb-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        
        <div
            class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    📦 Stock bajo
                </h3>
                <a href="<?php echo e(route('admin.almacen.productos.index')); ?>" class="text-xs text-indigo-500 hover:underline">Ver
                    todos</a>
            </div>
            <div class="overflow-x-auto max-h-72">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Producto</th>
                            <th class="text-center px-3 py-2 text-slate-500">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $productosStockBajo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2">
                                    <p class="font-medium text-slate-700 dark:text-slate-200 truncate max-w-40">
                                        <?php echo e($producto->descripcion); ?></p>
                                    <p class="text-slate-400"><?php echo e($producto->categoria->nombre ?? '—'); ?></p>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <?php
                                        $colorStock =
                                            $producto->stock <= 0
                                                ? 'bg-rose-100 text-rose-700'
                                                : ($producto->stock <= 5
                                                    ? 'bg-amber-100 text-amber-700'
                                                    : 'bg-emerald-100 text-emerald-700');
                                    ?>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($colorStock); ?>">
                                        <?php echo e($producto->stock); ?> <?php echo e($producto->unit->descripcion ?? ''); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-center text-slate-400">Sin productos
                                    registrados.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div
                    class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                        🎫 Tickets
                    </h3>
                    <span
                        class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded-full">
                        <?php echo e($totalTickets); ?> total
                    </span>
                </div>
                <div class="p-4 space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ticketsPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="flex items-center justify-between">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($item['color']); ?>">
                                <?php echo e($item['estado']); ?>

                            </span>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full bg-indigo-400"
                                        style="width: <?php echo e($totalTickets > 0 ? round(($item['total'] / $totalTickets) * 100) : 0); ?>%">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-bold text-slate-700 dark:text-slate-200 w-6 text-right"><?php echo e($item['total']); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p class="text-sm text-slate-400 text-center py-4">Sin tickets registrados.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="px-5 pb-3">
                    <a href="<?php echo e(route('admin.tickets.index')); ?>" class="text-xs text-indigo-500 hover:underline">Ver
                        tickets →</a>
                </div>
            </div>

            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div
                    class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                        🔧 Órdenes de Trabajo
                    </h3>
                    <span
                        class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded-full">
                        <?php echo e($totalWorkOrders); ?> total
                    </span>
                </div>
                <div class="p-4 space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $workOrdersPorEstado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="flex items-center justify-between">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($item['color']); ?>">
                                <?php echo e($item['label']); ?>

                            </span>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full bg-orange-400"
                                        style="width: <?php echo e($totalWorkOrders > 0 ? round(($item['total'] / $totalWorkOrders) * 100) : 0); ?>%">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-bold text-slate-700 dark:text-slate-200 w-6 text-right"><?php echo e($item['total']); ?></span>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p class="text-sm text-slate-400 text-center py-4">Sin órdenes de trabajo.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="px-5 pb-3">
                    <a href="<?php echo e(route('admin.work-orders.index')); ?>"
                        class="text-xs text-indigo-500 hover:underline">Ver órdenes →</a>
                </div>
            </div>

        </div>

    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    🚗 Clientes con vehículos activos y suscripción
                </h3>
                <span
                    class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full"><?php echo e($clientesActivos->count()); ?></span>
            </div>
            <div class="overflow-x-auto max-h-80">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Cliente</th>
                            <th class="text-center px-3 py-2 text-slate-500">Vehículos activos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $clientesActivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2">
                                    <p class="font-medium text-slate-700 dark:text-slate-200 truncate max-w-[200px]">
                                        <?php echo e($cliente->razon_social); ?></p>
                                    <p class="text-slate-400"><?php echo e($cliente->numero_documento); ?></p>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                        <?php echo e($cliente->vehiculos_activos_count); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-center text-slate-400">Sin clientes con
                                    suscripción activa.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    📟 Dispositivos por modelo
                </h3>
                <a href="<?php echo e(route('admin.almacen.dispositivos.index')); ?>"
                    class="text-xs text-indigo-500 hover:underline">Ver todos</a>
            </div>
            <div class="overflow-x-auto max-h-80">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Modelo</th>
                            <th class="text-center px-3 py-2 text-slate-500">Total</th>
                            <th class="text-center px-3 py-2 text-slate-500">Vendidos</th>
                            <th class="text-center px-3 py-2 text-slate-500">En stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $dispositivosPorModelo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2 font-medium text-slate-700 dark:text-slate-200">
                                    <?php echo e($modelo->modelo); ?></td>
                                <td class="px-3 py-2 text-center font-bold text-slate-800 dark:text-white">
                                    <?php echo e($modelo->total); ?></td>
                                <td class="px-3 py-2 text-center">
                                    <span class="text-blue-600 font-medium"><?php echo e($modelo->vendidos); ?></span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="text-emerald-600 font-medium"><?php echo e($modelo->en_stock); ?></span>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-slate-400">Sin modelos registrados.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/inicio/dashboard-graficas.blade.php ENDPATH**/ ?>