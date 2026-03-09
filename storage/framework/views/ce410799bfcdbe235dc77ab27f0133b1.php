<div>
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300 dark:border-gray-600">
        <!-- Botón Atrás: detecta contexto cobros -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cobro_redirect_back): ?>
            <a href="<?php echo e($cobro_redirect_back); ?>">
                <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                    </svg>
                    <span class="hidden xs:block ml-2">Volver al Cobro</span>
                </button>
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('admin.ventas.index')); ?>">
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                    </svg>
                    <span class="hidden xs:block ml-2">Atras</span>
                </button>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="mt-2 md:mt-0">
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">EMITIR
                <?php echo e(strtoupper($comprobante_slug == 'nota-venta' ? 'NOTA DE VENTA' : $comprobante_slug)); ?></h4>
            <ul aria-label="current Status"
                class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            </ul>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cobro_id): ?>
        <div class="container px-10 mx-auto mb-4">
            <div
                class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg p-4 flex items-center gap-3">
                <span class="text-2xl">📋</span>
                <div>
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                        Emitiendo desde Módulo de Cobros
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        Al guardar, el estado de facturación se actualizará automáticamente y regresarás al detalle del
                        cobro.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <!-- Code block ends -->
    <div class="p-2 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-2 bg-slate-100 dark:bg-gray-700 sm:p-2">
            <div class="grid grid-cols-12 gap-2">
                
                <div class="col-span-12 md:col-span-9">
                    
                    <div
                        class="grid grid-cols-12 gap-2 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        
                        <div class="col-span-12 lg:col-span-2">
                            <div>
                                <img src="<?php echo e(Storage::url($plantilla->logo)); ?>">

                            </div>
                        </div>

                        
                        <div
                            class="col-span-12 lg:col-span-4 xl:col-span-6 pl-6 self-center overflow-hidden text-ellipsis">
                            <div class="mb-0 text-gray-800 dark:text-gray-200" style="line-height: initial;">
                                <span class="font-bold">
                                    <?php echo e($plantilla->razon_social); ?>

                                </span>
                                <br>

                                <span><?php echo e($plantilla->correo); ?></span>
                            </div>
                        </div>

                        
                        <div class="col-span-12 lg:col-span-6 xl:col-span-4 self-end">

                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-6">
                                    <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fec. Emision:','id' => 'fecha_emision','name' => 'fecha_emision','wire:model.live' => 'fecha_emision','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->subDays(2)),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()),'without-time' => true,'parse-format' => 'YYYY-MM-DD','display-format' => 'DD-MM-YYYY','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

                                <div class="col-span-6">
                                    <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fec. Vencimiento:','id' => 'fecha_vencimiento','name' => 'fecha_vencimiento','wire:model.live' => 'fecha_vencimiento','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->subDays(2)),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->addDays(90)),'without-time' => true,'parse-format' => 'YYYY-MM-DD','display-format' => 'DD-MM-YYYY','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                            </div>

                        </div>

                    </div>

                    
                    <div
                        class="col-span-12 md:col-span-9 grid grid-cols-12 gap-2 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">


                        <div class="col-span-12 xs:col-span-4">

                            <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Tipo comprobante:','value' => ''.e(strtoupper($comprobante_slug)).' ELECTRONICA','readonly' => true]); ?>
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

                        
                        <div class="col-span-12 xs:col-span-4 xl:col-span-2">

                            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'serie','name' => 'serie','label' => 'Serie:','wire:model.live' => 'serie','placeholder' => 'Selecciona una serie','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    'api' => route('api.series.index'),
                                    'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                                ]),'option-label' => 'serie','option-value' => 'serie']); ?>
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

                        
                        <div class="col-span-12 xs:col-span-4 xl:col-span-2">

                            <?php if (isset($component)) { $__componentOriginal52e32dd6052e70eb6819edea2a97985a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52e32dd6052e70eb6819edea2a97985a = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Number::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['readonly' => true,'id' => 'correlativo','name' => 'correlativo','wire:model.live' => 'correlativo','label' => 'Correlativo:']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52e32dd6052e70eb6819edea2a97985a)): ?>
