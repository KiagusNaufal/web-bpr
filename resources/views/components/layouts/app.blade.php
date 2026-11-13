@props(['title' => null, 'description' => null, 'image' => null])
@php
    $siteName = $profile->name ?? config('app.name');
    $pageTitle = $title ? $title.' — '.$siteName : $siteName.' — '.($profile->tagline ?? '');
    $pageDescription = $description ?? $profile->tagline ?? '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ Str::limit($pageDescription, 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ Str::limit($pageDescription, 200) }}">
    @if ($image)<meta property="og:image" content="{{ url($image) }}">@endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col">
    {{-- Loading Screen / Preloader --}}
    <div id="page-loader" data-loader role="status" aria-live="polite" aria-label="Memuat halaman" class="page-loader fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white">
        <div class="absolute inset-x-0 top-0 flex h-1">
            <span class="w-2/3 bg-brand"></span>
            <span class="w-1/3 bg-accent"></span>
        </div>
        <div class="loader-content flex flex-col items-center px-6 text-center">
            @if ($profile->logo_url)
                <img src="{{ $profile->logo_url }}" alt="{{ $siteName }}" width="260" height="44" class="h-11 w-auto sm:h-12">
            @else
                <span class="font-serif text-xl font-bold text-ink">{{ $siteName }}</span>
            @endif
            <div class="mt-6 h-1 w-48 overflow-hidden bg-line">
                <span class="loader-bar block h-full w-full bg-accent"></span>
            </div>
            <p class="mt-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-muted">Memuat Layanan Perbankan</p>
        </div>
    </div>
    <noscript><style>#page-loader{display:none!important}</style></noscript>

    {{-- Top Progress Bar saat pindah halaman --}}
    <div id="nav-progress" data-nav-progress aria-hidden="true" class="pointer-events-none fixed inset-x-0 top-0 z-[90] h-0.5 origin-left scale-x-0 bg-accent transition-transform duration-300"></div>

    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:bg-white focus:px-4 focus:py-2">Lewati ke konten</a>

    @include('partials.navbar')

    <main id="konten" class="flex-1">
        <x-flash />
        {{ $slot }}
    </main>

    @include('partials.footer')

    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3">
        <button type="button" data-back-to-top class="hidden h-11 w-11 cursor-pointer items-center justify-center border border-line bg-white text-ink shadow-md transition-colors hover:border-accent hover:text-brand-dark" aria-label="Kembali ke atas">
            <x-icon name="arrow-up" class="mx-auto h-5 w-5" />
        </button>

        @if ($profile->whatsapp_url)
            <a
                href="{{ $profile->whatsapp_url }}"
                target="_blank"
                rel="noopener"
                aria-label="Chat WhatsApp {{ $profile->name }}"
                class="inline-flex h-12 items-center gap-2.5 border border-brand-deep bg-brand-dark px-4 text-xs font-bold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:bg-accent hover:border-accent"
            >
                <svg class="h-5 w-5 shrink-0 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.52 3.48A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.87 11.87 0 0 0 5.75 1.47h.01c6.55 0 11.89-5.34 11.89-11.9 0-3.18-1.24-6.16-3.43-8.44zM12.05 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.85 9.85 0 0 1-1.51-5.27c0-5.45 4.44-9.89 9.9-9.89 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 0 1 2.9 6.99c0 5.46-4.44 9.9-9.9 9.9zm5.43-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35z"/>
                </svg>
                <span class="hidden sm:inline">Tanya Petugas</span>
            </a>
        @endif
    </div>
</body>
</html>
