<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<?php if (isset($component)) { $__componentOriginal5e135796a4e85ce4ae840ece815477e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5e135796a4e85ce4ae840ece815477e9 = $attributes; } ?>
<?php $component = WireUi\Components\Label\Description::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Label\Description::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5e135796a4e85ce4ae840ece815477e9)): ?>
<?php $attributes = $__attributesOriginal5e135796a4e85ce4ae840ece815477e9; ?>
<?php unset($__attributesOriginal5e135796a4e85ce4ae840ece815477e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5e135796a4e85ce4ae840ece815477e9)): ?>
<?php $component = $__componentOriginal5e135796a4e85ce4ae840ece815477e9; ?>
<?php unset($__componentOriginal5e135796a4e85ce4ae840ece815477e9); ?>
<?php endif; ?><?php /**PATH C:\laragon2\www\talentus\storage\framework\views/9def2196f166a1a54ba414558198f2e6.blade.php ENDPATH**/ ?>