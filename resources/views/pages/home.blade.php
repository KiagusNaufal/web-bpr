<x-layouts.app :image="$banners->first()?->url">
    {{-- 1. HERO — slider banner umum (dikelola admin: Media koleksi "banner") --}}
    <section data-slider class="relative overflow-hidden bg-brand-deep" aria-roledescription="carousel" aria-label="Banner utama">
        <div class="relative h-[460px] sm:h-[500px] lg:h-[560px]">
            @foreach ($banners as $i => $banner)
                <div data-slide aria-hidden="{{ $i === 0 ? 'false' : 'true' }}" class="absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}" aria-roledescription="slide" aria-label="{{ $i + 1 }} dari {{ $banners->count() }}">
                    <img src="{{ $banner->url }}" alt="" width="1600" height="900" class="hero-slide-img absolute inset-0 h-full w-full object-cover object-[50%_45%]" @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                    <div class="container-page relative flex h-full items-end pb-20 sm:items-center sm:pb-0">
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
            <div class="container-page pointer-events-none absolute inset-x-0 bottom-6 flex items-center justify-between">
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

    {{-- 2. PRODUK DAN LAYANAN — simpel, satu grid dengan filter kategori --}}
    <section class="py-16 lg:py-24" data-tabs>
        <div class="container-page">
            <div class="reveal flex flex-wrap items-end justify-between gap-5 border-b border-line pb-5">
                <div>
                    <p class="eyebrow">Produk dan layanan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Pilihan produk kami</h2>
                </div>
                <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter kategori produk">
                    <button type="button" data-filter="all" aria-pressed="true" class="tab-chip">Semua</button>
                    @foreach ($productTypes as $type)
                        <button type="button" data-filter="{{ $type->value }}" aria-pressed="false" class="tab-chip">{{ $type->label() }}</button>
                    @endforeach
                    <a href="{{ route('products.index') }}" class="link-arrow ml-2">Lihat semua <x-icon name="arrow-right" /></a>
                </div>
            </div>

            <div data-stagger="90" class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products->where('is_featured', true) as $product)
                    <a
                        href="{{ route('products.show', $product) }}"
                        data-category="{{ $product->type->value }}"
                        class="reveal group flex flex-col border border-line bg-white transition-colors duration-200 hover:border-brand"
                    >
                        @if ($product->image_url)
                            <div class="overflow-hidden border-b border-line bg-soft">
                                <img
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}"
                                    width="800"
                                    height="531"
                                    loading="lazy"
                                    class="aspect-[800/531] w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                                >
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col justify-between p-5">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-[0.12em] text-brand-dark">{{ $product->type->label() }}</span>
                                <h3 class="mt-1 text-lg font-bold text-ink transition-colors group-hover:text-brand-dark">{{ $product->name }}</h3>
                                <p class="mt-1.5 text-xs leading-relaxed text-muted">{{ $product->summary }}</p>
                            </div>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-ink group-hover:text-brand-dark">
                                Lihat detail <x-icon name="arrow-right" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                            </span>
                        </div>
                    </a>
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
                        <a href="{{ route('articles.show', $article) }}" data-category="{{ $article->category?->slug }}" class="reveal group block transition-transform duration-300 hover:-translate-y-1">
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

    {{-- 6. SIMULASI — pilih simulasi kredit atau deposito --}}
    <section id="simulasi" class="scroll-mt-20 border-t border-line bg-soft py-16 lg:py-24">
        <div data-switch="simulasi" class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="reveal lg:col-span-5">
                <p class="eyebrow">Simulasi</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Rencanakan sebelum mengajukan.</h2>
                <p class="mt-4 text-sm text-muted">Pilih jenis simulasi, lalu atur angkanya. Hasilnya hanya perkiraan awal; ketentuan resmi mengikuti penawaran petugas.</p>

                <div class="mt-8 divide-y divide-line border-y border-line" role="tablist" aria-label="Jenis simulasi">
                    <button type="button" role="tab" data-switch-target="kredit" aria-selected="true" class="sim-option">
                        <span>
                            <span class="block text-base font-bold">Simulasi kredit</span>
                            <span class="mt-0.5 block text-xs text-muted">Hitung perkiraan angsuran per bulan.</span>
                        </span>
                        <x-icon name="arrow-right" class="h-4 w-4 shrink-0" />
                    </button>
                    <button type="button" role="tab" data-switch-target="deposito" aria-selected="false" class="sim-option">
                        <span>
                            <span class="block text-base font-bold">Simulasi deposito</span>
                            <span class="mt-0.5 block text-xs text-muted">Hitung perkiraan bunga dan total dana.</span>
                        </span>
                        <x-icon name="arrow-right" class="h-4 w-4 shrink-0" />
                    </button>
                </div>
            </div>

            <div class="reveal lg:col-span-7" style="--reveal-delay: 120ms">
                <div class="border-t-4 border-accent bg-brand-deep p-7 text-white sm:p-9">
                    {{-- Panel kredit --}}
                    <div data-switch-panel="kredit" role="tabpanel">
                        <form data-simulator onsubmit="return false">
                            <h3 class="text-xl font-bold !text-white">Simulasi angsuran kredit</h3>

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
                            <x-button :href="route('contact')" class="mt-5 w-full">Konsultasi pengajuan kredit</x-button>
                        </form>
                    </div>

                    {{-- Panel deposito --}}
                    <div data-switch-panel="deposito" role="tabpanel" class="hidden">
                        <form data-deposito-sim onsubmit="return false">
                            <h3 class="text-xl font-bold !text-white">Simulasi deposito</h3>

                            <div class="mt-7 space-y-6">
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="dep-amount" class="text-sm font-semibold">Dana yang ditempatkan</label>
                                        <output data-dep="amount-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="dep-amount" data-dep="amount" type="range" min="1000000" max="1000000000" step="1000000" value="50000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>Rp 1 Jt</span><span>Rp 1 M</span></div>
                                </div>
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="dep-tenor" class="text-sm font-semibold">Jangka waktu</label>
                                        <output data-dep="tenor-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="dep-tenor" data-dep="tenor" type="range" min="1" max="24" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>1 bulan</span><span>24 bulan</span></div>
                                </div>
                                <div>
                                    <label for="dep-rate" class="mb-1.5 block text-sm font-semibold">Suku bunga per tahun (%)</label>
                                    <input id="dep-rate" data-dep="rate" type="text" inputmode="decimal" value="6" class="field !border-white/30 !bg-white/10 !text-white" aria-describedby="dep-note">
                                    <p id="dep-note" class="mt-1.5 text-xs text-white/60">Isi sesuai informasi suku bunga dari petugas.</p>
                                </div>
                            </div>

                            <dl class="mt-8 bg-white p-5 text-ink">
                                <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Perkiraan bunga (sebelum pajak)</dt>
                                <dd data-dep="interest" aria-live="polite" class="mt-1 text-3xl font-bold tabular-nums text-brand-dark">—</dd>
                                <div class="mt-4 border-t border-line pt-4 text-sm">
                                    <dt class="text-muted">Total dana di akhir jangka waktu</dt>
                                    <dd data-dep="total" class="font-semibold tabular-nums">—</dd>
                                </div>
                            </dl>
                            <p class="mt-4 text-xs text-white/60">Perhitungan bunga sederhana sebagai ilustrasi, belum memperhitungkan pajak; bukan penawaran dan tidak mengikat.</p>
                            <x-button :href="route('contact')" class="mt-5 w-full">Tanya petugas tentang deposito</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6a. TESTIMONI (dikelola admin; tampil hanya yang berstatus terbit) --}}
    @if ($testimonials->isNotEmpty())
        <section class="border-t border-line py-16 lg:py-24">
            <div class="container-page">
                <div class="reveal flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Testimoni nasabah</p>
                        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Testimonials</h2>
                    </div>
                    <p class="max-w-md text-sm text-muted">Pengalaman nasabah dan pelaku usaha yang tumbuh bersama {{ $profile->name }}.</p>
                </div>

                <div data-stagger="110" class="mt-12 grid gap-x-12 gap-y-12 md:grid-cols-2">
                    @foreach ($testimonials as $item)
                        <article class="reveal grid grid-cols-1 gap-6 sm:grid-cols-[200px_1fr] sm:items-start">
                            <div class="aspect-square w-full max-w-[220px] overflow-hidden border border-line bg-soft sm:max-w-none">
                                @if ($item->photo_url)
                                    <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" width="220" height="220" loading="lazy" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-brand-dark">
                                        {{ mb_substr($item->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex h-full flex-col justify-between pt-1">
                                <div>
                                    <span class="block font-serif text-4xl font-extrabold leading-none text-ink select-none" aria-hidden="true">&ldquo;</span>
                                    <blockquote class="mt-2 text-sm leading-relaxed text-muted">
                                        {{ $item->quote }}
                                    </blockquote>
                                </div>

                                <div class="mt-5 border-t border-line pt-3.5">
                                    <p class="text-base font-bold text-ink">{{ $item->name }}</p>
                                    @if ($item->role)
                                        <p class="mt-0.5 text-sm font-medium text-brand-dark">{{ $item->role }}</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 6c. FAQ + LOKASI --}}
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
                @if ($profile->maps_embed_url)
                    <div class="mt-6 overflow-hidden border border-line bg-soft">
                        <iframe
                            src="{{ $profile->maps_embed_url }}"
                            title="Peta lokasi {{ $profile->name }}"
                            width="100%"
                            height="240"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="block w-full border-0"
                        ></iframe>
                    </div>
                @endif
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
