<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                <?php echo e($tipo ? ($tipo === 'producto' ? 'Productos' : 'Servicios') : 'Productos'); ?> ✨
            </h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => ''.e($tipo ? ($tipo === 'producto' ? 'Buscar productos' : 'Buscar servicios') : 'Buscar productos').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => ''.e($tipo ? ($tipo === 'producto' ? 'Buscar productos' : 'Buscar servicios') : 'Buscar productos').'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $attributes = $__attributesOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__attributesOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $component = $__componentOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__componentOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
            <!-- Add customer button -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-producto')): ?>
                <button wire:click.prevent="openModalCreate"
                    class="btn cursor-pointer bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">
                        <?php echo e($tipo ? ($tipo === 'producto' ? 'Añadir Producto' : 'Añadir Servicio') : 'Añadir Producto'); ?>

                    </span>
                </button>
            <?php endif; ?>

        </div>

    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Filter by categoria -->
            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'categoriaFilter','placeholder' => 'Todas las categorías']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '','label' => 'Todas las categorías']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => 'categoria-'.e($categoria->id).'','value' => ''.e($categoria->id).'','label' => ''.e($categoria->nombre).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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

            <!-- Filter by tipo -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$tipo): ?>
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'tipoFilter','placeholder' => 'Todos los tipos']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '','label' => 'Todos los tipos']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'producto','label' => 'Producto']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'servicio','label' => 'Servicio']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
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
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Filter by status -->
            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'estadoFilter','placeholder' => 'Todos los estados']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '','label' => 'Todos los estados']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '1','label' => 'Activo']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '0','label' => 'Desactivado']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $attributes = $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__attributesOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede)): ?>
<?php $component = $__componentOriginala4f38432c8908ddbfb286ebfc0889ede; ?>
<?php unset($__componentOriginala4f38432c8908ddbfb286ebfc0889ede); ?>
<?php endif; ?>
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
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-gray-100">
                Total <?php echo e($tipo ? ($tipo === 'producto' ? 'Productos' : 'Servicios') : 'Productos'); ?>

                <span class="text-slate-400 dark:text-gray-400 font-medium"><?php echo e($productos->total()); ?></span>
            </h2>
        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20 border-t border-b border-slate-200 dark:border-gray-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">CÓDIGO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">IMAGEN</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">DESCRIPCIÓN</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">CATEGORÍA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">VALOR UNITARIO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">STOCK</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">COBROS</div>
                            </th>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cambiar.estado-producto')): ?>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">ESTADO</div>
                                </th>
                            <?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->can('editar-producto') || auth()->user()->can('eliminar-producto')): ?>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">ACCIONES</div>
                                </th>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('', get_defined_vars()); ?>wire:key='product-<?php echo e($producto->id); ?>'>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left font-medium text-slate-800 dark:text-gray-100">
                                        <?php echo e($producto->codigo); ?></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="w-12 h-12">
                                        <img class="h-full w-full shrink-0 grow-0 rounded-full"
                                            src="<?php echo e($producto->image ? Storage::url($producto->image->url) : Storage::url('productos/default.jpg')); ?>"
                                            alt="<?php echo e($producto->descripcion); ?>">
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        <?php echo e($producto->descripcion); ?></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        <?php echo e($producto->categoria->nombre); ?></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        <?php echo e($producto->divisa == 'USD' ? '$ ' . $producto->valor_unitario : 'S/ ' . $producto->valor_unitario); ?>

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-gray-100">
                                        <?php echo e($producto->tipo == 'producto' ? $producto->stock . ' ' . $producto->unit->name : 'servicio'); ?>

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($producto->es_servicio_cobro): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 ring-1 ring-inset ring-emerald-500/30">
                                            💳 Facturación
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cambiar.estado-producto')): ?>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="form-switch flex justify-center" x-data="{ on: <?php echo e($producto->estado ? 'true' : 'false'); ?> }">
                                            <input type="checkbox" class="sr-only" x-bind:checked="on"
                                                x-on:click="on = !on; $wire.toggleStatus(<?php echo e($producto->id); ?>)" />
                                            <label class="bg-slate-400 dark:bg-slate-600 cursor-pointer"
                                                x-on:click="on = !on; $wire.toggleStatus(<?php echo e($producto->id); ?>)">
                                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                            </label>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->can('editar-producto') || auth()->user()->can('eliminar-producto')): ?>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar-producto')): ?>
                                                <button wire:click="openModalEdit(<?php echo e($producto->id); ?>)"
                                                    class="text-slate-400 hover:text-slate-500 dark:text-gray-400 dark:hover:text-gray-300 cursor-pointer">
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <path
                                                            d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar-producto')): ?>
                                                <button
                                                    x-on:click="$dispatch('open-delete-modal', { id: <?php echo e($producto->id); ?>, nombre: '<?php echo e(addslashes($producto->descripcion)); ?>' })"
                                                    class="text-rose-500 hover:text-rose-600 cursor-pointer">
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <path
                                                            d="M13 15h2v6h-2zM17 15h2v6h-2zM20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>


                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productos->count() < 1): ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('no-products', get_defined_vars()); ?>wire:key="no-products">
                                <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-3 text-center">
                                    <div class="text-slate-500 dark:text-gray-400">No se encontraron productos</div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <?php echo e($productos->links()); ?>

    </div>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/productos/productos-index.blade.php ENDPATH**/ ?>