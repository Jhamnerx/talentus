<div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
    'border-t border-secondary-200 dark:border-secondary-600' => $separator,
]); ?>">
    <h6 <?php echo e($attributes->class([
        'block pl-2 pt-2 pb-1 text-xs text-secondary-600 sticky top-0 bg-white',
        'dark:bg-secondary-800 dark:text-secondary-400',
    ])); ?>>
        <?php echo e($label); ?>

    </h6>

    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\laragon2\www\talentus\vendor\wireui\wireui\src/Components/Dropdown/views/header.blade.php ENDPATH**/ ?>