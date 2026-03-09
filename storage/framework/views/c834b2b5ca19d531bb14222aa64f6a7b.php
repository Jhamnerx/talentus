<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <div class="mb-8">
        <!-- Título y botón limpiar filtros -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cobros Recurrentes 💰</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($estado !== null || $filtroFecha || $filtroVencimiento || $clienteId || $search): ?>
                    <button wire:click="clearFilters" class="btn bg-red-500 hover:bg-red-600 text-white">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                        </svg>
                        <span class="ml-2">Limpiar</span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.cobros.create')): ?>
                    <a href="<?php echo e(route('admin.cobros.create')); ?>">
                        <button
                            class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Registrar</span>
                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Filtros organizados: Izquierda (filtros) y Derecha (búsqueda + cliente) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">

            <!-- IZQUIERDA: Filtros Dropdown (3 columnas) -->
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-3 gap-3">

                <!-- 1. Estado del Cobro -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Select state" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">Estado:</span>
                            <span class="text-xs font-medium">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($estado === 1): ?>
                                    ✅ Activo
                                <?php elseif($estado === 0): ?>
                                    ⏸️ Suspendido
                                <?php else: ?>
                                    Todos
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            Estado del Cobro</div>
                        <div class="mb-1">
                            <button wire:click='$set("estado",1)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($estado === 1 ? 'true' : 'false'); ?> && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">✅ Activo</span>
                            </button>
                            <button wire:click='$set("estado",0)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($estado === 0 ? 'true' : 'false'); ?> && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">⏸️ Suspendido</span>
                            </button>
                            <button wire:click='$set("estado",null)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($estado === null ? 'true' : 'false'); ?> && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4. Filtro Registros (cuándo se creó) -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Filtrar registros" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">📝:</span>
                            <span class="text-xs font-medium truncate">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtroFecha === 'registrados_7dias'): ?>
                                    7d
                                <?php elseif($filtroFecha === 'registrados_mes'): ?>
                                    Mes
                                <?php else: ?>
                                    Todos
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            📝 Registros (Fecha Creación)
                        </div>
                        <div class="mb-1">
                            <button wire:click="setFiltroFecha('registrados_7dias')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($filtroFecha === 'registrados_7dias' ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Últimos 7 días</span>
                            </button>
                            <button wire:click="setFiltroFecha('registrados_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($filtroFecha === 'registrados_mes' ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Este mes</span>
                            </button>
                            <button wire:click="setFiltroFecha(null)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($filtroFecha === null ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 3. Filtro Vencimientos -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Filtrar vencimientos" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">⏰:</span>
                            <span class="text-xs font-medium truncate">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filtroVencimiento === 'vencidos'): ?>
                                    ❌ Venc
                                <?php elseif($filtroVencimiento === 'vencen_7dias'): ?>
                                    🟡 7d
                                <?php elseif($filtroVencimiento === 'vencen_fin_mes'): ?>
                                    🔵 Fin
                                <?php elseif($filtroVencimiento === 'vencen_proximo_mes'): ?>
                                    🟣 Mes
                                <?php else: ?>
                                    Todos
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            ⏰ Vencimiento (Próxima Facturación)
                        </div>
                        <div class="mb-1">
                            <button wire:click="setFiltroVencimiento('vencidos')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-red-500"
                                    :class="!<?php echo e($filtroVencimiento === 'vencidos' ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🔴 Vencidos (ya pasaron)</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_7dias')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-amber-500"
                                    :class="!<?php echo e($filtroVencimiento === 'vencen_7dias' ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🟡 Vencen en 7 días</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_fin_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-blue-500"
                                    :class="!<?php echo e($filtroVencimiento === 'vencen_fin_mes' ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🔵 Vencen a fin de mes</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_proximo_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!<?php echo e($filtroVencimiento === 'vencen_proximo_mes' ? 'true' : 'false'); ?> &&
                                        'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🟣 Vencen en próximo mes</span>
                            </button>
                            <button wire:click="setFiltroVencimiento(null)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-gray-400"
                                    :class="!<?php echo e($filtroVencimiento === null ? 'true' : 'false'); ?> && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DERECHA: Búsqueda + Select Cliente (2 columnas) -->
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-3">

                <!-- Select Cliente con API -->
                <div>
                    <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Cliente','wire:model.live' => 'clienteId','placeholder' => 'Seleccionar cliente...','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.clientes.index')),'option-label' => 'razon_social','option-value' => 'id','clearable' => true,'option-description' => 'numero_documento']); ?>
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

                <!-- Búsqueda general -->
                <div>
                    <label for="action-search"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Búsqueda general
                    </label>
                    <div class="relative">
                        <input wire:model.live.debounce='search' id="action-search"
                            class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 w-full"
                            type="search" placeholder="Placa, contacto, periodo..." />
                        <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 group-hover:text-slate-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path
                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Per Page Selector con WireUI -->
        <div class="flex items-center gap-3 mt-5">
            <label for="perPage" class="text-sm text-gray-600 dark:text-gray-300">Mostrar:</label>
            <div class="w-24">
                <?php if (isset($component)) { $__componentOriginalb421b625325d6862bcafcfe35877042a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb421b625325d6862bcafcfe35877042a = $attributes; } ?>
