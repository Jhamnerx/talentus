<?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'NUEVO ITEM','wire:model.live' => 'showModal','width' => '2xl','blur' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="grid grid-cols-12 gap-4">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deduce_anticipos): ?>
            <div class="col-span-12 md:col-start-2 mt-2">
                <?php if (isset($component)) { $__componentOriginal49f7089ef4c669895a04f5fadb180b38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49f7089ef4c669895a04f5fadb180b38 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['left-label' => 'Anticipo','id' => 'is_anticipo_p','name' => 'is_anticipo_p','value' => 'true','lg' => true,'wire:model.live' => 'anticipo']); ?>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($anticipo): ?>
            <div class="col-span-12 md:col-start-2">
                <span class="font-semibold text-sm dark:text-gray-200">Información del anticipo</span>
            </div>

            
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                <label for="product_selected_id" class="dark:text-gray-300"><?php echo e(Str::ucfirst($comprobante_slug)); ?> de
                    Venta:</label> <br>
                <label for="sr" class="dark:text-gray-300">Serie - Nro.</label>
            </div>

            <div class="col-span-4 md:col-span-2">

                <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'serie_ref','errorless' => 'false','placeholder' => 'F001','name' => 'serie_ref','wire:model.live' => 'prepayments.serie_ref','maxlength' => '4']); ?>
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

            <div class="col-span-4 md:col-span-3">

                <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'correlativo_ref','errorless' => 'false','placeholder' => '1','name' => 'correlativo_ref','wire:model.live.change' => 'prepayments.correlativo_ref']); ?>
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

            <div class="col-span-12 md:col-span-9 md:col-start-2">
                <?php if (isset($component)) { $__componentOriginal69622d036ef7797b5141359a79e1bd4b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69622d036ef7797b5141359a79e1bd4b = $attributes; } ?>
<?php $component = WireUi\Components\Errors\Multiple::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Errors\Multiple::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['only' => 'prepayments.serie_ref|prepayments.correlativo_ref']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69622d036ef7797b5141359a79e1bd4b)): ?>
<?php $attributes = $__attributesOriginal69622d036ef7797b5141359a79e1bd4b; ?>
<?php unset($__attributesOriginal69622d036ef7797b5141359a79e1bd4b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69622d036ef7797b5141359a79e1bd4b)): ?>
<?php $component = $__componentOriginal69622d036ef7797b5141359a79e1bd4b; ?>
<?php unset($__componentOriginal69622d036ef7797b5141359a79e1bd4b); ?>
<?php endif; ?>
            </div>

            
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                <label for="fecha_emision_ref" class="dark:text-gray-300">Fecha de Emisión:</label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">
                <?php if (isset($component)) { $__componentOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf5ec2314556edbf2ae00bd09d5d0fe12 = $attributes; } ?>