<?php $attributes = $__attributesOriginal52e32dd6052e70eb6819edea2a97985a; ?>
<?php unset($__attributesOriginal52e32dd6052e70eb6819edea2a97985a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52e32dd6052e70eb6819edea2a97985a)): ?>
<?php $component = $__componentOriginal52e32dd6052e70eb6819edea2a97985a; ?>
<?php unset($__componentOriginal52e32dd6052e70eb6819edea2a97985a); ?>
<?php endif; ?>

                        </div>

                        
                        <div class="col-span-12 xs:col-span-6 xl:col-span-2">
                            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Divisa:','id' => 'divisa','name' => 'divisa','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]),'option-label' => 'name','option-value' => 'id','wire:model.live' => 'divisa','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'icon' => 'currency-dollar']); ?>
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

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo_comprobante_id == '01'): ?>
                            <div class="col-span-12 xs:col-span-6 xl:col-span-2">

                                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'forma_pago','name' => 'forma_pago','label' => 'Forma Pago:','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    ['name' => 'CONTADO', 'id' => 'CONTADO'],
                                    ['name' => 'CREDITO', 'id' => 'CREDITO'],
                                ]),'option-label' => 'name','option-value' => 'id','wire:model.live' => 'forma_pago','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div
                        class="col-span-12 md:col-span-9 grid grid-cols-12 gap-2 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        <div class="col-span-12 md:col-span-6">

                            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'off','id' => 'cliente_id','name' => 'cliente_id','label' => 'Selecciona un cliente:','wire:model.live' => 'cliente_id','placeholder' => 'Escriba el nombre o número de documento del cliente','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    'api' => route('api.clientes.index'),
                                    'params' => ['tipo_comprobante' => $tipo_comprobante_id],
                                ]),'option-label' => 'razon_social','option-value' => 'id','option-description' => 'numero_documento','x-on:clear' => '$wire.direccion = \'\'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


                                 <?php $__env->slot('afterOptions', null, ['class' => 'p-2 flex justify-center','x-show' => 'displayOptions.length === 0']); ?> 
                                    <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click.prevent' => 'OpenModalCliente(`${search}`)','x-on:click' => 'close','primary' => true,'flat' => true,'full' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <span x-html="`Crear cliente <b>${search}</b>`"></span>
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
<?php if (isset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $attributes = $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061)): ?>
<?php $component = $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061; ?>
<?php unset($__componentOriginal49b3de13d927faa5a3ecd49fc0b06061); ?>
<?php endif; ?>
                        </div>

                        <div class="col-span-12 md:col-span-6">
                            <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'off','id' => 'direccion','name' => 'direccion','label' => 'Direccion:','wire:model.live' => 'direccion','placeholder' => 'Ingresa direccion']); ?>
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
                    </div>
                </div>

                
                <div class="col-span-12 md:col-span-3">

                    <div
                        class="col-span-12 md:col-span-3 grid grid-cols-12 gap-4 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        <div class="col-span-12">
                            <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left-label' => 'Disminuir Stock:','value' => 'true','lg' => true,'id' => 'decrease_stock','wire:model.live' => 'decrease_stock']); ?>
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

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$deduce_anticipos): ?>
                            <div class="col-span-12 text-center">
                                <?php if (isset($component)) { $__componentOriginal12ee426d66882c66c79ce07deee9e49f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12ee426d66882c66c79ce07deee9e49f = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Toggle::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left-label' => '¿Es un pago anticipado?','md' => true,'id' => 'pago_anticipado','wire:model.live' => 'pago_anticipado','value' => 'true']); ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$pago_anticipado && !$detraccion): ?>
                            <div class="col-span-12 text-center">
                                <?php if (isset($component)) { $__componentOriginal12ee426d66882c66c79ce07deee9e49f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12ee426d66882c66c79ce07deee9e49f = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Toggle::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left-label' => 'Deducción de los pagos anticipados','md' => true,'wire:model.live' => 'deduce_anticipos','id' => 'deduce_anticipos','value' => 'true']); ?>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo_comprobante_id == '01'): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$deduce_anticipos): ?>
                                <div class="col-span-12 text-center">
                                    <?php if (isset($component)) { $__componentOriginal12ee426d66882c66c79ce07deee9e49f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal12ee426d66882c66c79ce07deee9e49f = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Toggle::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Toggle::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left-label' => 'Operación con Detraccion','md' => true,'wire:model.live' => 'detraccion','id' => 'detraccion','value' => 'true']); ?>
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
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detraccion): ?>
                            <div class="col-span-12 text-left">
                                <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['xs' => true,'wire:click' => 'openModalDetraccion','spinner' => 'openModalDetraccion','outline' => true,'primary' => true,'label' => 'Informacion de la detraccion']); ?>
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


                            <?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Información de Detracción','max-width' => 'lg','wire:model.live' => 'openModalDt','align' => 'center']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


                                <div
                                    class="grid grid-cols-12 gap-6 text-sm col-span-12 rounded-lg shadow-lg bg-white dark:bg-gray-800 text-center border border-gray-300 dark:border-gray-600 px-4 py-4">

                                    <div class="col-span-12">

                                        <span class="font-semibold">La información de detraccion siempre se registrará
                                            en
                                            moneda nacional "SOL"
                                            independiente de la moneda
                                            del comprobante.</span>
                                    </div>

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
<?php $component->withAttributes(['autocomplete' => 'off','id' => 'codigo_detraccion','name' => 'codigo_detraccion','label' => 'código de bien/servicio sujeto a detracción*:','wire:model.live' => 'datosDetraccion.codigo_detraccion','placeholder' => 'Selecciona','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                                'api' => route('api.detracciones.index'),
                                            ]),'option-label' => 'descripcion','option-value' => 'codigo']); ?>
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

                                        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'datosDetraccion.cuenta_bancaria','label' => 'Nro. Cta. Banco de la Nación:','placeholder' => '']); ?>
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
<?php $component->withAttributes(['autocomplete' => 'off','id' => 'metodo_pago_id','name' => 'metodo_pago_id','label' => 'Medio de pago:','wire:model.live' => 'datosDetraccion.metodo_pago_id','placeholder' => 'Selecciona','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                                'api' => route('api.metodos.pago.index'),
                                            ]),'option-label' => 'descripcion','option-value' => 'id']); ?>
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

                                        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'datosDetraccion.porcentaje','label' => 'Porcentaje de detracción:','placeholder' => '12']); ?>
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
<?php $component->withAttributes(['wire:model.live' => 'datosDetraccion.monto','label' => 'Monto de detracción:','placeholder' => '0.00']); ?>
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

                                </div>
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detraccion): ?>
                        <div
                            class="col-span-12 md:col-span-3 grid grid-cols-12 gap-2 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">
                            <div class="col-span-12">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['datosDetraccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="col-span-6">
                                    <?php if (isset($component)) { $__componentOriginal983a7eb9047f01311cddd82e78ab7d46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal983a7eb9047f01311cddd82e78ab7d46 = $attributes; } ?>
<?php $component = WireUi\Components\Card\Index::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Card\Index::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Datos de detracción']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <ol>
                                            <li>
                                                <span class="font-semibold">Cuenta Bancaria:</span>
                                                <?php echo e($datosDetraccion['cuenta_bancaria']); ?>

                                            </li>
                                            <li>
                                                <span class="font-semibold">Codigo Detraccion:</span>
                                                <?php echo e($datosDetraccion['codigo_detraccion']); ?>

                                            </li>

                                            <li>
                                                <span class="font-semibold">Porcentaje:</span>
                                                <?php echo e($datosDetraccion['porcentaje']); ?>

                                            </li>
                                            <li>
                                                <span class="font-semibold">Monto:</span>
                                                <?php echo e($datosDetraccion['monto']); ?>

                                            </li>
                                        </ol>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal983a7eb9047f01311cddd82e78ab7d46)): ?>
