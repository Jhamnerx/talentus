<?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($editingId ? 'Editar Tipo de Orden' : 'Nuevo Tipo de Orden').'','wire:model.live' => 'showModal','max-width' => '2xl']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <div class="space-y-4">
        
        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'nombre','label' => 'Nombre del Tipo *','placeholder' => 'Ej: Instalación GPS']); ?>
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

        
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Descripción
                <span class="text-xs text-gray-500 font-normal ml-2">
                    (Puedes usar variables para personalizar la descripción)
                </span>
            </label>

            
            <div class="flex flex-wrap gap-1 mb-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $variablesDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <button type="button" wire:click="insertarVariable('<?php echo e($variable); ?>')"
                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md 
                               bg-blue-50 text-blue-700 hover:bg-blue-100 
                               dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30
                               transition-colors duration-150"
                        title="<?php echo e($descripcion); ?>">
                        <?php echo e($variable); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'descripcion','placeholder' => 'Ej: Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%','rows' => '3']); ?>
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

            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Las variables serán reemplazadas automáticamente al crear la orden de trabajo
            </p>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'costo_base','label' => 'Costo Base (S/)','type' => 'number','step' => '0.01','placeholder' => '0.00']); ?>
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

        
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos</label>
            <div class="grid grid-cols-2 gap-3">
                <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'requiere_imei','label' => 'Requiere IMEI']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $attributes = $__attributesOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $component = $__componentOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__componentOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'requiere_sim','label' => 'Requiere SIM/ICCID']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $attributes = $__attributesOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $component = $__componentOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__componentOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'requiere_accesorios','label' => 'Requiere Accesorios']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $attributes = $__attributesOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $component = $__componentOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__componentOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'requiere_checklist','label' => 'Requiere Checklist']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $attributes = $__attributesOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__attributesOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49f7089ef4c669895a04f5fadb180b38)): ?>
<?php $component = $__componentOriginal49f7089ef4c669895a04f5fadb180b38; ?>
<?php unset($__componentOriginal49f7089ef4c669895a04f5fadb180b38); ?>
<?php endif; ?>
            </div>
        </div>

        
        <div class="col-span-2">
            <?php if (isset($component)) { $__componentOriginal12ee426d66882c66c79ce07deee9e49f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12ee426d66882c66c79ce07deee9e49f = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Toggle::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'active','label' => 'Tipo Activo','description' => 'Los tipos inactivos no aparecerán al crear órdenes']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal12ee426d66882c66c79ce07deee9e49f)): ?>
<?php $attributes = $__attributesOriginal12ee426d66882c66c79ce07deee9e49f; ?>
<?php unset($__attributesOriginal12ee426d66882c66c79ce07deee9e49f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal12ee426d66882c66c79ce07deee9e49f)): ?>
<?php $component = $__componentOriginal12ee426d66882c66c79ce07deee9e49f; ?>
<?php unset($__componentOriginal12ee426d66882c66c79ce07deee9e49f); ?>
<?php endif; ?>
        </div>

        
        <div
            class="col-span-2 rounded-lg border border-amber-200 bg-amber-50 p-3
                    dark:border-amber-600/30 dark:bg-amber-950/20">
            <div class="flex items-start gap-2 mb-2">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-500 dark:text-amber-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wide">
                    Mantenimiento Programado
                </span>
            </div>
            <?php if (isset($component)) { $__componentOriginal12ee426d66882c66c79ce07deee9e49f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12ee426d66882c66c79ce07deee9e49f = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Toggle::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'es_mantenimiento_programado','label' => 'Tipo para Mantenimientos Programados','description' => 'Al crear una orden con este tipo, se podrá vincular con una notificación de mantenimiento programado del vehículo']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal12ee426d66882c66c79ce07deee9e49f)): ?>
<?php $attributes = $__attributesOriginal12ee426d66882c66c79ce07deee9e49f; ?>
<?php unset($__attributesOriginal12ee426d66882c66c79ce07deee9e49f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal12ee426d66882c66c79ce07deee9e49f)): ?>
<?php $component = $__componentOriginal12ee426d66882c66c79ce07deee9e49f; ?>
<?php unset($__componentOriginal12ee426d66882c66c79ce07deee9e49f); ?>
<?php endif; ?>
        </div>
    </div>

     <?php $__env->slot('footer', null, ['class' => 'flex justify-end gap-3']); ?> 
        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['flat' => true,'label' => 'Cancelar','wire:click' => '$set(\'showModal\', false)']); ?>
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
        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['primary' => true,'label' => ''.e($editingId ? 'Actualizar' : 'Guardar').'','wire:click' => 'guardar','spinner' => 'guardar']); ?>
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
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/work-orders/types/create.blade.php ENDPATH**/ ?>