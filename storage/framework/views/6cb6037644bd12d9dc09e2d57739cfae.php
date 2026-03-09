<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-gray-100 font-bold">Actas ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 dark:placeholder-gray-500"
                    type="search" placeholder="Buscar Actas" />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 group-hover:text-slate-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            <!-- Filtro Vehículo -->
            <div class="w-48">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'vehiculoId','placeholder' => 'Vehículo...','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.vehiculos.index')),'option-label' => 'placa','option-value' => 'id','option-description' => 'option_description','clearable' => true]); ?>
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

            <!-- Filtro Estado -->
            <div class="w-36">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'estadoFiltro','placeholder' => 'Estado...','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['value' => '1', 'label' => 'Aceptados'], ['value' => '0', 'label' => 'Anulados']]),'option-label' => 'label','option-value' => 'value','clearable' => true]); ?>
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

            <!-- Filtro Vigencia -->
            <div class="w-36">
                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'vigenciaFiltro','placeholder' => 'Vigencia...','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    ['value' => 'vigente', 'label' => '✅ Vigentes'],
                    ['value' => 'vencida', 'label' => '❌ Vencidas'],
                ]),'option-label' => 'label','option-value' => 'value','clearable' => true]); ?>
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

            <!-- Create invoice button -->

            <button wire:click.prevent="openModalSave()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Emitir Acta</span>
            </button>


        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side -->
        <div class="mb-4 sm:mb-0">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">Todas
                        <span class="ml-1 text-indigo-200"><?php echo e($actas->total()); ?></span></button>
                </li>
            </ul>
        </div>



        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Eliminar button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> Items Seleccionados</div>
                    <button
                        class="btn bg-white dark:bg-gray-800 border-slate-200 dark:border-gray-700/60 hover:border-slate-300 dark:hover:border-gray-600 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700/60 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-gray-100">Actas <span
                    class="text-slate-400 dark:text-gray-500 font-medium"><?php echo e($actas->total()); ?></span>
            </h2>
        </header>
        <div>

            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20 border-t border-b border-slate-200 dark:border-gray-700/60">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Codigo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Descargar</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vehiculo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Instalación</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Inicio</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Fin</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Caracteristicas</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Estado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vigencia</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700/60 dark:text-gray-300">
                        <!-- Row -->

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $actas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('', get_defined_vars()); ?>wire:key='acta-<?php echo e($acta->id); ?>'
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/30 <?php echo e($acta->estado == 0 ? 'bg-red-50 dark:bg-red-900/10 opacity-75' : ''); ?>">
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-sky-500">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$acta->codigo == null): ?>
                                            <?php echo e($acta->codigo); ?>

                                        <?php else: ?>
                                            <?php echo e($acta->ciudades->prefijo . $acta->numero); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1">

                                        <a target="_blank"
                                            href="<?php echo e(route('admin.pdf.actas', ['acta' => $acta, 'vehiculo' => $acta->vehiculo])); ?>">
                                            <button class="text-blue-400 hover:text-blue-600 rounded-full">
                                                <span class="sr-only">Descargar</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <path
                                                        d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-gray-100">
                                        <?php echo e($acta->vehiculo->placa); ?></div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-gray-100">
                                        <?php echo e($acta->fecha_instalacion ? $acta->fecha_instalacion->format('d-m-Y') : ''); ?>

                                    </div>
                                </td>
                                <td
                                    class="px-2
                                            first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-gray-100">
                                        <?php echo e($acta->inicio_cobertura->format('d-m-Y')); ?></div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-gray-100">
                                        <?php echo e($acta->fin_cobertura->format('d-m-Y')); ?></div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div><?php echo e($acta->fecha); ?></div>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 w-48">
                                    <div>
                                        <div class="m-3 w-48">
                                            <div class="flex items-center mt-2" x-data="{ checked: <?php echo e($acta->sello ? 'true' : 'false'); ?> }">
                                                <span class="text-sm mr-3">Sello: </span>
                                                <div class="form-switch">
                                                    <input wire:click="toggleSello(<?php echo e($acta->id); ?>)"
                                                        type="checkbox" id="switch-s<?php echo e($acta->id); ?>"
                                                        class="sr-only" x-model="checked" />
                                                    <label class="bg-slate-400 dark:bg-gray-600"
                                                        for="switch-s<?php echo e($acta->id); ?>">
                                                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                        <span class="sr-only">Estado</span>
                                                    </label>
                                                </div>
                                                <div class="text-sm text-slate-400 dark:text-gray-500 italic ml-2"
                                                    x-text="checked ? 'ON' : 'OFF'"></div>
                                            </div>
                                            <div class="flex items-center mt-2" x-data="{ checked: <?php echo e($acta->fondo ? 'true' : 'false'); ?> }">
                                                <span class="text-sm mr-3">Fondo: </span>
                                                <div class="form-switch">
                                                    <input wire:click="toggleFondo(<?php echo e($acta->id); ?>)"
                                                        type="checkbox" id="switch-f<?php echo e($acta->id); ?>"
                                                        class="sr-only" x-model="checked" />
                                                    <label class="bg-slate-400 dark:bg-gray-600"
                                                        for="switch-f<?php echo e($acta->id); ?>">
                                                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                        <span class="sr-only">Estado</span>
                                                    </label>
                                                </div>
                                                <div class="text-sm text-slate-400 dark:text-gray-500 italic ml-2"
                                                    x-text="checked ? 'ON' : 'OFF'"></div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>
                                        <div class="m-3 ">
                                            <div class="flex items-center mt-2" x-data="{ checked: <?php echo e($acta->estado ? 'true' : 'false'); ?> }">
                                                <div class="form-switch">
                                                    <input wire:click="toggleStatus(<?php echo e($acta->id); ?>)"
                                                        type="checkbox" id="switch-e<?php echo e($acta->id); ?>"
                                                        class="sr-only" x-model="checked" />
                                                    <label class="bg-slate-400 dark:bg-gray-600"
                                                        for="switch-e<?php echo e($acta->id); ?>">
                                                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                        <span class="sr-only">Estado</span>
                                                    </label>
                                                </div>
                                                <div class="text-sm italic ml-2 font-semibold"
                                                    :class="checked ? 'text-green-600 dark:text-green-400' :
                                                        'text-red-500 dark:text-red-400'"
                                                    x-text="checked ? 'Aceptado' : 'Anulado'"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$acta->estado): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            🚫 Anulada
                                        </span>
                                    <?php elseif($acta->estaVencida()): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400">
                                            ❌ Vencida
                                        </span>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                            <?php echo e($acta->fin_cobertura->format('d-m-Y')); ?>

                                        </div>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            ✅ Vigente
                                        </span>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                            hasta <?php echo e($acta->fin_cobertura->format('d-m-Y')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <div class="relative inline-block h-full text-left">
                                            <button
                                                class="text-slate-400 dark:text-gray-500 hover:text-slate-500 dark:hover:text-gray-400 rounded-full"
                                                :class="{ 'bg-slate-100 dark:bg-gray-700 text-slate-500 dark:text-gray-400': open }"
                                                aria-haspopup="true" @click.prevent="open = !open"
                                                :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>
                                            <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 dark:ring-gray-700 divide-y divide-gray-100 dark:divide-gray-700/60 focus:outline-none"
                                                @click.outside="open = false" @keydown.escape.window="open = false"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>

                                                <ul>
                                                    <li>

                                                        <a href="javascript: void(0)"
                                                            wire:click.prevent="openModalEdit(<?php echo e($acta->id); ?>)"
                                                            class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal hover:bg-gray-50 dark:hover:bg-gray-700/50"
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
                                                    <li>

                                                        <button type="submit"
                                                            wire:click.prevent="openModalDelete(<?php echo e($acta->id); ?>)"
                                                            class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal hover:bg-gray-50 dark:hover:bg-gray-700/50 w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Eliminar
                                                        </button>

                                                    </li>
                                                    <li>
                                                        <a href="javascript: void(0)"
                                                            wire:click="modalOpenSend(<?php echo e($acta->id); ?>)"
                                                            class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal hover:bg-gray-50 dark:hover:bg-gray-700/50"
                                                            disabled="false" id="headlessui-menu-item-32"
                                                            role="menuitem" tabindex="-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 mr-3 text-gray-400 group-hover:text-cyan-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                                </path>
                                                            </svg> Enviar
                                                        </a>
                                                    </li>

                                                </ul>


                                            </div>
                                        </div>

                                    </div>

                                </td>

                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($actas->count() < 1): ?>
                            <td colspan="11" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                <div class="text-center text-gray-500 dark:text-gray-400">No hay Registros</div>
                            </td>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        <?php echo e($actas->links()); ?>


    </div>


</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/certificados/actas/actas-index.blade.php ENDPATH**/ ?>