<?php $attributes = $__attributesOriginal983a7eb9047f01311cddd82e78ab7d46; ?>
<?php unset($__attributesOriginal983a7eb9047f01311cddd82e78ab7d46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal983a7eb9047f01311cddd82e78ab7d46)): ?>
<?php $component = $__componentOriginal983a7eb9047f01311cddd82e78ab7d46; ?>
<?php unset($__componentOriginal983a7eb9047f01311cddd82e78ab7d46); ?>
<?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
                                    $errors->has('datosDetraccion.cuenta_bancaria') ||
                                        $errors->has('datosDetraccion.codigo_detraccion') ||
                                        $errors->has('datosDetraccion.metodo_pago_id') ||
                                        $errors->has('datosDetraccion.porcentaje') ||
                                        $errors->has('datosDetraccion.monto')): ?>
                                    <div class="col-span-12">
                                        <p class="mt-2  text-pink-600 text-sm">
                                            <?php echo e($errors->first('datosDetraccion.cuenta_bancaria')); ?>

                                            <br>
                                            <?php echo e($errors->first('datosDetraccion.codigo_detraccion')); ?>

                                            <br>
                                            <?php echo e($errors->first('datosDetraccion.metodo_pago_id')); ?>

                                            <br>
                                            <?php echo e($errors->first('datosDetraccion.porcentaje')); ?>

                                            <br>
                                            <?php echo e($errors->first('datosDetraccion.monto')); ?>

                                        </p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCredit): ?>
                        <div
                            class="col-span-12 md:col-span-3 grid grid-cols-12 gap-2 bg-white dark:bg-gray-800 items-start border border-gray-300 dark:border-gray-600 rounded-md m-3">

                            <?php if (isset($component)) { $__componentOriginal7272c4134fe51a35906843130eb43e8f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7272c4134fe51a35906843130eb43e8f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.facturacion.detalle-cuotas-table','data' => ['cuotas' => $detalle_cuotas,'totalcuotas' => $total_cuotas]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.facturacion.detalle-cuotas-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cuotas' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($detalle_cuotas),'totalcuotas' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($total_cuotas)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7272c4134fe51a35906843130eb43e8f)): ?>
