<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Header con estadísticas -->
    <div class="mb-8">
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Notificaciones de Cobro 🔔
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Cobros próximos a facturar generados automáticamente
                </p>
            </div>

        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <!-- Pendientes -->
            <div class="bg-linear-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Pendientes</p>
                        <p class="text-white text-3xl font-bold mt-1"><?php echo e($stats['pendientes']); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Vencidos -->
            <div class="bg-linear-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Vencidos</p>
                        <p class="text-white text-3xl font-bold mt-1"><?php echo e($stats['vencidos']); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Para Hoy -->
            <div class="bg-linear-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Para Hoy</p>
                        <p class="text-white text-3xl font-bold mt-1"><?php echo e($stats['hoy']); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monto Pendiente PEN -->
            <div class="bg-linear-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Pendiente (S/.)</p>
                        <p class="text-white text-2xl font-bold mt-1">S/.
                            <?php echo e(number_format($stats['monto_pendiente_pen'], 2)); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monto Pendiente USD -->
            <div class="bg-linear-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-teal-100 text-sm font-medium">Pendiente (USD)</p>
                        <p class="text-white text-2xl font-bold mt-1">USD
                            <?php echo e(number_format($stats['monto_pendiente_usd'], 2)); ?></p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros compactos -->
        <div class="grid grid-cols-12 gap-2 items-center">

            <!-- Búsqueda -->
            <div class="col-span-12 sm:col-span-4 relative">
                <input wire:model.live.debounce="search" type="search"
                    class="form-input pl-8 py-1.5 text-sm w-full dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    placeholder="Cliente, placa..." />
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none fill-current"
                    viewBox="0 0 16 16">
                    <path
                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                    <path
                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                </svg>
            </div>

            <!-- Cliente -->
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
<?php $component->withAttributes(['wire:model.live' => 'clienteId','placeholder' => 'Todos los clientes','sm' => true]); ?>
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
<?php $component->withAttributes(['label' => 'Todos los clientes','value' => '']); ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($cliente->razon_social).'','value' => ''.e($cliente->id).'']); ?>
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
            </div>

            <!-- Estado -->
            <div class="col-span-6 sm:col-span-2">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'estado','placeholder' => 'Estado','sm' => true]); ?>
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
<?php $component->withAttributes(['label' => 'Todos','value' => '']); ?>
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
<?php $component->withAttributes(['label' => '⏳ Pendiente','value' => 'PENDIENTE']); ?>
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
<?php $component->withAttributes(['label' => '📄 Facturado','value' => 'FACTURADO']); ?>
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
<?php $component->withAttributes(['label' => '✅ Pagado','value' => 'PAGADO']); ?>
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
<?php $component->withAttributes(['label' => '❌ Cancelado','value' => 'CANCELADO']); ?>
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

            <!-- Vencimiento -->
            <div class="col-span-6 sm:col-span-2">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'filtroVencimiento','placeholder' => 'Vencimiento','sm' => true]); ?>
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
<?php $component->withAttributes(['label' => 'Todo','value' => '']); ?>
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
<?php $component->withAttributes(['label' => '🔴 Vencidos','value' => 'vencidos']); ?>
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
<?php $component->withAttributes(['label' => '📅 Hoy','value' => 'hoy']); ?>
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
<?php $component->withAttributes(['label' => '🟡 7 días','value' => '7dias']); ?>
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
<?php $component->withAttributes(['label' => '🟢 15 días','value' => '15dias']); ?>
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

            <!-- Per Page + Limpiar -->
            <div class="col-span-12 sm:col-span-1 flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'perPage','sm' => true,'clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
