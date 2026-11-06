@php
    $links = [
        ['Beranda', 'home', 'home'],
        ['Produk', 'products.index', 'produk*'],
        ['Tentang Kami', 'about', 'tentang-kami'],
        ['Informasi', 'articles.index', 'informasi*'],
        ['Laporan Keuangan', 'reports.index', 'laporan-keuangan'],
        ['Kontak', 'contact', 'kontak'],
    ];
@endphp
<header class="sticky top-0 z-50 border-b border-line bg-white/95 backdrop-blur-sm">
    <div class="container-page flex h-[72px] items-center justify-between gap-6">
        <a href="{{ route('home') }}" class="flex items-center" aria-label="{{ $profile->name }} — Beranda">
            @if ($profile->logo_url)
                <img src="{{ $profile->logo_url }}" alt="{{ $profile->name }}" class="h-9 w-auto sm:h-10" width="240" height="40">
            @else
                <span class="font-serif text-lg font-bold text-ink">{{ $profile->name }}</span>
            @endif
        </a>

        <nav class="hidden items-center gap-7 lg:flex" aria-label="Navigasi utama">
            @foreach ($links as [$label, $route, $pattern])
                @php $active = request()->routeIs($route) || request()->is($pattern); @endphp
                <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif
                   class="inline-flex min-h-11 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ $active ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <x-button :href="route('contact')" class="hidden lg:inline-flex">Hubungi Kami</x-button>
            <button type="button" data-nav-toggle aria-expanded="false" aria-controls="menu-mobile" aria-label="Buka menu"
                    class="flex h-11 w-11 items-center justify-center rounded-md border border-line text-ink transition-colors duration-150 hover:border-brand lg:hidden">
                <x-icon name="menu" class="h-5 w-5" />
            </button>
        </div>
    </div>

    <div id="menu-mobile" data-nav-panel class="hidden border-t border-line bg-white lg:hidden">
        <nav class="container-page flex flex-col py-2" aria-label="Navigasi seluler">
            @foreach ($links as [$label, $route, $pattern])
                <a href="{{ route($route) }}" class="border-b border-line py-3.5 text-base font-medium text-ink last:border-0">{{ $label }}</a>
            @endforeach
            <x-button :href="route('contact')" class="my-4">Hubungi Kami</x-button>
        </nav>
    </div>
</header>