<?php $attributes = $__attributesOriginal7272c4134fe51a35906843130eb43e8f; ?>
<?php unset($__attributesOriginal7272c4134fe51a35906843130eb43e8f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7272c4134fe51a35906843130eb43e8f)): ?>
<?php $component = $__componentOriginal7272c4134fe51a35906843130eb43e8f; ?>
<?php unset($__componentOriginal7272c4134fe51a35906843130eb43e8f); ?>
<?php endif; ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    

                </div>
            </div>
        </div>



        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 sm:p-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tipo_cambio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    <?php echo e($message); ?>

                </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="grid grid-cols-12 gap-2">

                <div class="col-span-12 mt-2 pt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg px-3">

                    <div class="grid grid-cols-5 gap-2 mt-2 pt-2 pb-2 bg-white dark:bg-gray-800 px-3 mb-2">

                        <div class="col-span-6 sm:col-span-2">

                            <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openModalAddProducto','spinner' => 'openModalAddProducto','label' => 'AÑADIR PRODUCTO','primary' => true,'md' => true,'icon' => 'plus']); ?>
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

                    

                    <?php if (isset($component)) { $__componentOriginalc828a90d79627711f4394d1707518304 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc828a90d79627711f4394d1707518304 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.facturacion.tabla-detalle','data' => ['items' => $items,'prepayments' => $prepayments,'tipo' => $tipo_comprobante_id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.facturacion.tabla-detalle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($items),'prepayments' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prepayments),'tipo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tipo_comprobante_id)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc828a90d79627711f4394d1707518304)): ?>
<?php $attributes = $__attributesOriginalc828a90d79627711f4394d1707518304; ?>
<?php unset($__attributesOriginalc828a90d79627711f4394d1707518304); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc828a90d79627711f4394d1707518304)): ?>
<?php $component = $__componentOriginalc828a90d79627711f4394d1707518304; ?>
<?php unset($__componentOriginalc828a90d79627711f4394d1707518304); ?>
<?php endif; ?>

                    <div class="block md:flex gap-2">
                        
                        <div class="grid grid-cols-12 gap-4 w-full px-4 mx-4 py-2 ml-auto mt-5">

                            
                            <div class="col-span-12 border-b border-cyan-600 dark:border-cyan-400">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">DESCUENTO</h4>
                            </div>

                            <div class="col-span-12 md:col-span-12">

                                <div class="flex flex-wrap gap-4">
                                    <div class="mt-2 flex gap-5">
                                        <?php if (isset($component)) { $__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Radio::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Radio::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'cantidad','id' => 'left-label','md' => true,'left-label' => 'S/','wire:model.live' => 'tipo_descuento']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4)): ?>
