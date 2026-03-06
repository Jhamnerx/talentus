<div class="overflow-x-auto border border-violet-400 dark:border-violet-600 rounded-lg">

    <table class="w-full">
        <!-- Table header -->
        <thead
            class="text-xs font-semibold uppercase text-white bg-linear-to-r from-slate-800 to-indigo-500 border-t border-b rounded-lg border-slate-200 dark:border-gray-700">
            <tr>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-left">CODIGO</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">UNI/MEDIDA</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">CANTIDAD</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">DESCRIPCION</div>
                </th>

                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">VALOR UNITARIO</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">IGV</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">IMPORTE DE VENTA</div>
                </th>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo != '07' && $tipo != '08'): ?>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-semibold text-center">ACCIONES</div>
                </th>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </tr>
        </thead>
        <!-- Table body -->
        <tbody class="text-xs divide-y divide-slate-200 dark:divide-gray-600 listaItems">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $prepayments->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clave => $prepayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="main bg-slate-100 dark:bg-gray-800" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('item-prepay-{{ $clave }}', get_defined_vars()); ?>wire:key="item-prepay-<?php echo e($clave); ?>">

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($prepayment['serie_correlativo_ref']); ?>

                    </div>

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">

                    </div>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-36 md:min-w-0">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        1
                    </div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-72 md:min-w-0">

                    <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => true,'wire:model.live' => 'prepayments.'.e($clave).'.descripcion']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal766d51b9779a62d55606e4facdbf6fa8)): ?>
<?php $attributes = $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8; ?>
<?php unset($__attributesOriginal766d51b9779a62d55606e4facdbf6fa8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal766d51b9779a62d55606e4facdbf6fa8)): ?>
<?php $component = $__componentOriginal766d51b9779a62d55606e4facdbf6fa8; ?>
<?php unset($__componentOriginal766d51b9779a62d55606e4facdbf6fa8); ?>
<?php endif; ?>

                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        -<?php echo e($prepayment['valor_venta_ref']); ?>

                    </div>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        -<?php echo e($prepayment['igv']); ?>

                    </div>

                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        -<?php echo e($prepayment['total_invoice_ref']); ?>

                    </div>
                </td>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo != '07' && $tipo != '08'): ?>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                    <div class="space-x-1">

                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Eliminar','wire:click.prevent' => 'eliminarPrepayment(\''.e($clave).'\')','outline' => true,'red' => true,'sm' => true,'icon' => 'trash']); ?>
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
                </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->environment('local')): ?>
            <div class="col-span-12 md:col-start-5 md:col-span-4">
                <?php echo e(json_encode($items)); ?>

            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clave => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="main bg-slate-100 dark:bg-gray-800" <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('item-{{ $clave }}', get_defined_vars()); ?>wire:key="item-<?php echo e($clave); ?>">
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($items[$clave]['codigo']); ?>

                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('items.' . $clave . '.codigo')): ?>
                    <p class="mt-2
                                text-pink-600 text-sm">
                        <?php echo e($errors->first('items.' . $clave . '.codigo')); ?>

                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($items[$clave]['unit_name']); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('items.' . $clave . '.unit_name')): ?>
                    <p class="mt-2  text-pink-600 text-sm">
                        <?php echo e($errors->first('items.' . $clave . '.unit')); ?>

                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap min-w-36 md:min-w-0">

                    <?php if (isset($component)) { $__componentOriginal52e32dd6052e70eb6819edea2a97985a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52e32dd6052e70eb6819edea2a97985a = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Number::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'items.'.e($clave).'.cantidad','min' => '1','step' => '1','placeholder' => 'Cantidad']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52e32dd6052e70eb6819edea2a97985a)): ?>
<?php $attributes = $__attributesOriginal52e32dd6052e70eb6819edea2a97985a; ?>
<?php unset($__attributesOriginal52e32dd6052e70eb6819edea2a97985a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52e32dd6052e70eb6819edea2a97985a)): ?>
<?php $component = $__componentOriginal52e32dd6052e70eb6819edea2a97985a; ?>
<?php unset($__componentOriginal52e32dd6052e70eb6819edea2a97985a); ?>
<?php endif; ?>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => true,'wire:model.live' => 'items.'.e($clave).'.descripcion']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal766d51b9779a62d55606e4facdbf6fa8)): ?>
<?php $attributes = $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8; ?>
<?php unset($__attributesOriginal766d51b9779a62d55606e4facdbf6fa8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal766d51b9779a62d55606e4facdbf6fa8)): ?>
<?php $component = $__componentOriginal766d51b9779a62d55606e4facdbf6fa8; ?>
<?php unset($__componentOriginal766d51b9779a62d55606e4facdbf6fa8); ?>
<?php endif; ?>

                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($items[$clave]['valor_unitario']); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('items.' . $clave . '.valor_unitario')): ?>
                    <p class="mt-2  text-pink-600 text-sm">
                        <?php echo e($errors->first('items.' . $clave . '.valor_unitario')); ?>

                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>

                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($items[$clave]['igv']); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('items.' . $clave . '.igv')): ?>
                    <p class="mt-2  text-pink-600 text-sm">
                        <?php echo e($errors->first('items.' . $clave . '.igv')); ?>

                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        <?php echo e($items[$clave]['total']); ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->has('items.' . $clave . '.total')): ?>
                    <p class="mt-2  text-pink-600 text-sm">
                        <?php echo e($errors->first('items.' . $clave . '.total')); ?>

                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo != '07' && $tipo != '08'): ?>
                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                    <div class="space-x-1">

                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Eliminar','wire:click.prevent' => 'eliminarProducto(\''.e($clave).'\')','outline' => true,'red' => true,'sm' => true,'icon' => 'trash']); ?>
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
                </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->count() < 1): ?> <tr>
                <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                    <div class="font-normal text-center text-gray-900 dark:text-gray-200">
                        AÑADIR PRODUCTOS
                    </div>

                </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
        <tfoot>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                <?php echo e($message); ?>

            </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tfoot>
    </table>
</div><?php /**PATH C:\laragon2\www\talentus\resources\views/components/admin/facturacion/tabla-detalle.blade.php ENDPATH**/ ?>