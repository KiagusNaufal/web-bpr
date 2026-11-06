@props(['href' => null, 'variant' => 'primary', 'type' => 'button', 'icon' => null])
@php
    $variants = [
        'primary' => 'bg-accent text-ink hover:bg-accent-dark border border-accent hover:border-accent-dark',
        'outline' => 'border border-ink text-ink hover:bg-ink hover:text-white',
        'light' => 'border border-white/70 text-white hover:bg-white hover:text-brand-deep',
        'brand' => 'bg-brand-dark text-white border border-brand-dark hover:bg-brand-deep hover:border-brand-deep',
    ];
    $classes = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-md px-6 py-3 text-sm font-semibold transition-all duration-150 active:translate-y-px disabled:cursor-not-allowed disabled:opacity-60 '.($variants[$variant] ?? $variants['primary']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }} @if ($icon)<x-icon :name="$icon" />@endif</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }} @if ($icon)<x-icon :name="$icon" />@endif</button>
@endif
