<div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($open && $this->model): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4" x-data
            @keydown.escape.window="$wire.cerrarModal()">

            <div
                class="relative bg-white dark:bg-gray-800 rounded-sm shadow-xl w-full max-w-5xl max-h-[90vh] flex flex-col">

                
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-gray-700 shrink-0">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                            Pagos —
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modelType === 'Ventas'): ?>
                                <?php echo e($this->model->serie_correlativo ?? $this->model->id); ?>

                            <?php else: ?>
                                <?php echo e($this->model->serie_numero ?? $this->model->id); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            Cliente:
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modelType === 'Ventas'): ?>
                                <?php echo e($this->model->cliente?->razon_social); ?>

                            <?php else: ?>
                                <?php echo e($this->model->clientes?->razon_social); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                    <button wire:click="cerrarModal"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                
                <div class="flex-1 px-6 py-4">

                    
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold uppercase text-slate-500 dark:text-slate-400 mb-2">Pagos
                            registrados</h4>
                        <div class="overflow-x-auto rounded-sm border border-slate-200 dark:border-gray-700">
                            <table class="table-auto w-full text-sm">
                                <thead
                                    class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-gray-900 border-b border-slate-200 dark:border-gray-700">
                                    <tr>
                                        <th class="px-3 py-2 text-left">#</th>
                                        <th class="px-3 py-2 text-left">Fecha de pago</th>
                                        <th class="px-3 py-2 text-left">Método de pago</th>
                                        <th class="px-3 py-2 text-left">Destino</th>
                                        <th class="px-3 py-2 text-left">N° Operación</th>
                                        <th class="px-3 py-2 text-right">Monto</th>
                                        <th class="px-3 py-2 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-gray-700">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-gray-700/50">
                                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300"><?php echo e($index + 1); ?>

                                            </td>
                                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                                <?php echo e($pago->fecha?->format('d-m-Y')); ?>

                                            </td>
                                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">
                                                <?php echo e($pago->paymentMethod?->description ?? '—'); ?>

                                            </td>
                                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">
                                                <?php echo e($pago->destination?->description ?? ($pago->destination?->nombre ?? '—')); ?>

                                            </td>
                                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">
                                                <?php echo e($pago->numero_operacion ?? '—'); ?>

                                            </td>
                                            <td class="px-3 py-2 text-right font-medium text-emerald-600">
                                                <?php echo e($this->simbolo); ?> <?php echo e(number_format($pago->monto, 2)); ?>

                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <button wire:click="eliminarPago(<?php echo e($pago->id); ?>)"
                                                    wire:confirm="¿Estás seguro de eliminar este pago?"
                                                    class="text-red-400 hover:text-red-600 transition-colors"
                                                    title="Eliminar pago">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="7"
                                                class="px-3 py-4 text-center text-slate-400 dark:text-slate-500 italic">
                                                No hay pagos registrados.
                                            </td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($nuevos_pagos) > 0): ?>
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold uppercase text-slate-500 dark:text-slate-400 mb-2">Nuevos
                                pagos</h4>
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $nuevos_pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <div
                                        class="rounded-sm border border-emerald-200 dark:border-emerald-800 bg-emerald-50/40 dark:bg-emerald-900/10 p-3">
                                        <div class="grid grid-cols-12 gap-3 items-end">
                                            
                                            <div class="col-span-12 sm:col-span-2">
                                                <label
                                                    class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">
                                                    Fecha <span class="text-red-400">*</span>
                                                </label>
                                                <input type="date"
                                                    wire:model.live="nuevos_pagos.<?php echo e($i); ?>.fecha"
                                                    class="form-input text-sm w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" />
                                            </div>
                                            
                                            <div class="col-span-12 sm:col-span-3">
                                                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Método de pago *','wire:model.live' => 'nuevos_pagos.'.e($i).'.metodo_pago_id','placeholder' => 'Seleccione un método','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->metodosPago),'option-label' => 'name','option-value' => 'id']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $attributes = $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $component = $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
                                            </div>
                                            
                                            <div class="col-span-12 sm:col-span-3">
                                                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Destino *','wire:model.live' => 'nuevos_pagos.'.e($i).'.payment_destination_id','placeholder' => 'Seleccione un destino','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->destinosPago),'option-label' => 'description','option-value' => 'id']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $attributes = $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $component = $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
                                            </div>
                                            
                                            <div class="col-span-12 sm:col-span-2">
                                                <label
                                                    class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">
                                                    N° Operación
                                                </label>
                                                <input type="text"
                                                    wire:model.live="nuevos_pagos.<?php echo e($i); ?>.numero_operacion"
                                                    placeholder="Ref. opcional"
                                                    class="form-input text-sm w-full dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600" />
                                            </div>
                                            
                                            <div class="col-span-8 sm:col-span-1">
                                                <label
                                                    class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">
                                                    Monto <span class="text-red-400">*</span>
                                                </label>
                                                <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'nuevos_pagos.'.e($i).'.monto','placeholder' => '0.00','inputmode' => 'decimal','x-on:keypress' => 'if (!/[\d.]/.test($event.key) || ($event.key === \'.\' && $event.target.value.includes(\'.\'))) $event.preventDefault()','x-on:paste.prevent' => '
                                                        let txt = ($event.clipboardData || window.clipboardData).getData(\'text\');
                                                        let clean = txt.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');
                                                        let val = $event.target.value;
                                                        let start = $event.target.selectionStart;
                                                        $event.target.value = val.slice(0, start) + clean + val.slice($event.target.selectionEnd);
                                                        $event.target.dispatchEvent(new Event(\'input\'));
                                                    ']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal125559500674abc14ca4c750a63c3764)): ?>
<?php $attributes = $__attributesOriginal125559500674abc14ca4c750a63c3764; ?>
<?php unset($__attributesOriginal125559500674abc14ca4c750a63c3764); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal125559500674abc14ca4c750a63c3764)): ?>
<?php $component = $__componentOriginal125559500674abc14ca4c750a63c3764; ?>
<?php unset($__componentOriginal125559500674abc14ca4c750a63c3764); ?>
<?php endif; ?>
                                            </div>
                                            
                                            <div
                                                class="col-span-4 sm:col-span-1 flex items-center justify-end gap-3 pb-1">
                                                <label class="inline-flex flex-col items-center gap-1 cursor-pointer">
                                                    <span
                                                        class="text-xs text-slate-500 dark:text-slate-400">Recibido</span>
                                                    <input type="checkbox"
                                                        wire:model.live="nuevos_pagos.<?php echo e($i); ?>.recibido"
                                                        class="form-checkbox" />
                                                </label>
                                                <button wire:click="eliminarFilaNueva(<?php echo e($i); ?>)"
                                                    class="text-red-400 hover:text-red-600 transition-colors"
                                                    title="Quitar fila">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->pendiente > 0): ?>
                            <button wire:click="agregarFila"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Nuevo pago
                            </button>
                        <?php else: ?>
                            <p
                                class="inline-flex items-center gap-1.5 text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Monto total cubierto — no se pueden agregar más pagos.
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        <div
                            class="rounded-sm border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 px-4 py-3">
                            <p class="text-xs uppercase font-semibold text-slate-500 dark:text-slate-400">Total pagado
                            </p>
                            <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">
                                <?php echo e($this->simbolo); ?> <?php echo e(number_format($this->totalPagado, 2)); ?>

                            </p>
                        </div>
                        <div
                            class="rounded-sm border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 px-4 py-3">
                            <p class="text-xs uppercase font-semibold text-slate-500 dark:text-slate-400">Total a pagar
                            </p>
                            <p class="text-lg font-bold text-slate-800 dark:text-slate-100 mt-0.5">
                                <?php echo e($this->simbolo); ?> <?php echo e(number_format($this->totalAPagar, 2)); ?>

                            </p>
                        </div>
                        <div
                            class="rounded-sm border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 px-4 py-3">
                            <p class="text-xs uppercase font-semibold text-slate-500 dark:text-slate-400">Pendiente de
                                pago</p>
                            <p
                                class="text-lg font-bold mt-0.5 <?php echo e($this->pendiente > 0 ? 'text-orange-500' : 'text-emerald-600 dark:text-emerald-400'); ?>">
                                <?php echo e($this->simbolo); ?> <?php echo e(number_format($this->pendiente, 2)); ?>

                            </p>
                        </div>
                    </div>

                </div>

                
                <div
                    class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 dark:border-gray-700 shrink-0">
                    <button wire:click="cerrarModal"
                        class="btn border-slate-200 dark:border-gray-600 hover:border-slate-300 dark:hover:border-gray-500 text-slate-600 dark:text-slate-300">
                        Cerrar
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($nuevos_pagos) > 0): ?>
                        <button wire:click="guardarPagos" wire:loading.attr="disabled" wire:target="guardarPagos"
                            class="btn bg-indigo-500 hover:bg-indigo-600 text-white disabled:opacity-50">
                            <svg wire:loading wire:target="guardarPagos"
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 22 5.373 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Guardar pagos
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/shared/pagos-modal.blade.php ENDPATH**/ ?>