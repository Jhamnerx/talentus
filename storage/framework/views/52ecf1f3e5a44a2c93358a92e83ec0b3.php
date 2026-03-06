<div>
    
    <div
        class="my-4 container px-10 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300 dark:border-gray-600">
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
            <a href="<?php echo e(route('admin.ventas.recibos.index')); ?>">
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                    </svg>
                    <span class="hidden xs:block ml-2">Atrás</span>
                </button>
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="mt-2 md:mt-0">
            <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200">CREAR RECIBO</h4>
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
    <div class="p-2 shadow overflow-hidden sm:rounded-md bg-white dark:bg-gray-900">
        <div class="px-4 py-2 bg-slate-100 dark:bg-gray-700 sm:p-2">

            <div class="grid grid-cols-12 gap-2">

                
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="grid grid-cols-12 gap-3 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        
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
<?php $component->withAttributes(['label' => 'Selecciona un cliente:','wire:model.live' => 'clientes_id','placeholder' => 'Selecciona un cliente','option-description' => 'numero_documento','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.clientes.index')),'option-label' => 'razon_social','option-value' => 'id']); ?>
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

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente): ?>
                            <div class="col-span-12">
                                <?php if (isset($component)) { $__componentOriginal57aa1052e1346bb9093f53955bccaab1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57aa1052e1346bb9093f53955bccaab1 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Ventas\ClienteSelected::resolve(['cliente' => $cliente] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ventas.cliente-selected'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Ventas\ClienteSelected::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57aa1052e1346bb9093f53955bccaab1)): ?>
<?php $attributes = $__attributesOriginal57aa1052e1346bb9093f53955bccaab1; ?>
<?php unset($__attributesOriginal57aa1052e1346bb9093f53955bccaab1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57aa1052e1346bb9093f53955bccaab1)): ?>
<?php $component = $__componentOriginal57aa1052e1346bb9093f53955bccaab1; ?>
<?php unset($__componentOriginal57aa1052e1346bb9093f53955bccaab1); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
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
<?php $component->withAttributes(['id' => 'serie','name' => 'serie','label' => 'Serie:','wire:model.live' => 'serie','placeholder' => 'Selecciona una serie','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    'api' => route('api.series.index'),
                                    'params' => ['tipo_comprobante' => '10'],
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

                        
                        <div class="col-span-12 md:col-span-6">
                            <?php if (isset($component)) { $__componentOriginal52e32dd6052e70eb6819edea2a97985a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52e32dd6052e70eb6819edea2a97985a = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Number::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'correlativo','name' => 'numero','wire:model.live' => 'numero','label' => 'Número Recibo:']); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['serie_numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="col-span-12 md:col-span-6">
                            <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha de Emision:','id' => 'fecha_emision','name' => 'fecha_emision','wire:model.live' => 'fecha_emision','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->subDays(10)),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()),'without-time' => true,'parse-format' => 'YYYY-MM-DD','display-format' => 'DD-MM-YYYY','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

                        
                        <div class="col-span-12 md:col-span-6">
                            <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha de Pago:','id' => 'fecha_pago','name' => 'fecha_pago','wire:model.live' => 'fecha_pago','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->subDays(15)),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->addDays(30)),'without-time' => true,'parse-format' => 'YYYY-MM-DD','display-format' => 'DD-MM-YYYY','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

                
                <div class="col-span-12 md:col-span-6">
                    <div
                        class="grid grid-cols-12 gap-3 bg-white dark:bg-gray-800 items-start border border-gray-200 dark:border-gray-600 rounded-md m-3 p-4">

                        
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
<?php $component->withAttributes(['label' => 'Moneda:','id' => 'divisa','name' => 'divisa','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['name' => 'SOLES', 'id' => 'PEN'], ['name' => 'DOLARES', 'id' => 'USD']]),'option-label' => 'name','option-value' => 'id','wire:model.live' => 'divisa','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'icon' => 'currency-dollar']); ?>
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
<?php $component->withAttributes(['id' => 'tipo_venta','name' => 'tipo_venta','label' => 'Forma Pago:','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                ['name' => 'CONTADO', 'id' => 'CONTADO'],
                                ['name' => 'CREDITO', 'id' => 'CREDITO'],
                            ]),'option-label' => 'name','option-value' => 'id','wire:model.live' => 'tipo_venta','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
