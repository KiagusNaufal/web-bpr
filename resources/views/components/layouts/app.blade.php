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
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:bg-white focus:px-4 focus:py-2">Lewati ke konten</a>

    @include('partials.navbar')

    <main id="konten" class="flex-1">
        <x-flash />
        {{ $slot }}
    </main>

    @include('partials.footer')

    <button type="button" data-back-to-top class="fixed bottom-6 right-6 z-40 hidden h-11 w-11 items-center justify-center rounded-md border border-line bg-white text-ink hover:border-accent" aria-label="Kembali ke atas">
        <x-icon name="arrow-up" class="mx-auto h-5 w-5" />
    </button>
</body>
</html>

