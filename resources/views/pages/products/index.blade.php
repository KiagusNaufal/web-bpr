<x-layouts.app
    title="Produk dan Layanan"
    description="Daftar lengkap produk Tabungan, Kredit, dan Deposito di {{ $profile->name }}. Ketentuan, manfaat, dan persyaratan dokumen resmi."
>
    <x-page-header
        eyebrow="Produk dan layanan"
        title="Simpanan, pembiayaan, dan deposito untuk kebutuhan Anda."
        subtitle="Pilih kategori layanan di bawah ini untuk melihat rincian manfaat, persyaratan dokumen, serta ketentuan tiap produk."
        :breadcrumbs="['Produk dan Layanan' => null]"
    >
        <x-button :href="route('home').'#simulasi'" variant="light" icon="calculator">Buka Simulasi</x-button>
    </x-page-header>

    {{-- Navigasi kategori produk --}}
    <div class="sticky top-20 z-30 border-b border-line bg-white/95 backdrop-blur-sm">
        <div class="container-page flex flex-wrap items-center justify-between gap-4 py-3">
            <nav aria-label="Kategori produk" class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ route('products.index') }}"
                    aria-current="{{ $activeType === null ? 'page' : 'false' }}"
                    class="inline-flex min-h-11 items-center border px-4 text-xs font-semibold transition-colors {{ $activeType === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                >
                    Semua Kategori
                </a>
                @foreach ($productTypes as $type)
                    <a
                        href="{{ route('products.index', ['jenis' => $type->value]) }}"
                        aria-current="{{ $activeType === $type ? 'page' : 'false' }}"
                        class="inline-flex min-h-11 items-center border px-4 text-xs font-semibold transition-colors {{ $activeType === $type ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                    >
                        {{ $type->label() }}
                    </a>
                @endforeach
            </nav>

            <a href="{{ route('contact') }}" class="link-arrow text-xs">Konsultasi dengan petugas <x-icon name="arrow-right" /></a>
        </div>
    </div>

    {{-- Sorotan poster resmi apabila menampilkan semua atau tabungan --}}
    @if ($promos->isNotEmpty() && ($activeType === null || $activeType === \App\Enums\ProductType::Tabungan))
        <section class="border-b border-line bg-soft py-12 lg:py-16">
            <div class="container-page">
                <div class="reveal max-w-2xl">
                    <p class="eyebrow">Informasi produk tabungan</p>
                    <h2 class="mt-1 text-xl font-bold sm:text-2xl">Pilihan tabungan unggulan {{ $profile->name }}</h2>
                </div>
                <div data-stagger="100" class="mt-8 grid gap-8 md:grid-cols-3">
                    @foreach ($promos as $promo)
                        <div class="reveal overflow-hidden border border-line bg-white">
                            <img src="{{ $promo->url }}" alt="{{ $promo->title }}" width="800" height="531" loading="lazy" class="aspect-[800/531] w-full object-cover">
                            <div class="p-5">
                                <h3 class="text-base font-bold text-ink">{{ $promo->title }}</h3>
                                @if ($promo->caption)
                                    <p class="mt-1 text-xs leading-relaxed text-muted">{{ $promo->caption }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Daftar produk per kategori --}}
    <div class="divide-y divide-line">
        @foreach ($productTypes as $type)
            @if ($activeType === null || $activeType === $type)
                @php
                    $items = $productGroups->get($type->value, collect());
                @endphp
                <section id="kategori-{{ $type->value }}" class="scroll-mt-32 py-16 lg:py-24">
                    <div class="container-page">
                        <div class="reveal grid gap-6 border-b-2 border-ink pb-8 lg:grid-cols-12 lg:items-end">
                            <div class="lg:col-span-7">
                                <p class="eyebrow">Kategori layanan</p>
                                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">{{ $type->label() }}</h2>
                                <p class="mt-2 max-w-xl text-sm text-muted">{{ $type->tagline() }}</p>
                            </div>
                            <div class="lg:col-span-5 lg:text-right">
                                <span class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">{{ $items->count() }} produk tersedia</span>
                            </div>
                        </div>

                        @if ($items->isEmpty())
                            <p class="py-12 text-sm text-muted">Belum ada produk pada kategori ini.</p>
                        @else
                            <div class="divide-y divide-line">
                                @foreach ($items as $product)
                                    <article id="{{ $product->slug }}" class="reveal scroll-mt-36 py-10 lg:py-12">
                                        <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
                                            {{-- Kolom kiri: Nama, ringkasan, dan gambar bila ada --}}
                                            <div class="lg:col-span-5">
                                                @if ($product->image_url)
                                                    <a href="{{ route('products.show', $product) }}" class="mb-5 block overflow-hidden border border-line bg-soft">
                                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="640" height="420" loading="lazy" class="aspect-[16/10] w-full object-cover transition-transform duration-500 hover:scale-[1.03]">
                                                    </a>
                                                @endif
                                                <span class="text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark">{{ $type->label() }}</span>
                                                <h3 class="mt-1 text-2xl font-bold">
                                                    <a href="{{ route('products.show', $product) }}" class="transition-colors hover:text-brand-dark">{{ $product->name }}</a>
                                                </h3>
                                                <p class="mt-3 text-sm leading-relaxed text-muted">{{ $product->summary }}</p>

                                                <div class="mt-6 flex flex-wrap items-center gap-4">
                                                    <x-button :href="route('products.show', $product)" variant="brand" icon="arrow-right">Detail &amp; Persyaratan</x-button>
                                                    <a href="{{ route('contact', ['subjek' => 'Konsultasi '.$product->name]) }}" class="link-arrow">Tanya petugas</a>
                                                </div>
                                            </div>

                                            {{-- Kolom kanan: Manfaat, Persyaratan singkat, & Ketentuan --}}
                                            <div class="grid gap-8 sm:grid-cols-2 lg:col-span-7">
                                                <div>
                                                    <h4 class="text-xs font-bold uppercase tracking-[0.12em] text-ink">Manfaat utama</h4>
                                                    @if (!empty($product->benefits))
                                                        <ul class="mt-4 space-y-2.5 border-l-2 border-brand pl-4 text-sm text-ink">
                                                            @foreach ($product->benefits as $benefit)
                                                                <li>{{ $benefit }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-3 text-sm text-muted">Hubungi petugas untuk penjelasan manfaat lengkap.</p>
                                                    @endif
                                                </div>

                                                <div>
                                                    <h4 class="text-xs font-bold uppercase tracking-[0.12em] text-ink">Persyaratan umum</h4>
                                                    @if (!empty($product->requirements))
                                                        <ul class="mt-4 space-y-2.5 border-l-2 border-accent pl-4 text-sm text-muted">
                                                            @foreach ($product->requirements as $req)
                                                                <li>{{ $req }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="mt-3 text-sm text-muted">Persyaratan menyesuaikan ketentuan yang berlaku di kantor layanan.</p>
                                                    @endif
                                                </div>

                                                <dl class="grid grid-cols-3 gap-4 border-t border-line pt-5 text-xs sm:col-span-2">
                                                    <div>
                                                        <dt class="font-semibold uppercase tracking-[0.1em] text-muted">Suku bunga</dt>
                                                        <dd class="mt-1 font-bold text-ink">{{ $product->rate_info ?: 'Sesuai ketentuan BPR' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-semibold uppercase tracking-[0.1em] text-muted">Jangka waktu</dt>
                                                        <dd class="mt-1 font-bold text-ink">{{ $product->tenor_info ?: 'Menyesuaikan produk' }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="font-semibold uppercase tracking-[0.1em] text-muted">Minimal dana / plafon</dt>
                                                        <dd class="mt-1 font-bold text-ink">{{ $product->min_amount_info ?: 'Hubungi kantor' }}</dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            @endif
        @endforeach
    </div>

    {{-- CTA Konsultasi --}}
    <section class="bg-brand-deep text-white">
        <div class="container-page grid items-center gap-8 py-14 lg:grid-cols-12 lg:py-16">
            <div class="lg:col-span-7">
                <h2 class="text-2xl font-bold !text-white sm:text-3xl">Belum yakin produk mana yang paling sesuai?</h2>
                <p class="mt-2 max-w-xl text-sm text-white/75">Sampaikan rencana atau kebutuhan usaha Anda. Petugas kami siap membantu memilihkan produk dengan penjelasan yang transparan.</p>
            </div>
            <div class="flex flex-wrap gap-3 lg:col-span-5 lg:justify-end">
                @if ($profile->whatsapp_url)
                    <x-button :href="$profile->whatsapp_url" target="_blank" rel="noopener" icon="message-circle">Chat WhatsApp</x-button>
                @endif
                <x-button :href="route('contact')" :variant="$profile->whatsapp_url ? 'light' : 'primary'">Hubungi Kantor</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>
