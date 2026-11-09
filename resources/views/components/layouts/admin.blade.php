@props(['title' => 'Dashboard Admin'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} — Admin {{ $profile->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-soft text-ink antialiased">
    <div class="flex min-h-screen flex-col lg:flex-row">
        {{-- Sidebar Navigasi Admin --}}
        <aside class="w-full shrink-0 border-b border-line bg-brand-deep text-white lg:w-64 lg:border-b-0 lg:border-r">
            <div class="flex items-center justify-between border-b border-white/15 px-6 py-5">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <span class="block text-[10px] font-bold uppercase tracking-[0.16em] text-accent">Panel Pengelola</span>
                    <span class="mt-0.5 block text-base font-bold text-white">{{ $profile->name }}</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-white/75 hover:text-white lg:hidden">
                    Website <x-icon name="external-link" class="h-3.5 w-3.5" />
                </a>
            </div>

            <nav aria-label="Menu Admin" class="flex gap-1 overflow-x-auto p-3 lg:flex-col lg:space-y-1 lg:p-4">
                @foreach ([
                    ['admin.dashboard', 'admin.dashboard', 'layout-dashboard', 'Ringkasan'],
                    ['admin.products.index', 'admin.products.*', 'package', 'Produk & Layanan'],
                    ['admin.articles.index', 'admin.articles.*', 'newspaper', 'Informasi & Berita'],
                    ['admin.reports.index', 'admin.reports.*', 'file-text', 'Laporan Keuangan'],
                    ['admin.profile.edit', 'admin.profile.*', 'building-2', 'Profil & Beranda'],
                    ['admin.messages.index', 'admin.messages.*', 'inbox', 'Pesan Masuk'],
                ] as [$routeName, $pattern, $icon, $label])
                    @php $active = request()->routeIs($pattern); @endphp
                    <a
                        href="{{ route($routeName) }}"
                        class="flex min-h-11 shrink-0 items-center gap-3 px-3.5 py-2.5 text-xs font-semibold transition-colors lg:text-sm {{ $active ? 'border-l-4 border-accent bg-white/12 text-white' : 'text-white/75 hover:bg-white/8 hover:text-white' }}"
                    >
                        <x-icon :name="$icon" class="h-4 w-4 shrink-0 {{ $active ? 'text-accent' : '' }}" />
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="hidden border-t border-white/15 p-4 lg:mt-auto lg:block">
                <a href="{{ route('home') }}" target="_blank" class="flex min-h-11 items-center justify-between border border-white/25 px-3.5 py-2 text-xs font-semibold text-white/85 transition-colors hover:bg-white hover:text-brand-deep">
                    <span>Lihat Website Publik</span>
                    <x-icon name="external-link" class="h-4 w-4" />
                </a>
            </div>
        </aside>

        {{-- Area Konten Utama --}}
        <div class="flex flex-1 flex-col">
            <header class="border-b border-line bg-white px-6 py-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h1 class="text-lg font-bold text-ink sm:text-xl">{{ $title }}</h1>

                    <div class="flex items-center gap-4">
                        @auth
                            <div class="text-right text-xs">
                                <p class="font-bold text-ink">{{ auth()->user()->name }}</p>
                                <p class="text-muted">{{ auth()->user()->role->label() }}</p>
                            </div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex min-h-11 cursor-pointer items-center gap-1.5 border border-line bg-white px-3.5 py-2 text-xs font-semibold text-ink transition-colors hover:border-red-600 hover:text-red-700">
                                    <x-icon name="log-out" class="h-4 w-4" /> Keluar
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <x-flash />

            @if ($errors->any())
                <div class="border-b border-red-200 bg-red-50 px-6 py-3 text-xs font-medium text-red-800" role="alert">
                    <p class="font-bold">Periksa kembali isian formulir:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