<?php $attributes = $__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4; ?>
<?php unset($__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4)): ?>
<?php $component = $__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4; ?>
<?php unset($__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4); ?>
<?php endif; ?>
                                        
                                    </div>


                                    <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'descuento_monto','name' => 'descuento_monto','icon' => 'currency-dollar','placeholder' => 'Monto descuento','wire:model.live.lazy' => 'descuento_monto','thousands' => '.','decimal' => '.','precision' => '2']); ?>
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
                                <?php echo e($descuento_monto); ?>-<?php echo e($descuento); ?> -<?php echo e($descuento_factor); ?>

                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($forma_pago === 'CONTADO'): ?>
                                <div class="col-span-12 border-b border-cyan-600 dark:border-cyan-400 mt-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-gray-200">PAGOS</h4>
                                </div>

                                <div class="col-span-12 mt-2">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                    Método
                                                    de pago</th>
                                                <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                    Destino</th>
                                                <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                    Referencia</th>
                                                <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                    Monto
                                                </th>
                                                <th class="px-2 py-2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pagos_detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr class="border-b dark:border-gray-600">
                                                    <td class="px-2 py-2">
                                                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'pagos_detalle.'.e($index).'.metodo_pago_id','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->paymentMethods
                                                                ? $this->paymentMethods->toArray()
                                                                : []),'option-label' => 'name','option-value' => 'id','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                                                    </td>
                                                    <td class="px-2 py-2 relative z-10">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->paymentDestinations && $this->paymentDestinations->isNotEmpty()): ?>
                                                            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'pagos_detalle.'.e($index).'.payment_destination_id','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->paymentDestinations->toArray()),'option-label' => 'description','option-value' => 'id','placeholder' => 'Seleccione destino']); ?>
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
                                                        <?php else: ?>
                                                            <span class="text-gray-500 text-xs">Sin destinos</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'pagos_detalle.'.e($index).'.referencia','placeholder' => 'Nro. operación']); ?>
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
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'pagos_detalle.'.e($index).'.monto','prefix' => ''.e($simbolo).'','precision' => '2','thousands' => ',','decimal' => '.']); ?>
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
                                                    </td>
                                                    <td class="px-2 py-2">
                                                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['xs' => true,'negative' => true,'icon' => 'trash','wire:click' => 'eliminarPago('.e($index).')']); ?>
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
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="5"
                                                        class="px-2 py-4 text-center text-gray-500 dark:text-gray-400">
                                                        No hay pagos registrados. Haga clic en "+ Agregar pago"
                                                    </td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>

                                    <div class="mt-2">
                                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['xs' => true,'primary' => true,'icon' => 'plus','label' => 'Agregar pago','wire:click' => 'agregarPago']); ?>
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
                            <?php else: ?>
                                
                                <div class="col-span-12 md:col-span-6 mt-4">
                                    <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'metodo_pago_id','name' => 'metodo_pago_id','label' => 'MÉTODO DE PAGO:','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                            ['name' => 'En efectivo', 'id' => '009'],
                                            ['name' => 'Depósito en cuenta', 'id' => '001'],
                                            ['name' => 'Tarjeta de débito', 'id' => '005'],
                                            ['name' => 'Tarjeta de crédito', 'id' => '006'],
                                            ['name' => 'Transferencia bancaria', 'id' => '003'],
                                            ['name' => 'Giro', 'id' => '002'],
                                        ]),'option-label' => 'name','option-value' => 'id','wire:model.live' => 'metodo_pago_id','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
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
<?php $component->withAttributes(['label' => 'Comentario:','id' => 'comentario','name' => 'comentario','wire:model.live' => 'comentario','placeholder' => 'Escribe tu comentario']); ?>
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

                        </div>

                        
                        <div class="py-2 ml-auto mt-5 w-full mx-4">
                            <div class="text-right mb-4 border-b border-gray-300 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">RESUMEN</h4>
                            </div>

                            <div class="flex justify-between ">
                                <div
                                    class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                    SUB TOTAL
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 dark:text-gray-200 text-sm">
                                        <?php echo e($simbolo); ?> <span><?php echo e(round($sub_total, 4)); ?></span>
                                    </div>

                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduce_anticipos): ?>
                                <div class="flex justify-between ">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                        ANTICIPOS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 dark:text-gray-200 text-sm">
                                            <?php echo e($simbolo); ?> <span><?php echo e(round($total_anticipos, 4)); ?></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex justify-between mt-2">
                                <div
                                    class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                    OP. GRAVADAS
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 dark:text-gray-200 text-sm">
                                        <?php echo e($simbolo); ?> <span><?php echo e(round($op_gravadas, 4)); ?></span>
                                    </div>

                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($op_exoneradas > 0): ?>
                                <div class="flex justify-between mt-2">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                        OP.
                                        EXONERADAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 dark:text-gray-200 text-sm">
                                            <?php echo e($simbolo); ?> <span><?php echo e(round($op_exoneradas, 4)); ?></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($op_inafectas > 0): ?>
                                <div class="flex justify-between mt-2">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                        OP.
                                        INAFECTAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 dark:text-gray-200 text-sm">
                                            <?php echo e($simbolo); ?> <span><?php echo e(round($op_inafectas, 4)); ?></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($op_gratuitas > 0): ?>
                                <div class="flex justify-between mt-2">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                        OP.
                                        GRATUITAS
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-gray-800 dark:text-gray-200 text-sm">
                                            <?php echo e($simbolo); ?> <span><?php echo e(round($op_gratuitas, 4)); ?></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="flex justify-between mt-2">
                                <div
                                    class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                    DESCUENTO
                                    (-)
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 dark:text-gray-200 text-sm">
                                        <?php echo e($simbolo); ?> <span><?php echo e(round($descuento, 2)); ?></span>
                                    </div>

                                </div>
                            </div>


                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">
                                    IGV(18%)</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 dark:text-gray-200 text-sm"><?php echo e($simbolo); ?>

                                        <span><?php echo e(round($igv, 4)); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mb-4 mt-2">
                                <div class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">
                                    ICBPER</div>
                                <div class="text-right w-40">
                                    <div class="text-gray-800 dark:text-gray-200 text-sm"><?php echo e($simbolo); ?>

                                        <span><?php echo e(number_format($icbper, 2)); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="py-2 border-t border-b border-indigo-500 dark:border-indigo-400">
                                <div class="flex justify-between">
                                    <div
                                        class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm">
                                        Importe Total
                                    </div>
                                    <div class="text-right w-40">
                                        <div class="text-xl text-gray-800 dark:text-gray-200 font-bold">
                                            <?php echo e($simbolo); ?><span><?php echo e(round($total, 4)); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCredit): ?>
                                
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->environment('local')): ?>
                <?php echo e(json_encode($errors->all())); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div
                class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-600 z-5">

                <div class="grid <?php echo e($tipo_comprobante_id == '02' ? '' : 'sm:grid-cols-2'); ?>  gap-2 content-end">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo_comprobante_id == '01' || $tipo_comprobante_id == '03'): ?>
                        <div class="flex gap-10 w-full">
                            <div class="inline-flex items-center">
                                <label class="relative flex cursor-pointer items-center rounded-full p-3"
                                    for="metodo_1" data-ripple-dark="true">
                                    <input id="metodo_1" wire:model.live="metodo_type" value="01"
                                        type="radio"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-blue-gray-200 text-blue-500 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-blue-500 checked:before:bg-blue-500 hover:before:opacity-10" />
                                    <div
                                        class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-blue-500 opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 16 16" fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </div>
                                </label>
                                <label
                                    class="mt-px cursor-pointer select-none font-light text-gray-700 dark:text-gray-300 text-sm"
                                    for="metodo_1">
                                    SOLO FIRMAR E IMPRIMIR
                                </label>
                            </div>

                            <div class="inline-flex items-center">
                                <label class="relative flex cursor-pointer items-center rounded-full p-3"
                                    for="metodo_2" data-ripple-dark="true">
                                    <input id="metodo_2" wire:model.live="metodo_type" value="02"
                                        type="radio"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-blue-gray-200 text-blue-500 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-blue-500 checked:before:bg-blue-500 hover:before:opacity-10" />
                                    <div
                                        class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-blue-500 opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 16 16" fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </div>
                                </label>
                                <label
                                    class="mt-px cursor-pointer select-none font-light text-gray-700 dark:text-gray-300 text-sm"
                                    for="metodo_2">
                                    ENVIAR A SUNAT AHORA
                                </label>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                    <div class="text-center md:text-right">

                        <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click.prevent' => 'save','spinner' => 'save','label' => 'EMITIR COMPROBANTE','black' => true,'md' => true,'icon' => 'shopping-cart']); ?>
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
            </div>


        </div>

    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.productos.modal-add-producto', ['deduce_anticipos' => $deduce_anticipos,'comprobante_slug' => $comprobante_slug,'divisa' => $divisa,'tipo_comprobante_id' => $tipo_comprobante_id]);

