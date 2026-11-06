<footer class="mt-auto bg-brand-deep text-white/80">
    <div class="container-page grid gap-12 py-16 md:grid-cols-12">
        <div class="md:col-span-5">
            @if ($profile->logo_url)
                <span class="inline-block bg-white px-4 py-3"><img src="{{ $profile->logo_url }}" alt="{{ $profile->name }}" class="h-9 w-auto" loading="lazy"></span>
            @else
                <p class="font-serif text-2xl font-bold text-white">{{ $profile->name }}</p>
            @endif
            <p class="mt-4 max-w-sm text-sm leading-relaxed">{{ $profile->tagline }}</p>
            <p class="mt-6 max-w-sm text-xs leading-relaxed text-white/60">{{ $profile->license_info }}</p>
        </div>

        <div class="md:col-span-4">
            <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.14em] text-white">Hubungi Kami</h2>
            <ul class="mt-5 space-y-3 text-sm">
                <li class="flex gap-3"><x-icon name="map-pin" class="mt-1 h-4 w-4 shrink-0 text-accent" /><span>{{ $profile->address }}</span></li>
                <li class="flex gap-3"><x-icon name="phone" class="mt-1 h-4 w-4 shrink-0 text-accent" /><span>{{ $profile->phone }}</span></li>
                <li class="flex gap-3"><x-icon name="mail" class="mt-1 h-4 w-4 shrink-0 text-accent" /><a href="mailto:{{ $profile->email }}" class="hover:text-white hover:underline">{{ $profile->email }}</a></li>
                <li class="flex gap-3"><x-icon name="clock" class="mt-1 h-4 w-4 shrink-0 text-accent" /><span>{{ $profile->operating_hours }}</span></li>
            </ul>
        </div>

        <div class="md:col-span-3">
            <h2 class="font-sans text-xs font-semibold uppercase tracking-[0.14em] text-white">Tautan</h2>
            <ul class="mt-5 space-y-3 text-sm">
                <li><a class="hover:text-white hover:underline" href="{{ route('products.index') }}">Produk dan Layanan</a></li>
                <li><a class="hover:text-white hover:underline" href="{{ route('about') }}">Tentang Kami</a></li>
                <li><a class="hover:text-white hover:underline" href="{{ route('articles.index') }}">Informasi</a></li>
                <li><a class="hover:text-white hover:underline" href="{{ route('reports.index') }}">Laporan Keuangan</a></li>
                <li><a class="hover:text-white hover:underline" href="{{ route('contact') }}">Kontak</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/15">
        <div class="container-page flex flex-col gap-2 py-5 text-xs text-white/60 sm:flex-row sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ $profile->name }}. Seluruh hak cipta dilindungi.</p>
            <p>Terdaftar dan diawasi sesuai ketentuan yang berlaku. [Lengkapi sesuai data resmi]</p>
        </div>
    </div>
</footer>
