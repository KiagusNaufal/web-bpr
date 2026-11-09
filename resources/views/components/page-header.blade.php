@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'breadcrumbs' => [],
])

<section class="border-b-4 border-accent bg-brand-deep py-12 text-white lg:py-16">
    <div class="container-page">
        <nav aria-label="Breadcrumb" class="text-xs font-medium text-white/70">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="transition-colors hover:text-white">Beranda</a></li>
                @foreach ($breadcrumbs as $label => $url)
                    <li aria-hidden="true" class="text-white/40">/</li>
                    <li>
                        @if ($url)
                            <a href="{{ $url }}" class="transition-colors hover:text-white">{{ $label }}</a>
                        @else
                            <span class="text-white" aria-current="page">{{ $label }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        <div class="mt-5 grid gap-6 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-8">
                @if ($eyebrow)
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">{{ $eyebrow }}</p>
                @endif
                <h1 class="mt-2 text-3xl font-bold !text-white sm:text-4xl lg:text-[2.5rem]">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($slot->isNotEmpty())
                <div class="lg:col-span-4 lg:flex lg:justify-end">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</section>