<?php $component->withAttributes(['label' => '10','value' => '10']); ?>
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
<?php $component->withAttributes(['label' => '15','value' => '15']); ?>
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
<?php $component->withAttributes(['label' => '25','value' => '25']); ?>
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
<?php $component->withAttributes(['label' => '50','value' => '50']); ?>
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

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $clienteId || $estado || $filtroVencimiento): ?>
                    <button wire:click="clearFilters" title="Limpiar filtros"
                        class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-100 hover:bg-rose-200 dark:bg-rose-900/40 dark:hover:bg-rose-900/60 text-rose-600 dark:text-rose-400 transition">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                        </svg>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Tabla de notificaciones -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto min-h-screen">
            <table class="table-auto w-full dark:text-gray-300">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vencimiento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Cliente</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vehículo</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Descripción</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right">Monto</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Documento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('notif-{{ $notificacion->id }}', get_defined_vars()); ?>wire:key="notif-<?php echo e($notificacion->id); ?>"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <!-- Estado -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->estado === 'PENDIENTE'): ?>
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 rounded-full">
                                        ⏳ Pendiente
                                    </span>
                                <?php elseif($notificacion->estado === 'FACTURADO'): ?>
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 rounded-full">
                                        📄 Facturado
                                    </span>
                                <?php elseif($notificacion->estado === 'PAGADO'): ?>
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-full">
                                        ✅ Pagado
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300 rounded-full">
                                        ❌ Cancelado
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <!-- Vencimiento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($notificacion->fecha_vencimiento->format('d/m/Y')); ?>

                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($notificacion->estado, ['PENDIENTE', 'FACTURADO'])): ?>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->fecha_vencimiento->isToday()): ?>
                                            Hoy
                                        <?php elseif($notificacion->fecha_vencimiento->isPast()): ?>
                                            🔴 Vencido hace <?php echo e($notificacion->fecha_vencimiento->diffForHumans()); ?>

                                        <?php else: ?>
                                            Vence <?php echo e($notificacion->fecha_vencimiento->diffForHumans()); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <!-- Cliente -->
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e($notificacion->cliente->razon_social); ?>

                                </div>
                            </td>

                            <!-- Vehículo -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->vehiculo): ?>
                                    <span
                                        class="px-2 py-1 text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded">
                                        <?php echo e($notificacion->vehiculo->placa); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Sin vehículo</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <!-- Descripción -->
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                    <?php echo e($notificacion->descripcion); ?>

                                </div>
                            </td>

                            <!-- Monto -->
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    <?php echo e($notificacion->moneda); ?> <?php echo e(number_format($notificacion->monto, 2)); ?>

                                </span>
                            </td>

                            <!-- Documento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->venta): ?>
                                    <a target="_blank"
                                        href="<?php echo e(route('facturacion.ver.pdf', $notificacion->venta)); ?>"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Venta
                                        #<?php echo e($notificacion->venta->serie_correlativo ?? $notificacion->venta->id); ?>

                                    </a>
                                <?php elseif($notificacion->recibo): ?>
                                    <a target="_blank" href="<?php echo e(route('admin.pdf.recibo', $notificacion->recibo)); ?>"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Recibo #<?php echo e($notificacion->recibo->serie_numero ?? $notificacion->recibo->id); ?>

                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Sin documento</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <!-- Acciones -->
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->estado === 'PENDIENTE'): ?>
                                    <?php if (isset($component)) { $__componentOriginal18750b693f5654ce36c0da9097c948ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18750b693f5654ce36c0da9097c948ab = $attributes; } ?>
