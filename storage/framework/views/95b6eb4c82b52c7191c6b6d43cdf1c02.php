<?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'EDITAR CERTIFICADO VELOCIMETRO','wire:model.live' => 'openModalEdit','align' => 'center']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-3">

            <?php if (isset($component)) { $__componentOriginal125559500674abc14ca4c750a63c3764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal125559500674abc14ca4c750a63c3764 = $attributes; } ?>
<?php $component = WireUi\Components\TextField\Input::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\TextField\Input::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'numero','readonly' => true,'label' => 'Número Certificado:']); ?>
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
        <div class="col-span-12 sm:col-span-5">

            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Selecciona una Vehiculo:','wire:model.live' => 'vehiculos_id','placeholder' => 'Selecciona una placa','option-description' => 'option_description','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.vehiculos.index')),'option-label' => 'placa','option-value' => 'id']); ?>
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
        <div class="col-span-12 sm:col-span-4">

            <?php if (isset($component)) { $__componentOriginal49b3de13d927faa5a3ecd49fc0b06061 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49b3de13d927faa5a3ecd49fc0b06061 = $attributes; } ?>
<?php $component = WireUi\Components\Select\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Selecciona una Ciudad:','wire:model.live' => 'ciudades_id','placeholder' => 'Selecciona una ciudad','async-data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('api.ciudades.index')),'option-label' => 'nombre','option-value' => 'id']); ?>
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
<?php $component->withAttributes(['label' => 'Modelo
                                    Velocimetro:','placeholder' => 'Selecciona un modelo','wire:model.live' => 'velocimetro_modelo']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $velocimetros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $velocimetro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginala4f38432c8908ddbfb286ebfc0889ede = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4f38432c8908ddbfb286ebfc0889ede = $attributes; } ?>
<?php $component = WireUi\Components\Select\Option::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Select\Option::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => ''.e($velocimetro->descripcion).'','value' => ''.e($velocimetro->descripcion).'']); ?>
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
        <div class="col-span-12">

            <label class="block text-sm font-medium mb-1" for="observacion">OBSERVACIÓN:</label>
            <div class="relative">
                <textarea wire:model.live="observacion" class="form-input w-full pl-9" name="observacion" id="observacion"
                    rows="4" placeholder="Ingresar Observación"></textarea>
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                    <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g class="nc-icon-wrapper">
                            <path
                                d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                fill="#fbe5d5"></path>
                            <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z" fill="#ff7163">
                            </path>
                            <path d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                fill="#4c4c4c"></path>
                            <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b">
                            </path>
                            <path
                                d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                fill="#3d6c7b"></path>
                            <rect x="33.294" y="5.618" width="2" height="16.142"
                                transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55">
                            </rect>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-12 mt-4">
            <span class="text-bold text-center mb-2">Caracteristicas:</span>
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                <div class="m-2 w-full mt-2">
                    <label for="fondo">Fondo:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="fondo" type="checkbox" id="fondoe-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="fondoe-1">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">fondo switch</span>
                            </label>
                        </div>
                        <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Activado' : 'Desactivado'">
                        </div>
                    </div>

                </div>
                <div class="m-2 w-full">
                    <label for="sello">Sello:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="sello" type="checkbox" id="selloe-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="selloe-1">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">sello switch</span>
                            </label>
                        </div>
                        <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Activado' : 'Desactivado'">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

     <?php $__env->slot('footer', null, []); ?> 
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <?php if (isset($component)) { $__componentOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf04362c37f55b087f96f1c4fb07d5ce1 = $attributes; } ?>
<?php $component = WireUi\Components\Button\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Button\Base::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['flat' => true,'label' => 'Cancelar','x-on:click' => 'close']); ?>
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
<?php $component->withAttributes(['primary' => true,'label' => 'Guardar','wire:click' => 'save']); ?>
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
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/certificados/velocimetros/edit.blade.php ENDPATH**/ ?>