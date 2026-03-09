<?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => '📋 Suscripciones del Vehículo','wire:model.live' => 'open','max-width' => 'lg']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($open && $vehiculo): ?>
        
        <div class="mb-5 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-sky-100 dark:bg-sky-900/40 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 1h8m0-11h2.586a1 1 0 01.707.293l3.414 3.414A1 1 0 0121 10v6l-2 1h-6" />
                    </svg>
                </div>
                <div>
                    <p class="text-base font-bold text-sky-600 dark:text-sky-400"><?php echo e($vehiculo->placa); ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        <?php echo e($vehiculo->marca); ?> <?php echo e($vehiculo->modelo); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->cliente): ?>
                            — <span
                                class="font-medium text-gray-700 dark:text-gray-300"><?php echo e($vehiculo->cliente->razon_social); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <?php
            $subscriptions = $vehiculo->planSubscriptions->sortByDesc('ends_at');
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subscriptions->isEmpty()): ?>
            <div class="text-center py-8">
                <svg class="mx-auto w-12 h-12 text-amber-400 mb-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sin suscripciones registradas</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Este vehículo no tiene ningún plan asignado.
                </p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $activa = is_null($sub->canceled_at) && \Carbon\Carbon::parse($sub->ends_at)->isFuture();
                        $cancelada = !is_null($sub->canceled_at);
                        $vencida = !$activa && !$cancelada;

                        $badgeClass = match (true) {
                            $activa => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                            $cancelada => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                            default => 'bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400',
                        };
                        $badgeLabel = match (true) {
                            $activa => '✅ Activa',
                            $cancelada => '🚫 Cancelada',
                            default => '❌ Vencida',
                        };

                        $planNombre = null;
                        if ($sub->plan) {
                            $planNombre = is_array($sub->plan->name)
                                ? $sub->plan->name['es'] ?? ($sub->plan->name['en'] ?? 'Plan')
                                : $sub->plan->name;
                        }
                    ?>

                    <div
                        class="rounded-lg border <?php echo e($activa ? 'border-emerald-200 dark:border-emerald-700/50' : 'border-gray-200 dark:border-gray-700/60'); ?> p-3">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    <?php echo e($planNombre ?? ($sub->name ?? 'Plan #' . $sub->plan_id)); ?>

                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sub->plan && $sub->plan->price): ?>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        S/. <?php echo e(number_format($sub->plan->price, 2)); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full <?php echo e($badgeClass); ?> shrink-0">
                                <?php echo e($badgeLabel); ?>

                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs">
                            <div>
                                <span class="text-gray-400 dark:text-gray-500">Inicio:</span>
                                <span class="ml-1 text-gray-700 dark:text-gray-300 font-medium">
                                    <?php echo e($sub->starts_at ? \Carbon\Carbon::parse($sub->starts_at)->format('d/m/Y') : '—'); ?>

                                </span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-gray-500">Vencimiento:</span>
                                <span
                                    class="ml-1 <?php echo e($vencida ? 'text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300 font-medium'); ?>">
                                    <?php echo e($sub->ends_at ? \Carbon\Carbon::parse($sub->ends_at)->format('d/m/Y') : '—'); ?>

                                </span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sub->canceled_at): ?>
                                <div class="col-span-2">
                                    <span class="text-gray-400 dark:text-gray-500">Cancelada:</span>
                                    <span class="ml-1 text-gray-600 dark:text-gray-400">
                                        <?php echo e(\Carbon\Carbon::parse($sub->canceled_at)->format('d/m/Y')); ?>

                                    </span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activa && $sub->ends_at): ?>
                                <div class="col-span-2 mt-0.5">
                                    <?php
                                        $diasRestantes = (int) \Carbon\Carbon::now()
                                            ->startOfDay()
                                            ->diffInDays(\Carbon\Carbon::parse($sub->ends_at)->startOfDay(), false);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($diasRestantes <= 7): ?>
                                        <span class="text-amber-600 dark:text-amber-400 font-medium">
                                            ⚠️ Vence en <?php echo e($diasRestantes); ?> día<?php echo e($diasRestantes != 1 ? 's' : ''); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-emerald-600 dark:text-emerald-400">
                                            <?php echo e($diasRestantes); ?> días restantes
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

     <?php $__env->slot('footer', null, []); ?> 
        <div class="flex justify-end">
            <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['flat' => true,'label' => 'Cerrar','wire:click' => 'cerrar']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1)): ?>
<?php $attributes = $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1; ?>
<?php unset($__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1)): ?>
<?php $component = $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1; ?>
<?php unset($__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1); ?>
<?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a7d148983ed3ace55a3e668006b80a5)): ?>
<?php $attributes = $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5; ?>
<?php unset($__attributesOriginal6a7d148983ed3ace55a3e668006b80a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a7d148983ed3ace55a3e668006b80a5)): ?>
<?php $component = $__componentOriginal6a7d148983ed3ace55a3e668006b80a5; ?>
<?php unset($__componentOriginal6a7d148983ed3ace55a3e668006b80a5); ?>
<?php endif; ?>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/vehiculos/modal-ver-suscripcion.blade.php ENDPATH**/ ?>