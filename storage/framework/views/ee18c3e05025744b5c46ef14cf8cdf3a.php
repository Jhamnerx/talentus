<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id' => null, 'name' => null, 'size' => 'md']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['id' => null, 'name' => null, 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizes = [
        'xs' => 'h-4 w-8',
        'sm' => 'h-5 w-9',
        'md' => 'h-6 w-11',
        'lg' => 'h-7 w-14',
        'xl' => 'h-8 w-16',
    ];
    
    $thumbSizes = [
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-4 w-4',
        'lg' => 'h-5 w-5',
        'xl' => 'h-6 w-6',
    ];
    
    $translations = [
        'xs' => 'translate-x-4',
        'sm' => 'translate-x-4',
        'md' => 'translate-x-6',
        'lg' => 'translate-x-7',
        'xl' => 'translate-x-8',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $thumbClass = $thumbSizes[$size] ?? $thumbSizes['md'];
    $translateClass = $translations[$size] ?? $translations['md'];
    $uniqueId = $id ?? 'toggle-' . uniqid();
?>

<button 
    type="button"
    <?php echo e($attributes->whereDoesntStartWith('wire:model')); ?>

    x-data="{ on: <?php if ((object) ($attributes->wire('model')) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')->value()); ?>')<?php echo e($attributes->wire('model')->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($attributes->wire('model')); ?>')<?php endif; ?> }"
    @click="on = !on"
    :class="on ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"
    class="relative inline-flex <?php echo e($sizeClass); ?> items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:ring-offset-2"
    role="switch"
    :aria-checked="on"
>
    <span 
        :class="on ? '<?php echo e($translateClass); ?>' : 'translate-x-1'"
        class="inline-block <?php echo e($thumbClass); ?> transform rounded-full bg-white transition-transform"
    ></span>
</button>
<?php /**PATH C:\laragon2\www\talentus\resources\views/components/toggle.blade.php ENDPATH**/ ?>