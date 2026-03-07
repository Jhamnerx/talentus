<div>
    <?php if (isset($component)) { $__componentOriginal6a7d148983ed3ace55a3e668006b80a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a7d148983ed3ace55a3e668006b80a5 = $attributes; } ?>
<?php $component = WireUi\Components\Modal\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.modal.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\WireUi\Components\Modal\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'INFORMACION DISPOSITIVO','max-width' => '2xl','wire:model.live' => 'modalOpen']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <!-- Sidebar -->
        <div>
            <div
                class="lg:sticky lg:top-16 bg-slate-50 lg:overflow-x-hidden lg:overflow-y-auto no-scrollbar lg:shrink-0 border-t lg:border-t-0 lg:border-l border-slate-200 w-full">
                <div class="py-8 px-4 lg:px-8 2xl:px-12">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($datos['status'] == 'ok'): ?>
                        <div class="max-w-sm w-full mx-auto lg:max-w-none">
                            <h2 class="text-2xl text-slate-800 font-bold mb-6"><?php echo e($datos['imei']); ?>

                            </h2>
                            <div class="space-y-6">

                                <!-- Details -->
                                <div>
                                    <div class="text-slate-800 font-semibold mb-2">Detalles Dispositivo
                                    </div>

                                    <ul>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Imei:</div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">
                                                <?php echo e($datos['imei']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Modelo:</div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">
                                                <?php echo e($datos['model']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="flex items-center">
                                                <span class="text-sm mr-2">Configuración actual:</span>

                                            </div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">

                                                <span
                                                    class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                    <?php echo e($datos['current_configuration']); ?>

                                                </span>
                                            </div>

                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="flex items-center">
                                                <span class="text-sm mr-2">Firmware:</span>

                                            </div>
                                            <div class="text-sm font-medium text-slate-800 ml-2">

                                                <span
                                                    class="text-xs inline-flex whitespace-nowrap font-medium uppercase bg-slate-200 text-slate-500 rounded-full text-center px-2.5 py-1">
                                                    <?php echo e($datos['current_firmware']); ?>

                                                </span>
                                            </div>

                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Descripción:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                <?php echo e($datos['description']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Company:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                <?php echo e($datos['company_name']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">Grupo:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                <?php echo e($datos['group_name']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">iccid:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                <?php echo e($datos['iccid']); ?></div>
                                        </li>
                                        <li class="flex items-center justify-between py-3 border-b border-slate-200">
                                            <div class="text-sm">imsi:</div>
                                            <div class="text-sm font-medium text-emerald-600 ml-2">
                                                <?php echo e($datos['imsi']); ?></div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Details -->
                                <div>
                                    <div class="text-slate-800 font-semibold mb-4">Visto a las</div>
                                    <div class="text-sm rounded border border-slate-200 p-3">
                                        <div class="flex items-center justify-between space-x-2">

                                            <!-- Expiry -->
                                            <div class=" ml-2"><?php echo e($datos['seen_at']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div class="mb-4">
                                        <a target="_blank"
                                            href="https://fm.teltonika.lt/devices?query=<?php echo e($datos['imei']); ?>"
                                            class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white">

                                            Ver en Fota Web
                                        </a>
                                    </div>
                                    <div class="text-xs text-slate-500 italic text-center">Estos datos son
                                        obtenidos de la Api de fota web.
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php else: ?>
                        <div class="max-w-sm w-full mx-auto lg:max-w-none">

                            <h2 class="text-xl text-slate-800 font-bold mb-6">

                                Dispositivo no encontrado en fota web
                            </h2>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>
            </div>
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
<?php $component->withAttributes(['flat' => true,'label' => 'Cerrar','wire:click.prevent' => 'closeModal']); ?>
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
<?php /**PATH C:\laragon2\www\talentus\resources\views/livewire/admin/dispositivos/show-info.blade.php ENDPATH**/ ?>