<?php $component = WireUi\Components\DatetimePicker\Picker::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.datetime.picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\DatetimePicker\Picker::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'fecha_emision_ref','name' => 'fecha_emision_ref','wire:model.live' => 'prepayments.fecha_emision_ref','min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()->subDays(1)),'max' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(now()),'without-time' => true,'parse-format' => 'YYYY-MM-DD','display-format' => 'DD-MM-YYYY','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

            
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="total_invoice_ref" class="dark:text-gray-300">Importe total
                    <?php echo e(Str::ucfirst($comprobante_slug)); ?> de Venta:</label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','id' => 'total_invoice_ref','name' => 'total_invoice_ref','wire:model.live' => 'prepayments.total_invoice_ref','precision' => '2','disabled' => true]); ?>
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
        <?php else: ?>
            <div class="col-span-12 md:col-start-2 md:col-end-5 mt-2 text-sm">
                <label for="product_selected_id" class="dark:text-gray-300">Producto:</label>
            </div>

            <div class="col-span-12 md:col-span-7 mt-2">

                <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autocomplete' => 'off','clearable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'wire:model.live' => 'product_selected_id','id' => 'product_selected_id','name' => 'product_selected_id','placeholder' => 'Seleccionar producto o servicio','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'api' => route('api.productos.index'),
                    ]),'option-label' => 'descripcion','option-value' => 'id','option-description' => 'option_description','template' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'name' => 'user-option',
                        'config' => ['src' => 'imagen'],
                    ]),'always-fetch' => true]); ?>
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

            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">
                <label for="codigo" class="dark:text-gray-300">Código:</label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'codigo','name' => 'codigo','wire:model.live' => 'selected.codigo','placeholder' => 'COD-PROD13']); ?>
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

            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="cantidad" class="dark:text-gray-300">Cantidad:</label>

            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal52e32dd6052e70eb6819edea2a97985a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52e32dd6052e70eb6819edea2a97985a = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Number::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Number::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'cantidad','name' => 'cantidad','wire:model.live' => 'selected.cantidad','min' => '1','step' => '1']); ?>
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

            <div class="col-start-5 col-span-6 md:col-start-9 md:col-end-12 text-sm">

                <span x-text="$wire.selected.unit_name"
                    class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10 dark:ring-gray-400/20">
                    UNIDAD
                </span>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($anticipo): ?>
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="prepayments_descripcion" class="dark:text-gray-300">Descripción:</label>

            </div>

            <div class="col-span-12 md:col-start-5 md:col-end-11">

                <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'prepayments_descripcion','id' => 'prepayments_descripcion','wire:model.live' => 'prepayments.descripcion']); ?>
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

            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="valor_venta_ref" class="dark:text-gray-300">Anticipo a Valor de Venta:</label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'valor_venta_ref','name' => 'valor_venta_ref','prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live' => 'prepayments.valor_venta_ref','precision' => '4']); ?>
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
        <?php else: ?>
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="descripcion" class="dark:text-gray-300">Descripción:</label>

            </div>

            <div class="col-span-12 md:col-start-5 md:col-end-11">

                <?php if (isset($component)) { $__componentOriginal766d51b9779a62d55606e4facdbf6fa8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal766d51b9779a62d55606e4facdbf6fa8 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Textarea::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Textarea::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'descripcion','id' => 'descripcion','wire:model.live' => 'selected.descripcion']); ?>
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

            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="valor_unitario" class="dark:text-gray-300">Valor Unitario:</label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'valor_unitario','name' => 'valor_unitario','prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live.blur' => 'selected.valor_unitario','precision' => '4']); ?>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="igv" class="dark:text-gray-300">IGV:</label>
        </div>

        <div class="col-span-4 md:col-span-2">

            <?php if (isset($component)) { $__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Radio::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Radio::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'gravado','name' => 'gravado','value' => '10','wire:model.live' => 'tipo_afectacion','label' => 'Gravado']); ?>
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
        <div class="col-span-4 md:col-span-2">

            <?php if (isset($component)) { $__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Radio::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Radio::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'exonerado','name' => 'exonerado','value' => '20','wire:model.live' => 'tipo_afectacion','label' => 'Exonerado']); ?>
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
        <div class="col-span-4 md:col-span-2">

            <?php if (isset($component)) { $__componentOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a764196c9adf4dff8d0ea92efd9a9b4 = $attributes; } ?>
<?php $component = WireUi\Components\Switcher\Radio::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.radio'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Switcher\Radio::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'inafecto','name' => 'inafecto','value' => '30','wire:model.live' => 'tipo_afectacion','label' => 'Inafecto']); ?>
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
        <div class="col-start-3 col-span-6 md:col-start-5 md:col-span-3">

            <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'igv','name' => 'igv','precision' => '4','placeholer' => '0.00','disabled' => true,'prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live' => 'selected.igv']); ?>
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selected['afecto_icbper']): ?>
            <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

                <label for="icbper" class="dark:text-gray-300">
                    ICBPER:
                </label>
            </div>

            <div class="col-span-12 md:col-start-5 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'icbper','name' => 'icbper','precision' => '4','placeholer' => '0.00','disabled' => true,'prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live' => 'selected.icbper']); ?>
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

            <div class="col-span-12 md:col-start-9 md:col-span-4">

                <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'total_icbper','name' => 'total_icbper','precision' => '4','placeholer' => '0.00','disabled' => true,'prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live' => 'selected.total_icbper']); ?>
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
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="col-span-12 md:col-start-2 md:col-end-5 text-sm">

            <label for="total" class="dark:text-gray-300">
                Importe Total del Item: <?php echo e($tipo_comprobante_id); ?>

            </label>
        </div>

        <div class="col-span-12 md:col-start-5 md:col-span-4">


            <?php if (isset($component)) { $__componentOriginal5b0811533b7e6484d46a99f1515e2054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b0811533b7e6484d46a99f1515e2054 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Currency::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Currency::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'total','name' => 'total','precision' => '4','placeholer' => '0.00','prefix' => ''.e($divisa == 'PEN' ? 'S/ ' : '$').'','wire:model.live.blur' => 'selected.total']); ?>
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->environment('local')): ?>
            <div class="col-span-12 md:col-start-5 md:col-span-4">
                <?php echo e(json_encode($selected)); ?>


            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

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
<?php $component->withAttributes(['flat' => true,'label' => 'Cancelar','wire:click' => '$set(\'showModal\', false)']); ?>
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
<?php $component->withAttributes(['primary' => true,'label' => 'Agregar','wire:click' => 'addProducto']); ?>
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

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/productos/modal-add-producto.blade.php ENDPATH**/ ?>