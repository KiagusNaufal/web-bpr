<x-layouts.app
    :title="$article->title"
    :description="$article->excerpt"
    :image="$article->thumbnail_url"
>
    <x-page-header
        :eyebrow="$article->category?->name ?? 'Informasi'"
        :title="$article->title"
        :subtitle="$article->published_at ? 'Diterbitkan pada '.$article->published_at->translatedFormat('d F Y') : null"
        :breadcrumbs="[
            'Informasi' => route('articles.index'),
            $article->category?->name ?? 'Artikel' => $article->category ? route('articles.index', ['kategori' => $article->category->slug]) : null,
            \Illuminate\Support\Str::limit($article->title, 40) => null,
        ]"
    />

    <article class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-8">
                @if ($article->thumbnail_url)
                    <figure class="mb-10 overflow-hidden border border-line bg-soft">
                        <img
                            src="{{ $article->thumbnail_url }}"
                            alt="{{ $article->title }}"
                            width="960"
                            height="540"
                            class="w-full object-cover"
                        >
                    </figure>
                @endif

                @if ($article->excerpt)
                    <p class="mb-8 border-l-4 border-accent pl-5 text-base font-semibold leading-relaxed text-ink sm:text-lg">
                        {{ $article->excerpt }}
                    </p>
                @endif

                <div class="space-y-5 text-base leading-relaxed text-ink/90">
                    {!! $article->body !!}
                </div>

                <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-6">
                    <a href="{{ route('articles.index') }}" class="link-arrow">
                        <x-icon name="chevron-left" /> Kembali ke daftar informasi
                    </a>
                    @if ($article->category)
                        <a href="{{ route('articles.index', ['kategori' => $article->category->slug]) }}" class="text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark hover:underline">
                            Kategori: {{ $article->category->name }}
                        </a>
                    @endif
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="border border-line bg-soft p-6">
                    <p class="eyebrow">Butuh penjelasan langsung?</p>
                    <h2 class="mt-2 text-lg font-bold text-ink">Bicara dengan petugas kami</h2>
                    <p class="mt-2 text-sm text-muted">Jika Anda memiliki pertanyaan terkait informasi atau produk kami, hubungi kantor layanan {{ $profile->name }}.</p>
                    <x-button :href="route('contact')" variant="brand" class="mt-5 w-full" icon="arrow-right">Hubungi Kami</x-button>
                </div>

                @if ($related->isNotEmpty())
                    <div class="mt-8 border border-line p-6">
                        <h2 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Informasi Terkait</h2>
                        <ul class="mt-4 divide-y divide-line">
                            @foreach ($related as $item)
                                <li class="py-4 first:pt-0 last:pb-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.1em] text-muted">
                                        {{ $item->published_at?->translatedFormat('d M Y') }} · {{ $item->category?->name }}
                                    </p>
                                    <a href="{{ route('articles.show', $item) }}" class="mt-1 block text-sm font-bold text-ink transition-colors hover:text-brand-dark">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </article>
</x-layouts.app>