$key = 'producto-add-';
$__componentSlots = [];

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-360530712-0', $key);

$__html = app('livewire')->mount($__name, $__params, $key, $__componentSlots);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImeiModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">

                
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">
                            📡 <?php echo e($editingImeiIndex !== null ? 'Modificar IMEIs' : 'Seleccionar IMEI'); ?>

                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Producto: <span class="font-medium"><?php echo e($pendingGpsItem['descripcion'] ?? ''); ?></span>
                        </p>
                    </div>
                    <button wire:click="cancelarImei"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                
                <?php
                    $needed = (int) ($pendingGpsItem['cantidad'] ?? 1);
                    $selected = count($selectedImeis);
                ?>
                <div class="px-6 pt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-300">
                            Seleccionados: <span
                                class="<?php echo e($selected >= $needed ? 'text-emerald-600' : 'text-indigo-600'); ?> font-bold"><?php echo e($selected); ?></span>
                            / <?php echo e($needed); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selected > 0): ?>
                            <span class="text-xs text-slate-400"><?php echo e($needed - $selected); ?> pendiente(s)</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all"
                            style="width: <?php echo e($needed > 0 ? min(100, ($selected / $needed) * 100) : 0); ?>%"></div>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedImeis) > 0): ?>
                    <div class="px-6 pt-3">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1">
                            Seleccionados</p>
                        <div class="flex flex-wrap gap-1.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $selectedImeis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIndex => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <span
                                    class="inline-flex items-center gap-1 text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300 px-2 py-0.5 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <?php echo e($s['imei']); ?>

                                    <button wire:click.prevent="quitarImeiSeleccionado(<?php echo e($sIndex); ?>)"
                                        class="ml-0.5 text-emerald-600 hover:text-red-500 dark:text-emerald-400 dark:hover:text-red-400 font-bold leading-none"
                                        title="Quitar">&times;</button>
                                </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="px-6 pt-3">
                    <input wire:model.live="imeiSearch" type="text"
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-slate-700 dark:text-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Buscar por IMEI..." />
                </div>

                
                <div class="px-6 py-3 max-h-56 overflow-y-auto space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->dispositivosImei; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <button wire:click="confirmarImei(<?php echo e($disp->id); ?>)"
                            class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 hover:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-700 transition group">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 truncate">IMEI:
                                    <?php echo e($disp->imei); ?></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    <?php echo e($disp->modelo?->marca ?? 'Sin marca'); ?> ·
                                    <?php echo e($disp->modelo?->modelo ?? 'Sin modelo'); ?></p>
                            </div>
                            <span
                                class="text-xs bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 px-2 py-0.5 rounded-full">STOCK</span>
                        </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="text-center py-8 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto mb-2 opacity-40"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm">
                                <?php echo e(count($selectedImeis) > 0 ? 'No hay más dispositivos en stock para este modelo.' : 'No hay dispositivos en stock para este modelo.'); ?>

                            </p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div
                    class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <span class="text-xs text-slate-400 dark:text-slate-500">
                        <?php echo e($needed > 1 ? 'Selecciona ' . $needed . ' dispositivos uno por uno' : 'Selecciona 1 dispositivo'); ?>

                    </span>
                    <button wire:click="cancelarImei"
                        class="px-4 py-2 text-sm rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                        Cancelar
                    </button>
                </div>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/facturacion/ventas/emitir.blade.php ENDPATH**/ ?>