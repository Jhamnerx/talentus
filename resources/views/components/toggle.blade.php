@props(['id' => null, 'name' => null, 'size' => 'md'])

@php
    $sizes = [
        'xs' => 'h-4 w-8',
        'sm' => 'h-5 w-9',
        'md' => 'h-6 w-11',
        'lg' => 'h-7 w-14',
        'xl' => 'h-8 w-16',
    ];
    
    $thumbSizes = [
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-4 w-4',
        'lg' => 'h-5 w-5',
        'xl' => 'h-6 w-6',
    ];
    
    $translations = [
        'xs' => 'translate-x-4',
        'sm' => 'translate-x-4',
        'md' => 'translate-x-6',
        'lg' => 'translate-x-7',
        'xl' => 'translate-x-8',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $thumbClass = $thumbSizes[$size] ?? $thumbSizes['md'];
    $translateClass = $translations[$size] ?? $translations['md'];
    $uniqueId = $id ?? 'toggle-' . uniqid();
@endphp

<button 
    type="button"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    x-data="{ on: @entangle($attributes->wire('model')) }"
    @click="on = !on"
    :class="on ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"
    class="relative inline-flex {{ $sizeClass }} items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:ring-offset-2"
    role="switch"
    :aria-checked="on"
>
    <span 
        :class="on ? '{{ $translateClass }}' : 'translate-x-1'"
        class="inline-block {{ $thumbClass }} transform rounded-full bg-white transition-transform"
    ></span>
</button>
