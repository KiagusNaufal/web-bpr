@props(['orgChart' => null])
@php
    $imageUrl = $orgChart?->url ?: '/images/struktur-organisasi.png';
    $title = $orgChart?->title ?: 'Bagan Struktur Organisasi '.$profile->name;
@endphp

<div class="reveal">
    <figure class="overflow-hidden border border-line bg-white p-3 sm:p-6">
        <a
            href="{{ $imageUrl }}"
            target="_blank"
            rel="noopener"
            class="group relative block overflow-hidden bg-soft"
            title="Klik untuk membuka gambar ukuran penuh"
        >
            <img
                src="{{ $imageUrl }}"
                alt="{{ $title }}"
                width="1400"
                height="780"
                loading="lazy"
                class="h-auto w-full object-contain transition-transform duration-300 group-hover:scale-[1.01]"
            >
        </a>

        <figcaption class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-line pt-4 text-xs text-muted">
            <span>{{ $orgChart?->caption ?: 'Bagan Struktur Organisasi '.$profile->name }}</span>
            <a href="{{ $imageUrl }}" target="_blank" rel="noopener" class="link-arrow text-xs">
                Buka ukuran penuh <x-icon name="arrow-up-right" />
            </a>
        </figcaption>
    </figure>
</div>
