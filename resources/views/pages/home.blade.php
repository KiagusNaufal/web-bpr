@php
    $fallbacks = ['/images/demo/vendor.jpg', '/images/demo/market.jpg', '/images/demo/stall.jpg'];
    $typeLabels = collect($productTypes)->mapWithKeys(fn ($t) => [$t->value => $t->label()]);
@endphp
<x-layouts.app :image="$banners->first()?->url">

    {{-- 1. HERO — slider banner dengan animasi Ken Burns, teks bertahap, & progress bar --}}
    <section data-slider class="relative overflow-hidden bg-brand-deep" aria-roledescription="carousel" aria-label="Banner utama">
        <div class="relative h-[460px] sm:h-[500px] lg:h-[560px]">
            @foreach ($banners as $i => $banner)
                <div data-slide aria-hidden="{{ $i === 0 ? 'false' : 'true' }}" class="absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}" aria-roledescription="slide" aria-label="{{ $i + 1 }} dari {{ $banners->count() }}">
                    <img src="{{ $banner->url }}" alt="" width="1600" height="900" class="hero-slide-img absolute inset-0 h-full w-full object-cover object-[50%_45%]" @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                    <div class="container-page relative flex h-full items-end pb-16 sm:items-center sm:pb-0">
                        <div class="hero-slide-box max-w-xl border-l-4 border-accent bg-brand-deep/90 p-6 text-white sm:p-9">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-white/70">{{ $profile->name }}</p>
                            <h1 class="mt-3 text-2xl font-bold !text-white sm:text-4xl lg:text-[2.6rem]">{{ $banner->title }}</h1>
                            <p class="mt-4 text-sm text-white/80 sm:text-base">{{ $banner->caption }}</p>
                            @if ($banner->link_url)
                                <div>
                                    <x-button :href="url($banner->link_url)" class="mt-6" icon="arrow-right">{{ $banner->link_label ?? 'Selengkapnya' }}</x-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($banners->count() > 1)
            <div class="container-page pointer-events-none absolute inset-x-0 bottom-16 flex items-center justify-between">
                <div class="pointer-events-auto flex gap-2" role="group" aria-label="Pilih slide">
                    @foreach ($banners as $i => $banner)
                        <button type="button" data-dot aria-label="Slide {{ $i + 1 }}: {{ $banner->title }}" class="group flex h-11 w-11 items-center justify-center">
                            <span class="relative h-1.5 w-8 overflow-hidden bg-white/35">
                                <span class="dot-fill block h-full w-full bg-accent opacity-0 group-aria-[current=true]:opacity-100"></span>
                            </span>
                        </button>
                    @endforeach
                </div>
                <div class="pointer-events-auto flex gap-2">
                    <button type="button" data-prev aria-label="Slide sebelumnya" class="flex h-11 w-11 items-center justify-center border border-white/60 text-white transition-all duration-200 hover:-translate-x-0.5 hover:bg-white hover:text-brand-deep"><x-icon name="chevron-left" class="h-5 w-5" /></button>
                    <button type="button" data-next aria-label="Slide berikutnya" class="flex h-11 w-11 items-center justify-center border border-white/60 text-white transition-all duration-200 hover:translate-x-0.5 hover:bg-white hover:text-brand-deep"><x-icon name="chevron-right" class="h-5 w-5" /></button>
                </div>
            </div>
        @endif
    </section>

    {{-- 2. AKSES CEPAT --}}
    <section class="relative z-10 -mt-10" aria-label="Akses cepat">
        <div class="container-page">
        <ul data-stagger="70" class="grid grid-cols-2 divide-line border border-line border-t-4 border-t-accent bg-white shadow-xs sm:grid-cols-3 sm:divide-x lg:grid-cols-5 lg:divide-x [&>li]:border-b [&>li]:border-line lg:[&>li]:border-b-0">
            @foreach ([
                ['Produk Kami', 'landmark', route('products.index')],
                ['Simulasi Kredit', 'calculator', '#simulasi'],
                ['Suku Bunga', 'percent', '#suku-bunga'],
                ['Laporan Keuangan', 'file-text', route('reports.index')],
                ['Lokasi Kantor', 'map-pin', route('contact')],
            ] as [$label, $icon, $href])
                <li class="reveal">
                    <a href="{{ $href }}" class="group relative flex items-center gap-3 overflow-hidden px-4 py-5 text-sm font-semibold text-ink transition-colors duration-200 hover:bg-soft hover:text-brand-dark sm:justify-center">
                        <x-icon :name="$icon" class="h-5 w-5 text-brand transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:scale-110" />
                        <span>{{ $label }}</span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-accent transition-transform duration-300 group-hover:scale-x-100" aria-hidden="true"></span>
                    </a>
                </li>
            @endforeach
        </ul>
        </div>
    </section>

