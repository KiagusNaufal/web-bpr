<x-layouts.app
    title="Produk dan Layanan"
    description="Daftar produk Tabungan, Kredit, dan Deposito di {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Produk dan layanan"
        title="Pilihan Tabungan, Kredit, dan Deposito"
        subtitle="Pilih produk untuk melihat penjelasan singkat, manfaat, dan persyaratan dokumennya."
        :breadcrumbs="['Produk dan Layanan' => null]"
    />

    <section class="py-14 lg:py-20">
        <div class="container-page">
            {{-- Filter Kategori Simpel --}}
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-line pb-6">
                <nav aria-label="Kategori produk" class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('products.index') }}"
                        class="inline-flex min-h-11 items-center border px-4 text-xs font-semibold transition-colors {{ $activeType === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                    >
                        Semua Produk
                    </a>
                    @foreach ($productTypes as $type)
                        <a
                            href="{{ route('products.index', ['jenis' => $type->value]) }}"
                            class="inline-flex min-h-11 items-center border px-4 text-xs font-semibold transition-colors {{ $activeType === $type ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                        >
                            {{ $type->label() }}
                        </a>
                    @endforeach
                </nav>

                <a href="{{ route('home').'#simulasi' }}" class="link-arrow text-xs">
                    Hitung simulasi kredit / deposito <x-icon name="arrow-right" />
                </a>
            </div>

            {{-- Grid Produk yang Bersih & Mudah Dibaca --}}
            <div class="mt-10 space-y-16">
                @foreach ($productTypes as $type)
                    @if ($activeType === null || $activeType === $type)
                        @php
                            $items = $productGroups->get($type->value, collect());
                        @endphp
                        @if ($items->isNotEmpty())
                            <div id="kategori-{{ $type->value }}">
                                <div class="flex items-baseline justify-between border-b border-line pb-3">
                                    <div>
                                        <h2 class="text-xl font-bold text-ink sm:text-2xl">{{ $type->label() }}</h2>
                                        <p class="mt-0.5 text-xs text-muted">{{ $type->tagline() }}</p>
                                    </div>
                                    <span class="text-xs font-semibold text-muted">{{ $items->count() }} produk</span>
                                </div>

                                <div data-stagger="90" class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($items as $product)
                                        <a
                                            id="{{ $product->slug }}"
                                            href="{{ route('products.show', $product) }}"
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
                                                    <span class="text-[11px] font-bold uppercase tracking-[0.12em] text-brand-dark">{{ $type->label() }}</span>
                                                    <h3 class="mt-1 text-lg font-bold text-ink transition-colors group-hover:text-brand-dark">{{ $product->name }}</h3>
                                                    <p class="mt-1.5 text-xs leading-relaxed text-muted">{{ $product->summary }}</p>
                                                </div>

                                                <span class="mt-5 inline-flex items-center gap-1.5 border-t border-line pt-3.5 text-xs font-semibold text-ink group-hover:text-brand-dark">
                                                    Lihat detail &amp; syarat <x-icon name="arrow-right" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