<?php $component = WireUi\Components\Dropdown\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Dropdown\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <?php if (isset($component)) { $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $attributes; } ?>
<?php $component = WireUi\Components\Dropdown\Item::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Dropdown\Item::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'currency-dollar','label' => 'Registrar pago','wire:click.prevent' => 'abrirModalPago('.e($notificacion->id).')']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $attributes = $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $component = $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $attributes; } ?>
<?php $component = WireUi\Components\Dropdown\Item::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Dropdown\Item::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'document-text','label' => 'Emitir documento','wire:click.prevent' => 'redirectToFacturar('.e($notificacion->id).')']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $attributes = $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $component = $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13 = $attributes; } ?>
<?php $component = WireUi\Components\Dropdown\Item::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown.item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Dropdown\Item::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'x-circle','label' => 'Cancelar','wire:click.prevent' => 'cancelar('.e($notificacion->id).')']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $attributes = $__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__attributesOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13)): ?>
<?php $component = $__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13; ?>
<?php unset($__componentOriginal0e0c733fc4b7d84791e38fa8e7a5bb13); ?>
<?php endif; ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18750b693f5654ce36c0da9097c948ab)): ?>
<?php $attributes = $__attributesOriginal18750b693f5654ce36c0da9097c948ab; ?>
<?php unset($__attributesOriginal18750b693f5654ce36c0da9097c948ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18750b693f5654ce36c0da9097c948ab)): ?>
<?php $component = $__componentOriginal18750b693f5654ce36c0da9097c948ab; ?>
<?php unset($__componentOriginal18750b693f5654ce36c0da9097c948ab); ?>
<?php endif; ?>
                                <?php elseif($notificacion->estado === 'FACTURADO'): ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificacion->venta): ?>
                                        <a target="_blank"
                                            href="<?php echo e(route('facturacion.ver.pdf', $notificacion->venta)); ?>"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition">
                                            📄 Ver documento
                                        </a>
                                    <?php elseif($notificacion->recibo): ?>
                                        <a target="_blank"
                                            href="<?php echo e(route('admin.pdf.recibo', $notificacion->recibo)); ?>"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition">
                                            📄 Ver documento
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($notificacion->estado === 'PAGADO'): ?>
                                    
                                    <?php
                                        $paymentable = $notificacion->venta ?? $notificacion->recibo;
                                        $payment = $paymentable?->payments->first();
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment): ?>
                                        <div class="relative inline-flex justify-center" x-data="{ open: false }"
                                            @mouseenter="open = true" @mouseleave="open = false">
                                            <button
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-900/60 transition">
                                                ✅ Ver pago
                                            </button>
                                            <div class="absolute top-full mt-2 left-1/2 -translate-x-1/2 z-20"
                                                x-show="open" x-transition:enter="transition ease-out duration-150"
                                                x-transition:enter-start="opacity-0 translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div
                                                    class="min-w-40 p-3 rounded-xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-200 dark:border-gray-700 text-left space-y-1.5">
                                                    <div
                                                        class="text-xs font-semibold text-gray-800 dark:text-gray-100">
                                                        <?php echo e($payment->paymentMethod->description ?? 'Pago'); ?>

                                                    </div>
                                                    <div
                                                        class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                        <?php echo e($payment->divisa); ?> <?php echo e(number_format($payment->monto, 2)); ?>

                                                    </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->fecha): ?>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                                            <?php echo e(\Carbon\Carbon::parse($payment->fecha)->format('d/m/Y')); ?>

                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->numero_operacion): ?>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                                            Op: <?php echo e($payment->numero_operacion); ?>

                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Pagado</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="font-medium">No hay notificaciones con los filtros aplicados</p>
                                <p class="text-sm mt-1">Intenta cambiar los filtros o crear nuevos cobros</p>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notificaciones->hasPages()): ?>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700/60">
                <?php echo e($notificaciones->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'REGISTRAR PAGO','wire:model.live' => 'modalPago','max-width' => '2xl','blur' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


        <form autocomplete="off">
            <div class="px-4 py-4 grid grid-cols-12 gap-4">

                
                <div class="col-span-12">
                    <div class="flex items-center justify-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Modo:</span>
                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['primary' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pago_mode === 'create'),'flat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pago_mode !== 'create'),'label' => 'Nuevo Pago','wire:click' => '$set(\'pago_mode\', \'create\')','sm' => true]); ?>
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
<?php $component->withAttributes(['primary' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pago_mode === 'associate'),'flat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pago_mode !== 'associate'),'label' => 'Asociar Existente','wire:click' => '$set(\'pago_mode\', \'associate\')','sm' => true]); ?>
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
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pago_mode === 'associate'): ?>

                    
                    <div class="col-span-12">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'pago_existing_id','label' => 'Selecciona el Pago a Asociar','placeholder' => 'Busca un pago existente...']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pago_existing_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($ep['label']).'','value' => ''.e($ep['id']).'']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'No hay pagos disponibles para asociar','value' => '','disabled' => true]); ?>
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
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pago_existing_list) === 0): ?>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                No hay pagos sin cobro asociado disponibles para este cliente.
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div class="col-span-12 sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Número: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model.live="pago_numero" disabled
                            class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                    </div>

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'pago_tipo_pago','label' => 'Tipo Pago','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                            ['value' => 'FACTURA', 'label' => 'FACTURA'],
                            ['value' => 'RECIBO', 'label' => 'RECIBO'],
                        ]),'option-value' => 'value','option-label' => 'label','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'pago_paymentable_id','label' => ''.e($pago_titulo_doc).'','placeholder' => 'Selecciona']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pago_documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($doc['text']).'','value' => ''.e($doc['id']).'']); ?>
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
                    </div>

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Método de Pago','wire:model.live' => 'pago_payment_method_id','placeholder' => 'Seleccione un método','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($paymentMethods),'option-label' => 'description','option-value' => 'id']); ?>
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

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Destino del Pago','wire:model.defer' => 'pago_payment_destination_id','placeholder' => 'Seleccione destino']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->paymentDestinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($dest['description']).'','value' => ''.e($dest['id']).'']); ?>
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
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pago_showBankAccountSelector): ?>
                        <div class="col-span-12 sm:col-span-6">
                            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Cuenta Bancaria','wire:model.defer' => 'pago_bank_account_id','placeholder' => 'Seleccione cuenta']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($account->description ?? $account->number).'','value' => ''.e($account->id).'']); ?>
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
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="col-span-6 sm:col-span-3">
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'pago_divisa','label' => 'Divisa','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                            ['value' => 'PEN', 'label' => 'PEN (Soles)'],
                            ['value' => 'USD', 'label' => 'USD (Dólares)'],
                        ]),'option-value' => 'value','option-label' => 'label','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

                    
                    <div class="col-span-6 sm:col-span-3">
                        <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Monto','wire:model.defer' => 'pago_monto','thousands' => ',','decimal' => '.']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b0811533b7e6484d46a99f1515e2054)): ?>
