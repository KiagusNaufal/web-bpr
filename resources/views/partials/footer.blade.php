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

            {{-- Ikon Media Sosial & WhatsApp --}}
            <div class="mt-6 flex items-center gap-3">
                <a href="{{ $profile->whatsapp_url ?: 'https://wa.me/' }}" target="_blank" rel="noopener" aria-label="WhatsApp" title="WhatsApp" class="inline-flex h-10 w-10 items-center justify-center border border-white/20 bg-white/5 text-white transition-colors hover:border-accent hover:bg-accent">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.52 3.48A11.82 11.82 0 0 0 12.05 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.87 11.87 0 0 0 5.75 1.47h.01c6.55 0 11.89-5.34 11.89-11.9 0-3.18-1.24-6.16-3.43-8.44zM12.05 21.8h-.01a9.87 9.87 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.85 9.85 0 0 1-1.51-5.27c0-5.45 4.44-9.89 9.9-9.89 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 0 1 2.9 6.99c0 5.46-4.44 9.9-9.9 9.9zm5.43-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35z"/>
                    </svg>
                </a>
                <a href="{{ $profile->facebook_url ?: 'https://facebook.com' }}" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook" class="inline-flex h-10 w-10 items-center justify-center border border-white/20 bg-white/5 text-white transition-colors hover:border-accent hover:bg-accent">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                    </svg>
                </a>
                <a href="{{ $profile->instagram_url ?: 'https://instagram.com' }}" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram" class="inline-flex h-10 w-10 items-center justify-center border border-white/20 bg-white/5 text-white transition-colors hover:border-accent hover:bg-accent">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="{{ $profile->tiktok_url ?: 'https://tiktok.com' }}" target="_blank" rel="noopener" aria-label="TikTok" title="TikTok" class="inline-flex h-10 w-10 items-center justify-center border border-white/20 bg-white/5 text-white transition-colors hover:border-accent hover:bg-accent">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                    </svg>
                </a>
            </div>
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