<?php $component = WireUi\Components\Select\Native::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.native.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Native::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'perPage','id' => 'perPage']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb421b625325d6862bcafcfe35877042a)): ?>
<?php $attributes = $__attributesOriginalb421b625325d6862bcafcfe35877042a; ?>
<?php unset($__attributesOriginalb421b625325d6862bcafcfe35877042a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb421b625325d6862bcafcfe35877042a)): ?>
<?php $component = $__componentOriginalb421b625325d6862bcafcfe35877042a; ?>
<?php unset($__componentOriginalb421b625325d6862bcafcfe35877042a); ?>
<?php endif; ?>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-300">registros</span>
        </div>

        <!-- Tabla de Detalles Agrupados por Empresa -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mt-5">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Vehículos por cobrar
                    <span class="text-gray-400 dark:text-gray-500 font-medium"><?php echo e($detalles->total()); ?></span>
                </h2>
            </header>
            <div>
                <div class="overflow-x-auto min-h-screen">
                    <table class="table-auto w-full dark:text-gray-300">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Vehículo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Plan</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Periodo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Suscripción</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Días Rest.</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Estado</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm">
                            <?php
                                $currentCliente = null;
                                $currentCobroId = null;
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <?php
                                    $clienteNombre = $detalle->cobro->clientes->razon_social;
                                    $showClienteHeader = $currentCliente !== $clienteNombre;
                                    $showCobroHeader = $currentCobroId !== $detalle->cobros_id;
                                    $currentCliente = $clienteNombre;
                                    $currentCobroId = $detalle->cobros_id;

                                    // Datos de suscripción del vehículo (laravelcm/subscriptions)
                                    $subscription = $detalle->vehiculo?->planSubscriptions->first();
                                    $subCancelada = $subscription && $subscription->canceled_at !== null;
                                    $subActiva = $subscription && !$subCancelada && $subscription->active();
                                    $subEndsAt = $subscription?->ends_at;
                                    // Plan: prioridad suscripción > detalle
                                    $subPlan = $subscription?->plan;
                                    $planNombre = $subPlan
                                        ? (is_array($subPlan->name)
                                            ? $subPlan->name['es'] ?? ($subPlan->name['en'] ?? 'Plan')
                                            : $subPlan->name)
                                        : $detalle->plan_nombre;
                                    // $planMonto no se usa en la vista — el monto real se muestra via $detalle->monto_efectivo
                                    // Fecha de referencia: suscripción si existe, sino detalle->fecha
                                    $hoy = \Carbon\Carbon::now()->startOfDay();
                                    $fechaVencimiento = $subEndsAt
                                        ? \Carbon\Carbon::parse($subEndsAt)->startOfDay()
                                        : \Carbon\Carbon::parse($detalle->fecha)->startOfDay();
                                    $diasRestantes = $hoy->diffInDays($fechaVencimiento, false);

                                    // Determinar texto descriptivo para días restantes
                                    if ($diasRestantes < 0) {
                                        $diasTexto =
                                            abs($diasRestantes) .
                                            ' día' .
                                            (abs($diasRestantes) != 1 ? 's' : '') .
                                            ' atrasado';
                                    } elseif ($diasRestantes == 0) {
                                        $diasTexto = 'Hoy';
                                    } elseif ($diasRestantes == 1) {
                                        $diasTexto = 'Mañana';
                                    } else {
                                        $diasTexto = $diasRestantes . ' días';
                                    }

                                    // Determinar colores y estado según días restantes
                                    if ($subCancelada) {
                                        $bgColor = 'bg-gray-50 dark:bg-gray-900/20';
                                        $textColor = 'text-gray-500 dark:text-gray-400';
                                        $estadoTexto = 'CANCELADA';
                                    } elseif ($diasRestantes < 0) {
                                        $bgColor = 'bg-red-50 dark:bg-red-900/10';
                                        $textColor = 'text-red-700 dark:text-red-400';
                                        $estadoTexto = 'VENCIDO';
                                    } elseif ($diasRestantes <= 7) {
                                        $bgColor = 'bg-orange-50 dark:bg-orange-900/10';
                                        $textColor = 'text-orange-700 dark:text-orange-400';
                                        $estadoTexto = 'POR VENCER';
                                    } elseif ($diasRestantes <= 15) {
                                        $bgColor = 'bg-yellow-50 dark:bg-yellow-900/10';
                                        $textColor = 'text-yellow-700 dark:text-yellow-400';
                                        $estadoTexto = 'PRÓXIMO';
                                    } else {
                                        $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                        $textColor = 'text-green-700 dark:text-green-400';
                                        $estadoTexto = 'VIGENTE';
                                    }
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showClienteHeader): ?>
                                    <tr
                                        class="bg-indigo-100 dark:bg-indigo-900/40 border-t-2 border-indigo-200 dark:border-indigo-700">
                                        <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-2">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-bold text-sm text-indigo-900 dark:text-indigo-100">
                                                    <?php echo e($clienteNombre); ?>

                                                </span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle->cobro->clientes->contactos->isNotEmpty()): ?>
                                                    <span class="text-xs text-indigo-700 dark:text-indigo-300">
                                                        • <?php echo e($detalle->cobro->clientes->contactos->first()->nombre); ?>

                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCobroHeader || $showClienteHeader): ?>
                                    <?php
                                        $cobro = $detalle->cobro;
                                        $cobroMoneda = $cobro->divisa === 'USD' ? 'USD' : 'S/.';
                                        $cobroMonto = $detalle->monto_efectivo ?? 0;
                                        $cobroInicio = $detalle->fecha_inicio
                                            ? \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y')
                                            : ($cobro->created_at
                                                ? $cobro->created_at->format('d/m/Y')
                                                : '—');
                                        $cobroVcto = $detalle->fecha_vencimiento
                                            ? \Carbon\Carbon::parse($detalle->fecha_vencimiento)->format('d/m/Y')
                                            : '—';
                                        $cobroPeriodo = $detalle->periodo ?? '—';
                                        $cobroTipoPago = $cobro->tipo_pago ?? '—';
                                    ?>
                                    <tr
                                        class="bg-blue-50 dark:bg-blue-900/20 border-t border-blue-200 dark:border-blue-800">
                                        <td colspan="7" class="px-5 py-1.5">
                                            <div class="flex items-center justify-between gap-3 flex-wrap">

                                                
                                                <div class="flex items-center gap-2 flex-wrap text-xs">
                                                    <span
                                                        class="inline-flex items-center gap-1 font-bold text-blue-700 dark:text-blue-300">
                                                        🔵 Cobro #<?php echo e($cobro->id); ?>

                                                    </span>
                                                    <span class="text-blue-500 dark:text-blue-400">·</span>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cobroTipoPago === 'FACTURA'): ?>
                                                        <span
                                                            class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 font-semibold">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            FACTURA
                                                        </span>
                                                    <?php else: ?>
                                                        <span
                                                            class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-semibold">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                            </svg>
                                                            RECIBO
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($cobro->comentario)): ?>
                                                        <span class="text-blue-500 dark:text-blue-400">·</span>
                                                        <span
                                                            class="italic text-gray-500 dark:text-gray-400 truncate max-w-xs"
                                                            title="<?php echo e($cobro->comentario); ?>">
                                                            <?php echo e(Str::limit($cobro->comentario, 60)); ?>

                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                
                                                <div class="flex items-center gap-2 shrink-0">
                                                    <a href="<?php echo e(route('admin.cobros.edit', $cobro)); ?>"
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/50 dark:hover:bg-blue-900/70 dark:text-blue-300 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Editar cobro
                                                    </a>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <tr class="border-b border-gray-200 dark:border-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700/30 <?php echo e($bgColor); ?>"
                                    <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processElementKey('', get_defined_vars()); ?>wire:key='detalle-<?php echo e($detalle->id); ?>'>

                                    <!-- Vehículo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle->vehiculo): ?>
                                            <div class="font-bold <?php echo e($textColor); ?>">
                                                <?php echo e($detalle->vehiculo->placa); ?>

                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle->vehiculo->marca || $detalle->vehiculo->modelo): ?>
                                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                                    <?php echo e($detalle->vehiculo->marca); ?> <?php echo e($detalle->vehiculo->modelo); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-400 dark:text-gray-500">Sin vehículo</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <!-- Plan -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div
                                            class="flex items-center gap-1.5 font-medium text-gray-900 dark:text-gray-100">
                                            <?php echo e($detalle->cobro->divisa === 'USD' ? 'USD' : 'S/.'); ?>

                                            <?php echo e(number_format($detalle->monto_efectivo, 2)); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle->cobro->tipo_pago === 'FACTURA'): ?>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-blue-500 dark:text-blue-400 shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8" title="Factura — incluye IGV 18%">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            <?php else: ?>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8" title="Recibo — precio sin IGV">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e($planNombre); ?>

                                        </div>
                                    </td>

                                    <!-- Periodo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                            <?php echo e($detalle->periodo ?? '—'); ?>

                                        </span>
                                    </td>

                                    <!-- Suscripción (laravelcm/subscriptions) -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subscription && $subEndsAt): ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subCancelada): ?>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    <span
                                                        class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-semibold">
                                                        🚫 Cancelada
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                    <?php echo e(\Carbon\Carbon::parse($subEndsAt)->format('d/m/Y')); ?>

                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="text-xs <?php echo e($subActiva ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400'); ?>">
                                                    <?php echo e($subActiva ? '✅' : '❌'); ?>

                                                    <?php echo e(\Carbon\Carbon::parse($subEndsAt)->format('d/m/Y')); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php elseif($detalle->vehiculo): ?>
                                            
                                            <a href="<?php echo e(route('admin.cobros.edit', $detalle->cobro)); ?>"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-700 hover:bg-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:hover:bg-amber-900/60 transition-colors"
                                                title="Este detalle no tiene suscripción. Edita el cobro para actualizar las fechas.">
                                                Sin suscripción — Editar
                                            </a>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <!-- Días Restantes -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalle->estado == 1 && $diasRestantes >= 0): ?>
                                            <div class="font-bold <?php echo e($textColor); ?> text-xs">
                                                <?php echo e($diasTexto); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>

                                    <!-- Estado Badge -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold <?php echo e($textColor); ?> bg-white dark:bg-gray-900/50 border-2 border-current rounded">
                                            <?php echo e($estadoTexto); ?>

                                        </span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center gap-2">
                                            <a href="<?php echo e(route('admin.cobros.edit', $detalle->cobro)); ?>"
                                                class="text-gray-400 hover:text-blue-500" title="Editar cobro">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <div class="form-switch" x-data="{ checked: <?php echo e($detalle->estado ? 'true' : 'false'); ?> }">
                                                <input wire:click="cambiarEstado(<?php echo e($detalle->id); ?>)"
                                                    type="checkbox" id="switch<?php echo e($detalle->id); ?>" class="sr-only"
                                                    x-model="checked" />
                                                <label class="bg-gray-400 dark:bg-gray-700"
                                                    for="switch<?php echo e($detalle->id); ?>">
                                                    <span class="bg-white dark:bg-gray-300 shadow-sm"
                                                        aria-hidden="true"></span>
                                                    <span class="sr-only">Estado</span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detalles->count() < 1): ?>
                                <tr>
                                    <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                        <div class="text-gray-500 dark:text-gray-400">No hay registros</div>
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
            <?php echo e($detalles->links()); ?>

        </div>

    </div>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/cobros/index.blade.php ENDPATH**/ ?>