<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Vehiculos ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear-vehiculos-vehiculos')): ?>
                <button wire:click="openModalSave()" aria-controls="basic-modal"
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Añadir Vehiculo</span>
                </button>

                
            <?php endif; ?>

        </div>

    </div>

    <!-- Filters Bar -->
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="grid grid-cols-12 gap-4">

                <!-- Search -->
                <div class="col-span-12 sm:col-span-6 md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                    <div class="relative">
                        <input wire:model.live='search' class="form-input w-full pl-9" type="search"
                            placeholder="Placa, IMEI, Cliente..." />
                        <button class="absolute inset-0 right-auto group" type="button">
                            <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path
                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Cliente Filter -->
                <div class="col-span-12 sm:col-span-6 md:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Cliente','wire:model.live' => 'clientes_id','placeholder' => 'Todos los clientes','option-description' => 'numero_documento','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.clientes.index')),'option-label' => 'razon_social','option-value' => 'id']); ?>
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

                <!-- Marca Filter -->
                <div class="col-span-12 sm:col-span-6 md:col-span-4">
                    <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Marca','wire:model.live' => 'marca_filter','placeholder' => 'Todas las marcas']); ?>
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
<?php $component->withAttributes(['label' => 'Todas las marcas','value' => '']); ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($marca).'','value' => ''.e($marca).'']); ?>
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

            </div>

            <!-- Filter Actions -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700/60">
                <div class="flex items-center gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clientes_id || $marca_filter || $search): ?>
                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'clearFilters','flat' => true,'negative' => true,'sm' => true,'icon' => 'x-mark']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            Limpiar Filtros
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
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Date Range Filter -->
                    <div class="relative" x-data="{ open: false, selected: 4 }">
                        <button
                            class="btn justify-between min-w-44 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400"
                            @click.prevent="open = !open" :aria-expanded="open">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                </svg>
                                <span
                                    x-text="$refs.options && $refs.options.children[selected] && $refs.options.children[selected].children[1] ? $refs.options.children[selected].children[1].innerHTML : 'Seleccionar periodo'"></span>
                            </span>
                            <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                                height="7">
                                <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                            </svg>
                        </button>
                        <div class="z-10 absolute top-full right-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                            @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" x-cloak>
                            <div class="font-medium text-sm text-gray-600 dark:text-gray-300" x-ref="options">
                                <button wire:click="filter(1)" tabindex="0"
                                    class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                    :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 0 && 'invisible'" width="12" height="9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                    </svg>
                                    <span>Hoy</span>
                                </button>
                                <button wire:click="filter(7)" tabindex="0"
                                    class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                    :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 1 && 'invisible'" width="12" height="9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                    </svg>
                                    <span>Últimos 7 días</span>
                                </button>
                                <button wire:click="filter(30)" tabindex="0"
                                    class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                    :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 2 && 'invisible'" width="12" height="9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                    </svg>
                                    <span>Último Mes</span>
                                </button>
                                <button wire:click="filter(12)" tabindex="0"
                                    class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                    :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 3 && 'invisible'" width="12" height="9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                    </svg>
                                    <span>Últimos 12 Meses</span>
                                </button>
                                <button wire:click="filter(0)" tabindex="0"
                                    class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                    :class="selected === 4 && 'text-indigo-500'" @click="selected = 4;open = false">
                                    <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                        :class="selected !== 4 && 'invisible'" width="12" height="9">
                                        <path
                                            d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                    </svg>
                                    <span>Todos</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('exportar.vehiculos-vehiculos')): ?>
                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click.prevent' => 'exportVehiculos()','spinner' => 'exportVehiculos','label' => 'Exportar','positive' => true,'sm' => true,'icon' => 'arrow-down-tray']); ?>
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
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('importar-vehiculos-vehiculos')): ?>
                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openModalImport()','label' => 'Importar','info' => true,'sm' => true,'icon' => 'arrow-up-tray']); ?>
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
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="mb-4 sm:mb-0">
        <ul class="flex flex-wrap -m-1">
            <li class="m-1">
                <button
                    class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-xs bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-800 transition">Todas
                    <span class="ml-1 text-gray-400 dark:text-gray-500"><?php echo e($vehiculos->total()); ?></span></button>
            </li>
        </ul>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Vehiculos <span
                    class="text-gray-400 dark:text-gray-500 font-medium"><?php echo e($vehiculos->total()); ?></span>
            </h2>
        </header>
        <div>

            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full dark:text-gray-300">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                        <tr>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Placa</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Marca</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Datos</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left max-w-45">Cliente</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SIM#</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Dispositivos</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Suscripción</div>
                            </th>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['eliminar-vehiculos-vehiculo', 'editar-vehiculos-vehiculos'])): ?>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">Acciones</div>
                                </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        <!-- Row -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $vehiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('', get_defined_vars()); ?>wire:key='vehi-<?php echo e($vehiculo->id); ?>'>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-600"><?php echo e($vehiculo->placa); ?></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100"><?php echo e($vehiculo->marca); ?>

                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                        @mouseleave="open = false">
                                        <button
                                            class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800"
                                            aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                            @focusout="open = false" @click.prevent>
                                            <span class="mr-2">
                                                VER INFO
                                            </span>

                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                                viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </button>
                                        <div
                                            class="z-10 absolute top-3/4 left-1/2 transform -translate-x-1/2 h-[calc(100vh-64px)]">
                                            <div class="min-w-72 p-3 z-10 rounded-2xl mb-2 bg-slate-100 shadow-2xl shadow-gray-800 overflow-auto max-h-full overflow-y-auto"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div class="">
                                                    <div class="font-medium text-slate-800 mb-0.5 pb-2  text-base">
                                                        <b><?php echo e($vehiculo->placa); ?></b>
                                                    </div>
                                                    <div
                                                        class="relative overflow-y-auto overflow-x-auto shadow-md sm:rounded-lg">
                                                        <table
                                                            class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                                                            <thead
                                                                class="text-xs  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                <tr>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        DATO
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        VALOR
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="a overflow-y-auto">
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        MODELO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->modelo); ?>

                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        TIPO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->tipo); ?>

                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        AÑO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->year); ?>

                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        COLOR
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->color); ?>

                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        MOTOR
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->motor); ?>

                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        SERIE
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        <?php echo e($vehiculo->serie); ?>

                                                                    </td>

                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 max-w-45">
                                    <div class="font-medium text-sky-500 wrap-break-word">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->cliente): ?>
                                            <?php echo e($vehiculo->cliente->razon_social); ?>

                                        <?php else: ?>
                                            Sin Cliente Registrado
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->cliente): ?>
                                        <div class="font-sm text-gray-800 dark:text-gray-300">
                                            <p class="text-xs">
                                                <?php echo e($vehiculo->cliente->numero_documento); ?>

                                            </p>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">


                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->sim_card): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->sim_card->linea): ?>
                                            <div class="font-medium text-emerald-600">
                                                #<?php echo e($vehiculo->sim_card->linea->numero); ?> -
                                                <?php echo e($vehiculo->sim_card->linea->operador); ?>

                                            </div>
                                        <?php else: ?>
                                            <div class="font-medium text-red-200">
                                                LS # <?php echo e($vehiculo->sim_card->sim_card); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                        <div class="font-medium text-red-500">
                                            AS <?php echo e($vehiculo->old_sim_card); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                        @mouseleave="open = false">
                                        <button
                                            class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800"
                                            aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                            @focusout="open = false" @click.prevent>
                                            <span class="mr-2">
                                                DISPOSITIVOS
                                            </span>
                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                                viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </button>
                                        <div class="z-10 absolute top-3/4 left-1/2 transform -translate-x-1/2">
                                            <div class="min-w-72 p-3 z-10 rounded-2xl mb-2 bg-white dark:bg-gray-800 shadow-2xl overflow-auto max-h-100 overflow-y-auto"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div class="">
                                                    <div
                                                        class="font-medium text-gray-800 dark:text-gray-100 mb-0.5 pb-2 text-base">
                                                        <b>Dispositivos para <?php echo e($vehiculo->placa); ?></b>
                                                    </div>
                                                    <div
                                                        class="relative overflow-y-auto overflow-x-auto shadow-md sm:rounded-lg">
                                                        <table
                                                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                            <thead
                                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                <tr>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        DISPOSITIVO
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        IMEI
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        ESTADO
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->dispositivos->count() > 0): ?>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $vehiculo->dispositivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dispositivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                                        <tr
                                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 
                                                                        <?php echo e($dispositivo->is_principal ? 'bg-green-50 font-semibold' : ''); ?>">

                                                                            <td
                                                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                                <?php echo e($dispositivo->dispositivo->modelo->modelo ?? 'Sin modelo'); ?>

                                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dispositivo->is_principal): ?>
                                                                                    <span
                                                                                        class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                                        Principal
                                                                                    </span>
                                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            </td>

                                                                            <td class="px-6 py-4">
                                                                                <?php echo e($dispositivo->imei); ?>

                                                                            </td>

                                                                            <td class="px-6 py-4">
                                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dispositivo->fecha_desinstalacion): ?>
                                                                                    <span
                                                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                                        Desinstalado -
                                                                                        <?php echo e($dispositivo->fecha_desinstalacion->format('d-m-Y')); ?>

                                                                                    </span>
                                                                                <?php else: ?>
                                                                                    <span
                                                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                                        Activo
                                                                                    </span>
                                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            </td>

                                                                        </tr>
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                                <?php else: ?>
                                                                    <tr>
                                                                        <td colspan="3"
                                                                            class="px-6 py-4 text-center">
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->dispositivo_imei): ?>
                                                                                <?php echo e($vehiculo->dispositivo_imei); ?>

                                                                                <span
                                                                                    class="text-xs text-gray-500">(Dispositivo
                                                                                    antiguo)</span>
                                                                            <?php else: ?>
                                                                                No hay dispositivos registrados
                                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculo->dispositivoPrincipal): ?>
                                            <div class="font-medium text-emerald-600">
                                                <?php echo e($vehiculo->dispositivoPrincipal->dispositivo->modelo->modelo); ?>

                                                <span class="text-xs text-gray-500 dark:text-gray-400">Principal</span>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                IMEI: <?php echo e($vehiculo->dispositivoPrincipal->imei); ?>

                                            </div>
                                        <?php elseif($vehiculo->dispositivos->count() > 0): ?>
                                            <div class="font-medium text-gray-600 dark:text-gray-300">
                                                <?php echo e($vehiculo->dispositivos->first()->dispositivo->modelo->modelo); ?>

                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                IMEI: <?php echo e($vehiculo->dispositivos->first()->imei); ?>

                                            </div>
                                        <?php elseif($vehiculo->dispositivo_imei): ?>
                                            <div class="font-medium text-red-500">
                                                <?php echo e($vehiculo->dispositivo_imei); ?>

                                                <span class="text-xs">(Antiguo)</span>
                                            </div>
                                        <?php else: ?>
                                            <div class="font-medium text-red-500">
                                                Sin dispositivo
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>

                                
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                    <?php
                                        $subActiva = $vehiculo->planSubscriptions
                                            ->whereNull('canceled_at')
                                            ->filter(fn($s) => \Carbon\Carbon::parse($s->ends_at)->isFuture())
                                            ->sortByDesc('ends_at')
                                            ->first();
                                        $subVencida = !$subActiva && $vehiculo->planSubscriptions->isNotEmpty();
                                    ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subActiva): ?>
                                        <?php
                                            $dias = (int) \Carbon\Carbon::now()
                                                ->startOfDay()
                                                ->diffInDays(
                                                    \Carbon\Carbon::parse($subActiva->ends_at)->startOfDay(),
                                                    false,
                                                );
                                            if ($dias < 0) {
                                                $diasTexto =
                                                    abs($dias) . ' día' . (abs($dias) != 1 ? 's' : '') . ' atrasado';
                                                $ringColor = 'group-hover:ring-red-400';
                                                $bgColor = 'bg-red-100 dark:bg-red-900/40';
                                                $textColor = 'text-red-600 dark:text-red-400';
                                            } elseif ($dias == 0) {
                                                $diasTexto = 'Hoy';
                                                $ringColor = 'group-hover:ring-orange-400';
                                                $bgColor = 'bg-orange-100 dark:bg-orange-900/40';
                                                $textColor = 'text-orange-600 dark:text-orange-400';
                                            } elseif ($dias == 1) {
                                                $diasTexto = 'Mañana';
                                                $ringColor = 'group-hover:ring-orange-400';
                                                $bgColor = 'bg-orange-100 dark:bg-orange-900/40';
                                                $textColor = 'text-orange-600 dark:text-orange-400';
                                            } elseif ($dias <= 7) {
                                                $diasTexto = $dias . ' días';
                                                $ringColor = 'group-hover:ring-amber-400';
                                                $bgColor = 'bg-amber-100 dark:bg-amber-900/40';
                                                $textColor = 'text-amber-600 dark:text-amber-400';
                                            } elseif ($dias <= 15) {
                                                $diasTexto = $dias . ' días';
                                                $ringColor = 'group-hover:ring-yellow-400';
                                                $bgColor = 'bg-yellow-100 dark:bg-yellow-900/40';
                                                $textColor = 'text-yellow-600 dark:text-yellow-400';
                                            } else {
                                                $diasTexto = $dias . ' días';
                                                $ringColor = 'group-hover:ring-emerald-400';
                                                $bgColor = 'bg-emerald-100 dark:bg-emerald-900/40';
                                                $textColor = 'text-emerald-600 dark:text-emerald-400';
                                            }
                                        ?>
                                        <button wire:click="abrirModalSuscripcion(<?php echo e($vehiculo->id); ?>)"
                                            title="Activa — vence <?php echo e(\Carbon\Carbon::parse($subActiva->ends_at)->format('d/m/Y')); ?>"
                                            class="inline-flex flex-col items-center gap-0.5 group">
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full <?php echo e($bgColor); ?> group-hover:ring-2 <?php echo e($ringColor); ?> transition">
                                                <svg class="w-4 h-4 <?php echo e($textColor); ?>" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            <span class="text-xs font-medium <?php echo e($textColor); ?>">
                                                <?php echo e($diasTexto); ?>

                                            </span>
                                        </button>
                                    <?php elseif($subVencida): ?>
                                        <button wire:click="abrirModalSuscripcion(<?php echo e($vehiculo->id); ?>)"
                                            title="Suscripción vencida"
                                            class="inline-flex flex-col items-center gap-0.5 group">
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                                bg-red-100 dark:bg-red-900/40
                                                group-hover:ring-2 group-hover:ring-red-400 transition">
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            <span
                                                class="text-xs font-medium text-red-600 dark:text-red-400">Vencida</span>
                                        </button>
                                    <?php else: ?>
                                        <button wire:click="abrirModalSuscripcion(<?php echo e($vehiculo->id); ?>)"
                                            title="Sin suscripción"
                                            class="inline-flex flex-col items-center gap-0.5 group">
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                                bg-gray-100 dark:bg-gray-700
                                                group-hover:ring-2 group-hover:ring-gray-400 transition">
                                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            </span>
                                            <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Sin
                                                plan</span>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['eliminar-vehiculos-vehiculo', 'editar-vehiculos-vehiculos',
                                    'show-vehiculos-vehiculos'])): ?>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="relative inline-flex" x-data="{ open: false }">
                                            <div class="relative inline-block h-full text-left">
                                                <button
                                                    class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 rounded-full"
                                                    :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400': open }"
                                                    aria-haspopup="true" @click.prevent="open = !open"
                                                    :aria-expanded="open">
                                                    <span class="sr-only">Menu</span>
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <circle cx="16" cy="16" r="2" />
                                                        <circle cx="10" cy="16" r="2" />
                                                        <circle cx="22" cy="16" r="2" />
                                                    </svg>
                                                </button>
                                                <div class="origin-top-right z-10 absolute transform -translate-x-3/4 top-full left-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700/60 focus:outline-none"
                                                    @click.outside="open = false" @keydown.escape.window="open = false"
                                                    x-show="open"
                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-out duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" x-cloak>
                                                    <ul>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show-vehiculos-vehiculos')): ?>
                                                            <li>
                                                                <a href="<?php echo e(route('admin.vehiculos.show', $vehiculo)); ?>"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-29"
                                                                    role="menuitem" tabindex="-1"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                        </path>
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                        </path>
                                                                    </svg> Ver
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar-vehiculos-vehiculos')): ?>
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="openModalEdit(<?php echo e($vehiculo->id); ?>)"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-27"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                        </path>
                                                                    </svg> Editar

                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar-vehiculos-vehiculo')): ?>
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="deleteVehiculo(<?php echo e($vehiculo->id); ?>)"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    Eliminar
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="suspendVehiculo(<?php echo e($vehiculo->id); ?>)"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg class="h-5 w-5 mr-3 text-gray-500 group-hover:text-rose-700"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 64 64">
                                                                        <g stroke-linecap="round" stroke-width="2"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-linejoin="round" class="nc-icon-wrapper">
                                                                            <line x1="32" y1="3"
                                                                                x2="32" y2="12"></line>
                                                                            <line x1="61" y1="32"
                                                                                x2="52" y2="32"></line>
                                                                            <line x1="32" y1="61"
                                                                                x2="32" y2="52"></line>
                                                                            <line x1="3" y1="32"
                                                                                x2="12" y2="32"></line>
                                                                            <polyline points="20 16 32 32 44 32">
                                                                            </polyline>
                                                                            <circle cx="32" cy="32" r="29">
                                                                            </circle>
                                                                        </g>
                                                                    </svg>
                                                                    Suspender
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="createMantenimiento(<?php echo e($vehiculo->id); ?>)"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg class="h-5 w-5 mr-3 text-gray-500 group-hover:text-blue-700"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 64 64">
                                                                        <g stroke-linecap="round" stroke-width="2"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-linejoin="round" class="nc-icon-wrapper">
                                                                            <path
                                                                                d="M47.75,37.458,56.352,45a8.034,8.034,0,0,1,.575,11.347c-.091.1-.184.2-.28.3h0a8.035,8.035,0,0,1-11.363,0c-.1-.1-.189-.2-.28-.3L35.667,46.167">
                                                                            </path>
                                                                            <polyline data-cap="butt"
                                                                                points="29.439 25.439 20 16 20 12 13 5 5 13 12 20 16 20 25.234 29.234">
                                                                            </polyline>
                                                                            <path
                                                                                d="M58.376,14.5,51,21.879l-8.872-8.872L49.5,5.629a15.142,15.142,0,0,0-5.266-.586,13.9,13.9,0,0,0-12.7,12.7,15.124,15.124,0,0,0,.588,5.271L6.283,46.344a3.89,3.89,0,0,0-.277,5.495c.044.049.089.1.135.142l5.882,5.882a3.891,3.891,0,0,0,5.5-.009c.044-.045.088-.09.13-.137L41,31.881a15.127,15.127,0,0,0,5.272.588,13.9,13.9,0,0,0,12.7-12.7A15.145,15.145,0,0,0,58.376,14.5Z">
                                                                            </path>
                                                                        </g>
                                                                    </svg>
                                                                    Registrar Mantenimiento
                                                                </a>
                                                            </li>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                    </ul>


                                                </div>
                                            </div>

                                        </div>

                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehiculos->count() < 1): ?>
                            <tr>
                                <td colspan="10"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($vehiculos->links()); ?>

        </div>
    </div>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.vehiculos.modal-ver-suscripcion', []);

$key = null;
$__componentSlots = [];

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1312232421-0', $key);

$__html = app('livewire')->mount($__name, $__params, $key, $__componentSlots);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/vehiculos/vehiculos-index.blade.php ENDPATH**/ ?>