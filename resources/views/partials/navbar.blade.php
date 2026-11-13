@php
    $aboutMenus = [
        ['profil', 'Profil Perusahaan'],
        ['sejarah', 'Sejarah Perusahaan'],
        ['visi-misi', 'Visi, Misi & Nilai'],
        ['struktur-organisasi', 'Struktur Organisasi'],
        ['penghargaan', 'Penghargaan'],
        ['galeri', 'Galeri Kegiatan'],
        ['karir', 'Karir & Lowongan'],
        ['kantor', 'Jaringan Kantor'],
    ];
    $productMenus = [
        [route('products.index'), 'Semua Produk & Layanan'],
        [route('products.index', ['jenis' => 'tabungan']), 'Produk Tabungan'],
        [route('products.index', ['jenis' => 'kredit']), 'Produk Kredit'],
        [route('products.index', ['jenis' => 'deposito']), 'Deposito Berjangka'],
        [route('application'), 'Formulir Pengajuan Online'],
        [route('collaterals'), 'Info Lelang & Agunan'],
    ];
    $isAboutActive = request()->routeIs('about') || request()->is('tentang-kami*');
    $isProductActive = request()->routeIs('products.*') || request()->routeIs('application') || request()->routeIs('collaterals') || request()->is('produk*');
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
            <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif
               class="inline-flex min-h-11 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('home') ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">Beranda</a>

            {{-- Dropdown Produk & Layanan --}}
            <div class="group relative">
                <a href="{{ route('products.index') }}" @if ($isProductActive) aria-current="page" @endif
                   class="inline-flex min-h-11 items-center gap-1.5 border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ $isProductActive ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">
                    <span>Produk</span>
                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </a>

                <div class="invisible absolute left-0 top-full z-50 w-56 pt-2 opacity-0 transition-all duration-150 group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:opacity-100">
                    <div class="border border-line border-t-2 border-t-accent bg-white py-1.5 shadow-lg">
                        @foreach ($productMenus as [$pUrl, $pLabel])
                            <a href="{{ $pUrl }}" class="block px-4 py-2.5 text-xs font-semibold text-ink transition-colors hover:bg-soft hover:text-brand-dark">
                                {{ $pLabel }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Dropdown Tentang Kami --}}
            <div class="group relative">
                <a href="{{ route('about', ['bagian' => 'profil']) }}" @if ($isAboutActive) aria-current="page" @endif
                   class="inline-flex min-h-11 items-center gap-1.5 border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ $isAboutActive ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">
                    <span>Tentang Kami</span>
                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </a>

                <div class="invisible absolute left-0 top-full z-50 w-56 pt-2 opacity-0 transition-all duration-150 group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:opacity-100">
                    <div class="border border-line border-t-2 border-t-accent bg-white py-1.5 shadow-lg">
                        @foreach ($aboutMenus as [$secKey, $secLabel])
                            <a
                                href="{{ route('about', ['bagian' => $secKey]) }}"
                                data-about-nav="{{ $secKey }}"
                                class="block px-4 py-2.5 text-xs font-semibold transition-colors {{ $isAboutActive && request('bagian', 'profil') === $secKey ? 'bg-soft text-brand-dark' : 'text-ink hover:bg-soft hover:text-brand-dark' }}"
                            >
                                {{ $secLabel }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="{{ route('articles.index') }}" @if (request()->routeIs('articles.*') || request()->is('informasi*')) aria-current="page" @endif
               class="inline-flex min-h-11 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('articles.*') || request()->is('informasi*') ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">Informasi</a>

            <a href="{{ route('reports.index') }}" @if (request()->routeIs('reports.*') || request()->is('laporan-keuangan*')) aria-current="page" @endif
               class="inline-flex min-h-11 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('reports.*') || request()->is('laporan-keuangan*') ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">Laporan Keuangan</a>

            <a href="{{ route('contact') }}" @if (request()->routeIs('contact') || request()->is('kontak*')) aria-current="page" @endif
               class="inline-flex min-h-11 items-center border-b-2 px-1 text-sm font-medium transition-colors duration-150 {{ request()->routeIs('contact') || request()->is('kontak*') ? 'border-accent text-ink' : 'border-transparent text-muted hover:text-ink' }}">Kontak</a>
        </nav>

        <div class="flex items-center gap-3">
            <x-button :href="route('application')" class="hidden lg:inline-flex">Ajukan Online</x-button>
            <button type="button" data-nav-toggle aria-expanded="false" aria-controls="menu-mobile" aria-label="Buka menu"
                    class="flex h-11 w-11 items-center justify-center rounded-md border border-line text-ink transition-colors duration-150 hover:border-brand lg:hidden">
                <x-icon name="menu" class="h-5 w-5" />
            </button>
        </div>
    </div>

    <div id="menu-mobile" data-nav-panel class="hidden border-t border-line bg-white lg:hidden">
        <nav class="container-page flex flex-col py-2" aria-label="Navigasi seluler">
            <a href="{{ route('home') }}" class="border-b border-line py-3.5 text-base font-medium text-ink">Beranda</a>

            <details class="border-b border-line py-2">
                <summary class="flex cursor-pointer list-none items-center justify-between py-1.5 text-base font-medium text-ink marker:hidden [&::-webkit-details-marker]:hidden">
                    <span>Produk &amp; Pengajuan</span>
                    <svg class="h-4 w-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </summary>
                <div class="mt-1 flex flex-col border-l-2 border-brand pl-4 pb-2">
                    @foreach ($productMenus as [$pUrl, $pLabel])
                        <a href="{{ $pUrl }}" class="py-2 text-sm font-medium text-muted hover:text-brand-dark">
                            {{ $pLabel }}
                        </a>
                    @endforeach
                </div>
            </details>

            <details class="border-b border-line py-2">
                <summary class="flex cursor-pointer list-none items-center justify-between py-1.5 text-base font-medium text-ink marker:hidden [&::-webkit-details-marker]:hidden">
                    <span>Tentang Kami</span>
                    <svg class="h-4 w-4 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </summary>
                <div class="mt-1 flex flex-col border-l-2 border-brand pl-4 pb-2">
                    @foreach ($aboutMenus as [$secKey, $secLabel])
                        <a href="{{ route('about', ['bagian' => $secKey]) }}" data-about-nav="{{ $secKey }}" class="py-2 text-sm font-medium text-muted hover:text-brand-dark">
                            {{ $secLabel }}
                        </a>
                    @endforeach
                </div>
            </details>

            <a href="{{ route('articles.index') }}" class="border-b border-line py-3.5 text-base font-medium text-ink">Informasi</a>
            <a href="{{ route('reports.index') }}" class="border-b border-line py-3.5 text-base font-medium text-ink">Laporan Keuangan</a>
            <a href="{{ route('complaint') }}" class="border-b border-line py-3.5 text-base font-medium text-ink">Pengaduan Nasabah</a>
            <a href="{{ route('contact') }}" class="border-b border-line py-3.5 text-base font-medium text-ink">Kontak</a>
            <x-button :href="route('application')" class="my-4">Ajukan Online</x-button>
        </nav>
    </div>
</header>
