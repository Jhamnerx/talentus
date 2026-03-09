<?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => WireUi::component('switcher')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['config' => $config,'attributes' => $wrapper]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php echo $__env->make('wireui-wrapper::components.slots', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <label
        tabindex="-1"
        for="<?php echo e($id); ?>"
        class="relative flex items-center select-none group"
    >
        <input <?php echo e($input
            ->merge(['type' => 'checkbox'])
            ->class([
                'translate-x-0 transform transition ease-in-out duration-200 cursor-pointer shadow-sm',
                'checked:bg-none peer focus:ring-0 focus:ring-offset-0 focus:outline-none focus:outline-hidden bg-white',
                'absolute mx-0.5 my-auto inset-y-0 border-0 appearance-none',
                'checked:text-white dark:bg-secondary-200',
                data_get($sizeClasses, 'circle'),
                $roundedClasses,
            ])); ?> />

        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'block cursor-pointer transition ease-in-out duration-100',
            'peer-focus:ring-2 peer-focus:ring-offset-2',
            'group-focus:ring-2 group-focus:ring-offset-2',
            data_get($sizeClasses, 'background'),
            $roundedClasses,
            $colorClasses,
            'invalidated:bg-negative-600 peer-focus:invalidated:bg-negative-600 peer-focus:invalidated:ring-negative-600 dark:invalidated:bg-negative-700',
            'group-focus:invalidated:ring-negative-600 dark:group-focus:invalidated:ring-negative-700',
            'dark:peer-focus:invalidated:ring-negative-700 dark:peer-focus:invalidated:ring-offset-secondary-800',
        ]); ?>"></div>
    </label>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php /**PATH C:\laragon2\www\talentus\vendor\wireui\wireui\src/Components/Switcher/views/toggle.blade.php ENDPATH**/ ?>