<?php $component->withAttributes(['label' => 'Nota:','id' => 'nota','name' => 'nota','wire:model.live' => 'nota','placeholder' => 'Ingresar nota opcional','rows' => '3']); ?>
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
                </div>

            </div>

            
            <div
                class="mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg px-3 py-3 mx-3 border border-gray-200 dark:border-gray-600">

                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="col-span-2 sm:col-span-1" wire:ignore>
                        <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'wire:model.live' => 'product_selected_id','id' => 'product_selected_id','name' => 'product_selected_id','placeholder' => 'Seleccionar producto o servicio','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                'api' => route('api.productos.index'),
                            ]),'option-label' => 'descripcion','option-value' => 'id','option-description' => 'option_description','template' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                'name' => 'user-option',
                                'config' => ['src' => 'imagen'],
                            ]),'always-fetch' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                             <?php $__env->slot('beforeOptions', null, ['class' => 'p-2 flex justify-center']); ?> 
                                <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click.prevent' => 'addProductoModal(`${search}`)','x-on:click' => 'close','primary' => true,'flat' => true,'full' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                    <span x-html="`Registrar Producto <b>${search}</b>`"></span>
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
                </div>

                
                <?php if (isset($component)) { $__componentOriginal9ba538629cd3d0a574eb964bbc173c5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ba538629cd3d0a574eb964bbc173c5c = $attributes; } ?>
<?php $component = App\View\Components\Admin\Ventas\TablaDetalleVenta::resolve(['items' => $items,'selected' => $selected] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ventas.tabla-detalle-venta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Ventas\TablaDetalleVenta::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ba538629cd3d0a574eb964bbc173c5c)): ?>
<?php $attributes = $__attributesOriginal9ba538629cd3d0a574eb964bbc173c5c; ?>
<?php unset($__attributesOriginal9ba538629cd3d0a574eb964bbc173c5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ba538629cd3d0a574eb964bbc173c5c)): ?>
<?php $component = $__componentOriginal9ba538629cd3d0a574eb964bbc173c5c; ?>
<?php unset($__componentOriginal9ba538629cd3d0a574eb964bbc173c5c); ?>
<?php endif; ?>

                <div class="block md:flex gap-2">

                    
                    <div class="grid grid-cols-12 gap-4 w-full px-4 py-2 mt-5 text-gray-800 dark:text-gray-200">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipo_venta === 'CONTADO'): ?>
                            <div class="col-span-12 border-b border-cyan-600 dark:border-cyan-400">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">PAGOS</h4>
                            </div>

                            <div class="col-span-12 mt-2">
                                <table class="min-w-full text-sm text-gray-800 dark:text-gray-200">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Método de
                                                pago</th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Destino
                                            </th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">
                                                Referencia</th>
                                            <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-200">Monto</th>
                                            <th class="px-2 py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pagos_detalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
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
<?php $component->withAttributes(['id' => 'forma_pago','name' => 'forma_pago','label' => 'MÉTODO DE PAGO:','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                        ['name' => 'En efectivo', 'id' => '009'],
                                        ['name' => 'Depósito en cuenta', 'id' => '001'],
                                        ['name' => 'Tarjeta de débito', 'id' => '005'],
                                        ['name' => 'Tarjeta de crédito', 'id' => '006'],
                                        ['name' => 'Transferencia bancaria', 'id' => '003'],
                                        ['name' => 'Giro', 'id' => '002'],
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

                    
                    <div class="py-2 ml-auto mt-5 w-full mx-4">
                        <div class="text-right mb-4 border-b border-gray-300 dark:border-gray-600">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200">RESUMEN</h4>
                        </div>

                        <div class="py-2 border-t border-b border-indigo-500 dark:border-indigo-400">
                            <div class="flex justify-between">
                                <div
                                    class="text-gray-900 dark:text-gray-100 text-right flex-1 font-medium text-sm text-lg">
                                    Importe Total
                                </div>
                                <div class="text-right w-40">
                                    <div class="text-xl text-gray-800 dark:text-gray-200 font-bold">
                                        <?php echo e($simbolo); ?><span><?php echo e(number_format($total, 2)); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        
        <div
            class="px-4 py-3 text-right sm:px-6 sticky my-2 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-600 z-5">
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
<?php $component->withAttributes(['wire:click.prevent' => 'save','spinner' => 'save','label' => 'CREAR RECIBO','black' => true,'md' => true,'icon' => 'shopping-cart']); ?>
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showImeiModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">

                
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">📡 Seleccionar IMEI</h3>
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

                
                <div class="px-6 pt-4">
                    <input wire:model.live="imeiSearch" type="text"
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-slate-700 dark:text-slate-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Buscar por IMEI..." />
                </div>

                
                <div class="px-6 py-3 max-h-72 overflow-y-auto space-y-2">
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
                            <p class="text-sm">No hay dispositivos en stock para este modelo.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                    <button wire:click="cancelarImei"
                        class="px-4 py-2 text-sm rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                        Cancelar
                    </button>
                </div>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/ventas/recibos/create.blade.php ENDPATH**/ ?>