@php
    $typeMeta = [
        'tabungan' => ['piggy-bank', false],
        'kredit' => ['hand-coins', true],
        'deposito' => ['calendar-clock', false],
    ];
@endphp
    {{-- 3. PRODUK — tiga kategori, tipografis (dengan stagger & hover lift) --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <div class="reveal flex flex-wrap items-end justify-between gap-5">
                <div class="max-w-2xl">
                    <p class="eyebrow">Produk dan layanan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Tiga kebutuhan utama, satu tempat yang sama.</h2>
                </div>
                <a href="{{ route('products.index') }}" class="link-arrow">Semua produk <x-icon name="arrow-right" /></a>
            </div>

            <div data-stagger="110" class="mt-12 grid gap-6 lg:grid-cols-3 lg:items-stretch">
                @foreach ($productGroups as $type => $items)
                    @php
                        [$icon, $featured] = $typeMeta[$type];
                        $enum = \App\Enums\ProductType::from($type);
                        $firstItem = $items->first();
                    @endphp
                    <article class="reveal group/card flex flex-col border border-t-4 p-7 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg sm:p-9 {{ $featured ? 'border-brand-dark border-t-accent bg-brand-dark text-white lg:-my-4 lg:py-12' : 'border-line border-t-brand bg-white' }}">
                        <div class="flex items-center justify-between gap-4">
                            <span class="flex h-12 w-12 items-center justify-center transition-transform duration-300 group-hover/card:scale-110 {{ $featured ? 'bg-white/15 text-white' : 'bg-soft text-brand-dark' }}"><x-icon :name="$icon" class="h-6 w-6" /></span>
                            <span class="border px-2.5 py-1 text-xs font-semibold uppercase tracking-[0.12em] {{ $featured ? 'border-accent/80 bg-accent text-ink' : 'border-line bg-soft text-brand-dark' }}">
                                {{ $featured ? 'Unggulan · ' : '' }}{{ $items->count() }} Pilihan
                            </span>
                        </div>
                        <h3 class="mt-6 text-2xl font-bold {{ $featured ? '!text-white' : '' }}">{{ $enum->label() }}</h3>
                        <p class="mt-2 text-sm {{ $featured ? 'text-white/80' : 'text-muted' }}">{{ $enum->tagline() }}</p>

                        @if ($firstItem && !empty($firstItem->benefits))
                            <ul class="mt-5 space-y-2 border-t pt-4 text-xs {{ $featured ? 'border-white/20 text-white/90' : 'border-line text-muted' }}">
                                @foreach (array_slice($firstItem->benefits, 0, 2) as $benefit)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 {{ $featured ? 'bg-accent' : 'bg-brand' }}" aria-hidden="true"></span>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <ul class="mt-6 flex-1 divide-y text-sm {{ $featured ? 'divide-white/20 border-y border-white/20' : 'divide-line border-y border-line' }}">
                            @foreach ($items->take(6) as $product)
                                <li>
                                    <a href="{{ route('products.index', ['jenis' => $type]) }}#{{ $product->slug }}" class="group/item flex min-h-11 items-center justify-between gap-3 py-2.5 transition-colors duration-150 {{ $featured ? 'hover:text-accent' : 'hover:text-brand-dark' }}">
                                        <span class="font-semibold transition-transform duration-200 group-hover/item:translate-x-1">{{ $product->name }}</span>
                                        <x-icon name="chevron-right" class="shrink-0 transition-transform duration-200 group-hover/item:translate-x-1 {{ $featured ? 'text-white/60 group-hover/item:text-accent' : 'text-muted group-hover/item:text-brand-dark' }}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <x-button :href="route('products.index', ['jenis' => $type])" :variant="$featured ? 'primary' : 'outline'" class="mt-7 w-full justify-between" icon="arrow-right">Pelajari {{ strtolower($enum->label()) }}</x-button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3b. ALUR PENGAJUAN (dengan animasi garis penghubung bertahap) --}}
    <section class="border-y border-line bg-soft py-16 lg:py-20">
        <div class="container-page">
            <div class="reveal grid gap-6 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <p class="eyebrow">Alur pengajuan kredit</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Empat langkah, tanpa kejutan.</h2>
                </div>
                <p class="text-sm text-muted lg:col-span-5 lg:col-start-8 lg:self-end">Tahapan umum. Rincian dokumen dan waktu proses dapat berbeda tiap produk; petugas akan menjelaskannya.</p>
            </div>
            <ol data-stagger="130" class="mt-12 grid gap-10 md:grid-cols-4 md:gap-0">
                @foreach ([
                    ['Konsultasi', 'Ceritakan kebutuhan Anda kepada petugas, langsung atau lewat WhatsApp.'],
                    ['Pengajuan berkas', 'Lengkapi dokumen sesuai persyaratan produk yang dipilih.'],
                    ['Survei dan analisis', 'Petugas memverifikasi data dan menilai kemampuan bayar.'],
                    ['Keputusan dan pencairan', 'Anda menerima keputusan dan penjelasan akad sebelum dana dicairkan.'],
                ] as $n => [$title, $text])
                    <li class="reveal group relative md:pr-8">
                        <div class="flex items-center gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center border-2 border-brand-dark bg-white text-sm font-bold text-brand-dark transition-all duration-200 group-hover:border-accent group-hover:bg-accent group-hover:text-ink">{{ $n + 1 }}</span>
                            @unless ($loop->last)<span class="step-line hidden h-px flex-1 bg-brand-dark/40 md:block" aria-hidden="true"></span>@endunless
                        </div>
                        <h3 class="mt-5 text-lg font-bold transition-colors duration-200 group-hover:text-brand-dark">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 4. BANNER LEBAR — cerita --}}
    <section class="relative isolate overflow-hidden">
        <img src="/images/demo/market.jpg" alt="" loading="lazy" class="absolute inset-0 -z-10 h-full w-full object-cover object-[50%_40%]">
        <div class="absolute inset-0 -z-10 bg-brand-deep/80"></div>
        <div class="container-page grid gap-10 py-20 text-white lg:grid-cols-12 lg:py-28">
            <div class="reveal lg:col-span-7">
                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">Dekat dengan masyarakat</p>
                <h2 class="mt-4 text-3xl font-bold !text-white sm:text-4xl">Usaha kecil adalah tulang punggung ekonomi daerah. Kami hadir untuk menopangnya.</h2>
                <p class="mt-6 max-w-xl text-white/80">Pedagang pasar, pelaku UMKM, petani, hingga keluarga yang menyiapkan masa depan membutuhkan layanan keuangan yang mudah dijangkau dan dijelaskan dengan bahasa yang jelas.</p>
                <x-button :href="route('about')" class="mt-8" icon="arrow-right">Kenali Kami</x-button>
            </div>
            <ol data-stagger="90" class="grid gap-px self-end bg-white/25 lg:col-span-5">
                @foreach (['Layanan tatap muka dan kunjungan petugas', 'Persyaratan dan biaya dijelaskan terbuka', 'Laporan keuangan dipublikasikan', 'Tahapan pengajuan yang terarah'] as $n => $text)
                    <li class="reveal flex gap-4 bg-brand-deep/90 px-5 py-4 text-sm font-medium transition-colors duration-200 hover:bg-brand-dark"><span class="font-bold text-accent">{{ sprintf('%02d', $n + 1) }}</span>{{ $text }}</li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 5. INFORMASI (tab kategori dengan animasi filter halus) --}}
    @if ($articles->isNotEmpty())
        <section class="py-16 lg:py-24" data-tabs>
            <div class="container-page">
                <div class="reveal flex flex-wrap items-end justify-between gap-5 border-b border-line pb-5">
                    <div>
                        <p class="eyebrow">Informasi</p>
                        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Kabar dan edukasi keuangan</h2>
                    </div>
                    <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter informasi">
                        <button type="button" data-filter="all" aria-pressed="true" class="tab-chip">Semua</button>
                        @foreach ($articleCategories as $cat)
                            <button type="button" data-filter="{{ $cat->slug }}" aria-pressed="false" class="tab-chip">{{ $cat->name }}</button>
                        @endforeach
                        <a href="{{ route('articles.index') }}" class="link-arrow ml-3">Lihat semua</a>
                    </div>
                </div>

                <div data-stagger="95" class="mt-10 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.index') }}" data-category="{{ $article->category?->slug }}" class="reveal group block transition-transform duration-300 hover:-translate-y-1">
                            <div class="overflow-hidden bg-soft">
                                @if ($article->thumbnail_url)
                                    <img src="{{ $article->thumbnail_url }}" alt="" loading="lazy" class="aspect-[16/10] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex aspect-[16/10] items-center justify-center border border-line text-xs font-semibold text-muted transition-colors duration-200 group-hover:border-brand">{{ $article->category?->name }}</div>
                                @endif
                            </div>
                            <p class="mt-4 text-xs text-muted"><time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d F Y') }}</time> · <span class="font-semibold text-brand-dark">{{ $article->category?->name }}</span></p>
                            <h3 class="mt-1 text-base font-bold transition-colors duration-200 group-hover:text-brand-dark group-hover:underline">{{ $article->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 6. SUKU BUNGA + SIMULASI (dengan animasi angka real-time saat slider digeser) --}}
    <section class="border-t border-line bg-soft py-16 lg:py-24">
        <div class="container-page">
            <div class="reveal max-w-2xl">
                <p class="eyebrow">Suku bunga dan simulasi</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Rencanakan sebelum mengajukan.</h2>
                <p class="mt-3 text-sm text-muted">Angka resmi dikelola admin dan bisa berubah sewaktu-waktu. Untuk ketentuan terbaru, hubungi petugas kami.</p>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-12 lg:items-start">
                <div id="suku-bunga" data-tabs class="reveal scroll-mt-28 bg-white lg:col-span-7">
                    <div class="flex flex-wrap items-center justify-between gap-3 border border-b-0 border-line p-4">
                        <h3 class="text-lg font-bold">Tabel suku bunga</h3>
                        <div class="flex flex-wrap gap-2" role="group" aria-label="Filter jenis produk">
                            <button type="button" data-filter="all" aria-pressed="true" class="tab-chip">Semua</button>
                            @foreach ($productTypes as $type)
                                <button type="button" data-filter="{{ $type->value }}" aria-pressed="false" class="tab-chip">{{ $type->label() }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="overflow-x-auto border border-line">
                        <table class="w-full min-w-[520px] text-left text-sm">
                            <caption class="sr-only">Suku bunga, tenor, dan minimal dana tiap produk</caption>
                            <thead class="bg-brand-dark text-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-semibold">Produk</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Suku bunga</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Tenor</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Minimal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-line">
                                @foreach ($rateRows as $item)
                                    <tr data-category="{{ $item->type->value }}" class="transition-colors duration-150 odd:bg-white even:bg-soft/60 hover:bg-soft">
                                        <th scope="row" class="px-4 py-3.5 font-semibold">
                                            {{ $item->name }}
                                            <span class="block text-[11px] font-medium uppercase tracking-[0.1em] text-brand-dark">{{ $item->type->label() }}</span>
                                        </th>
                                        @foreach ([$item->rate_info, $item->tenor_info, $item->min_amount_info] as $value)
                                            <td class="px-4 py-3.5 {{ $value ? 'font-semibold text-ink' : 'text-muted' }}">{{ $value ?: 'Hubungi kantor' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="border border-t-0 border-line px-4 py-3 text-xs text-muted">Suku bunga dapat berubah sesuai ketentuan yang berlaku di BPR.</p>
                </div>

                <div id="simulasi" class="reveal scroll-mt-28 lg:col-span-5" style="--reveal-delay: 120ms">
                    <form data-simulator onsubmit="return false" class="border-t-4 border-accent bg-brand-deep p-7 text-white sm:p-9">
                        <div class="flex items-center gap-3">
                            <x-icon name="calculator" class="h-6 w-6 text-accent" />
                            <h3 class="text-xl font-bold !text-white">Simulasi angsuran kredit</h3>
                        </div>

                        <div class="mt-7 space-y-6">
                            <div>
                                <div class="flex items-baseline justify-between">
                                    <label for="sim-amount" class="text-sm font-semibold">Jumlah pinjaman</label>
                                    <output data-sim="amount-label" class="text-sm font-bold text-accent"></output>
                                </div>
                                <input id="sim-amount" data-sim="amount" type="range" min="1000000" max="500000000" step="1000000" value="25000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                <div class="flex justify-between text-[11px] text-white/60"><span>Rp 1 Jt</span><span>Rp 500 Jt</span></div>
                            </div>
                            <div>
                                <div class="flex items-baseline justify-between">
                                    <label for="sim-tenor" class="text-sm font-semibold">Jangka waktu</label>
                                    <output data-sim="tenor-label" class="text-sm font-bold text-accent"></output>
                                </div>
                                <input id="sim-tenor" data-sim="tenor" type="range" min="3" max="120" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                <div class="flex justify-between text-[11px] text-white/60"><span>3 bulan</span><span>120 bulan</span></div>
                            </div>
                            <div>
                                <label for="sim-rate" class="mb-1.5 block text-sm font-semibold">Suku bunga per tahun (%)</label>
                                <input id="sim-rate" data-sim="rate" type="text" inputmode="decimal" value="12" class="field !border-white/30 !bg-white/10 !text-white" aria-describedby="sim-note">
                                <p id="sim-note" class="mt-1.5 text-xs text-white/60">Isi sesuai penawaran petugas.</p>
                            </div>
                        </div>

                        <dl class="mt-8 bg-white p-5 text-ink">
                            <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Angsuran per bulan</dt>
                            <dd data-sim="result" aria-live="polite" class="mt-1 text-3xl font-bold tabular-nums text-brand-dark">—</dd>
                            <div class="mt-4 grid grid-cols-2 gap-4 border-t border-line pt-4 text-sm">
                                <div><dt class="text-muted">Total bunga</dt><dd data-sim="interest" class="font-semibold tabular-nums">—</dd></div>
                                <div><dt class="text-muted">Total pembayaran</dt><dd data-sim="total" class="font-semibold tabular-nums">—</dd></div>
                            </div>
                        </dl>
                        <p class="mt-4 text-xs text-white/60">Perhitungan anuitas sebagai ilustrasi; bukan penawaran dan tidak mengikat.</p>
                        <x-button :href="route('contact')" class="mt-5 w-full">Konsultasi pengajuan</x-button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- 6b. FAQ + LOKASI --}}
    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-14 lg:grid-cols-12 lg:gap-20">
            <div class="reveal lg:col-span-7">
                <p class="eyebrow">Pertanyaan umum</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Yang sering ditanyakan</h2>
                <div class="mt-8 divide-y divide-line border-y border-line">
                    @foreach ([
                        ['Dokumen apa yang perlu disiapkan?', 'Persyaratan berbeda tiap produk dan tercantum di halaman produk. Petugas juga dapat menjelaskannya lewat telepon atau WhatsApp.'],
                        ['Bagaimana cara membuka rekening tabungan?', 'Datang ke kantor kami pada jam layanan dengan membawa identitas diri dan setoran awal sesuai ketentuan produk.'],
                        ['Di mana saya bisa melihat laporan keuangan?', 'Laporan publikasi resmi tersedia pada halaman Laporan Keuangan dan dapat dilihat atau diunduh dalam bentuk PDF.'],
                        ['Apakah simulasi angsuran bersifat mengikat?', 'Tidak. Simulasi hanya perkiraan berdasarkan angka yang Anda masukkan. Ketentuan resmi mengikuti penawaran dan akad kredit.'],
                    ] as [$q, $a])
                        <details class="group py-2">
                            <summary class="flex min-h-11 cursor-pointer list-none items-center justify-between gap-4 py-2 font-semibold transition-colors duration-150 hover:text-brand-dark marker:hidden [&::-webkit-details-marker]:hidden">
                                {{ $q }}
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center border border-line text-lg leading-none text-brand-dark transition-all duration-200 group-open:rotate-90 group-open:border-accent group-open:bg-accent group-open:text-ink" aria-hidden="true"><span class="group-open:hidden">+</span><span class="hidden group-open:inline">−</span></span>
                            </summary>
                            <div class="faq-body">
                                <div>
                                    <p class="pb-4 max-w-2xl text-sm text-muted">{{ $a }}</p>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>

            <aside class="reveal lg:col-span-5" style="--reveal-delay: 120ms">
                <p class="eyebrow">Lokasi kantor</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Kunjungi kami</h2>
                <ul class="mt-8 divide-y divide-line border border-line">
                    @forelse ($branches as $branch)
                        <li class="p-5 transition-colors duration-200 hover:bg-soft/60">
                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark">{{ ucfirst($branch->type) }}</p>
                            <h3 class="mt-1 text-lg font-bold">{{ $branch->name }}</h3>
                            <p class="mt-2 text-sm text-muted">{{ $branch->address }}</p>
                            <p class="mt-1 text-sm text-muted">{{ $branch->operating_hours }}</p>
                            @if ($branch->maps_url)
                                <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="link-arrow mt-3">Buka peta <x-icon name="arrow-up-right" /></a>
                            @endif
                        </li>
                    @empty
                        <li class="p-5 text-sm text-muted">Informasi kantor akan segera tersedia.</li>
                    @endforelse
                </ul>
                <a href="{{ route('contact') }}" class="link-arrow mt-6">Semua kontak dan jam layanan <x-icon name="arrow-right" /></a>
            </aside>
        </div>
    </section>

    {{-- 7. CTA --}}
    <section class="bg-brand-deep text-white">
        <div class="container-page reveal grid items-center gap-8 py-14 lg:grid-cols-12 lg:py-16">
            <div class="lg:col-span-7">
                <h2 class="text-2xl font-bold !text-white sm:text-3xl">Ada rencana yang ingin diwujudkan? Mari bicarakan.</h2>
                <p class="mt-3 max-w-xl text-white/75">Petugas kami siap menjelaskan produk, persyaratan, dan langkah berikutnya.</p>
            </div>
            <div class="flex flex-wrap gap-3 lg:col-span-5 lg:justify-end">
                @if ($profile->whatsapp_url)
                    <x-button :href="$profile->whatsapp_url" target="_blank" rel="noopener" icon="message-circle">WhatsApp</x-button>
                @endif
                <x-button :href="route('contact')" :variant="$profile->whatsapp_url ? 'light' : 'primary'">Hubungi Kami</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>