<?php $attributes = $__attributesOriginal5b0811533b7e6484d46a99f1515e2054; ?>
<?php unset($__attributesOriginal5b0811533b7e6484d46a99f1515e2054); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b0811533b7e6484d46a99f1515e2054)): ?>
<?php $component = $__componentOriginal5b0811533b7e6484d46a99f1515e2054; ?>
<?php unset($__componentOriginal5b0811533b7e6484d46a99f1515e2054); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha','wire:model.defer' => 'pago_fecha','without-time' => true,'parse-format' => 'YYYY-MM-DD']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12)): ?>
<?php $attributes = $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12; ?>
<?php unset($__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12)): ?>
<?php $component = $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12; ?>
<?php unset($__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="col-span-12 sm:col-span-6">
                        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Número de operación','wire:model.defer' => 'pago_numero_operacion','placeholder' => '45474001']); ?>
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

                    
                    <div class="col-span-12">
                        <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nota','wire:model.defer' => 'pago_nota','placeholder' => 'Observaciones opcionales...','rows' => '3']); ?>
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
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 

            </div>
        </form>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex justify-end gap-x-4">
                <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['flat' => true,'label' => 'Cerrar','wire:click' => 'cerrarModalPago']); ?>
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
<?php $component->withAttributes(['primary' => true,'label' => 'Guardar','wire:click' => 'confirmarPago','wire:loading.attr' => 'disabled','wire:target' => 'confirmarPago']); ?>
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

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/cobros/notificaciones.blade.php ENDPATH**/ ?>