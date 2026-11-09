<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk Administrator — {{ $profile->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col justify-center bg-brand-deep px-5 py-12 text-ink antialiased">
    <div class="mx-auto w-full max-w-md border-t-4 border-accent bg-white p-8 shadow-xl sm:p-10">
        <div class="flex items-center justify-between border-b border-line pb-5">
            <div>
                <p class="eyebrow">Panel Pengelola</p>
                <h1 class="mt-1 text-xl font-bold text-ink">{{ $profile->name }}</h1>
            </div>
            @if ($profile->logo_url)
                <img src="{{ $profile->logo_url }}" alt="{{ $profile->name }}" width="96" height="40" class="h-9 w-auto object-contain">
            @endif
        </div>

        @if (session('error') || session('success'))
            <div class="mt-5 border p-3 text-xs font-medium {{ session('error') ? 'border-red-200 bg-red-50 text-red-800' : 'border-brand/30 bg-soft text-brand-deep' }}">
                {{ session('error') ?? session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="mt-6 space-y-5" novalidate>
            @csrf
            <div>
                <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="admin@bpr.test"
                    class="field @error('email') !border-red-600 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Kata Sandi</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="field @error('password') !border-red-600 @enderror"
                >
                @error('password')
                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="inline-flex cursor-pointer items-center gap-2 text-muted">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 accent-brand-dark">
                    <span>Ingat sesi masuk</span>
                </label>
                <a href="{{ route('home') }}" class="font-semibold text-brand-dark hover:underline">Ke Beranda</a>
            </div>

            <x-button type="submit" class="w-full" icon="arrow-right">Masuk ke Dashboard</x-button>
        </form>
    </div>
</body>
</html>
