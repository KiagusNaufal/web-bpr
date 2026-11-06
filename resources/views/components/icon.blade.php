@props(['name', 'class' => 'h-4 w-4'])
<i data-lucide="{{ $name }}" {{ $attributes->merge(['class' => $class]) }}></i>
