<x-layouts.app
    title="Informasi & Berita"
    description="Berita perusahaan, pengumuman resmi, edukasi keuangan, dan dokumentasi kegiatan {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Pusat informasi"
        title="Kabar, pengumuman, dan edukasi keuangan."
        subtitle="Ikuti perkembangan terbaru, pengumuman layanan operasional, serta tips pengelolaan keuangan untuk keluarga dan usaha."
        :breadcrumbs="['Informasi' => null]"
    />

    <section class="py-14 lg:py-20">
        <div class="container-page">
            {{-- Baris Filter Kategori & Pencarian --}}
            <div class="flex flex-col gap-5 border-b border-line pb-8 lg:flex-row lg:items-center lg:justify-between">
                <nav aria-label="Kategori artikel" class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('articles.index', $search !== '' ? ['cari' => $search] : []) }}"
                        class="inline-flex min-h-11 items-center border px-4 text-xs font-semibold transition-colors {{ $activeCategory === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                    >
                        Semua
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('articles.index', array_filter(['kategori' => $category->slug, 'cari' => $search ?: null])) }}"
                            class="inline-flex min-h-11 items-center gap-1.5 border px-4 text-xs font-semibold transition-colors {{ $activeCategory?->id === $category->id ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                        >
                            <span>{{ $category->name }}</span>
                            <span class="opacity-70">({{ $category->articles_count }})</span>
                        </a>
                    @endforeach
                </nav>

                <form action="{{ route('articles.index') }}" method="GET" role="search" class="flex w-full max-w-sm items-center gap-2">
                    @if ($activeCategory)
                        <input type="hidden" name="kategori" value="{{ $activeCategory->slug }}">
                    @endif
                    <label for="cari-artikel" class="sr-only">Cari artikel</label>
                    <input
                        id="cari-artikel"
                        type="search"
                        name="cari"
                        value="{{ $search }}"
                        placeholder="Cari judul atau topik..."
                        class="field"
                    >
                    <x-button type="submit" variant="brand" class="shrink-0 !px-4" aria-label="Cari">
                        <x-icon name="search" class="h-4 w-4" />
                    </x-button>
                </form>
            </div>

            @if ($search !== '' || $activeCategory)
                <div class="mt-6 flex flex-wrap items-center justify-between gap-3 bg-soft px-4 py-3 text-xs text-muted">
                    <p>
                        Menampilkan hasil
                        @if ($activeCategory) pada kategori <strong class="text-ink">{{ $activeCategory->name }}</strong>@endif
                        @if ($search !== '') untuk kata kunci <strong class="text-ink">&ldquo;{{ $search }}&rdquo;</strong>@endif
                        ({{ $articles->total() }} artikel)
                    </p>
                    <a href="{{ route('articles.index') }}" class="font-semibold text-brand-dark underline">Reset filter</a>
                </div>
            @endif

            @if ($articles->isEmpty())
                <div class="my-12 border border-line bg-soft p-10 text-center">
                    <p class="text-base font-bold text-ink">Tidak ada artikel yang ditemukan.</p>
                    <p class="mt-1 text-sm text-muted">Silakan gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                    <x-button :href="route('articles.index')" variant="outline" class="mt-5">Lihat Semua Informasi</x-button>
                </div>
            @else
                <div data-stagger="95" class="mt-10 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <article class="reveal group flex flex-col border-b border-line pb-8">
                            <a href="{{ route('articles.show', $article) }}" class="block overflow-hidden border border-line bg-soft">
                                @if ($article->thumbnail_url)
                                    <img
                                        src="{{ $article->thumbnail_url }}"
                                        alt="{{ $article->title }}"
                                        width="640"
                                        height="400"
                                        loading="lazy"
                                        class="aspect-[16/10] w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    >
                                @else
                                    <div class="flex aspect-[16/10] items-center justify-center px-6 text-center text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark">
                                        {{ $article->category?->name ?? 'Informasi' }}
                                    </div>
                                @endif
                            </a>

                            <div class="mt-4 flex items-center gap-2 text-xs text-muted">
                                @if ($article->published_at)
                                    <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d F Y') }}</time>
                                @endif
                                @if ($article->category)
                                    <span aria-hidden="true">·</span>
                                    <span class="font-semibold text-brand-dark">{{ $article->category->name }}</span>
                                @endif
                            </div>

                            <h2 class="mt-2 text-lg font-bold leading-snug">
                                <a href="{{ route('articles.show', $article) }}" class="transition-colors group-hover:text-brand-dark">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            @if ($article->excerpt)
                                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-muted">{{ $article->excerpt }}</p>
                            @endif

                            <div class="mt-auto pt-4">
                                <a href="{{ route('articles.show', $article) }}" class="link-arrow text-xs">Baca selengkapnya <x-icon name="arrow-right" /></a>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($articles->hasPages())
                    <div class="mt-12 border-t border-line pt-8">
                        {{ $articles->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
</x-layouts.app>
