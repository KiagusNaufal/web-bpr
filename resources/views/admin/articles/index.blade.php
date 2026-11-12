<x-layouts.admin title="Kelola Informasi & Berita">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Kelola berita perusahaan, pengumuman, edukasi keuangan, dan dokumentasi kegiatan.</p>
        <x-button :href="route('admin.articles.create')" icon="plus">Tulis Artikel Baru</x-button>
    </div>

    {{-- Bar Filter Kategori, Status, dan Pencarian --}}
    <div class="mt-6 flex flex-col justify-between gap-4 border border-line bg-white p-4 lg:flex-row lg:items-center">
        <nav aria-label="Filter kategori artikel" class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.articles.index', array_filter(['status' => $activeStatus?->value, 'q' => $search])) }}"
                class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeCategoryId === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
            >
                Semua Kategori
            </a>
            @foreach ($categories as $cat)
                <a
                    href="{{ route('admin.articles.index', array_filter(['category_id' => $cat->id, 'status' => $activeStatus?->value, 'q' => $search])) }}"
                    class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeCategoryId === $cat->id ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
                >
                    {{ $cat->name }} ({{ $cat->articles_count }})
                </a>
            @endforeach
        </nav>

        <form action="{{ route('admin.articles.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if ($activeCategoryId)
                <input type="hidden" name="category_id" value="{{ $activeCategoryId }}">
            @endif
            <select name="status" onchange="this.form.submit()" class="field !w-auto !py-2 text-xs font-semibold">
                <option value="">Semua Status</option>
                @foreach ($statuses as $st)
                    <option value="{{ $st->value }}" @selected($activeStatus === $st)>{{ $st->label() }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-1.5">
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari judul artikel..."
                    class="field !w-48 !py-2 text-xs"
                >
                <button type="submit" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white hover:bg-brand-deep">
                    Cari
                </button>
                @if ($activeCategoryId || $activeStatus || $search !== '')
                    <a href="{{ route('admin.articles.index') }}" class="border border-line bg-soft px-3 py-2 text-xs font-semibold text-muted hover:text-ink">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="mt-4 grid gap-6 lg:grid-cols-12">
        <div class="overflow-x-auto border border-line bg-white lg:col-span-8">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="border-b border-line bg-brand-deep text-xs uppercase tracking-[0.1em] text-white">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold">Judul Artikel</th>
                        <th class="px-5 py-3.5 font-semibold">Kategori</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($articles as $article)
                        <tr class="hover:bg-soft/60">
                            <td class="px-5 py-4">
                                <p class="font-bold text-ink">{{ $article->title }}</p>
                                <p class="mt-0.5 text-xs text-muted">{{ $article->published_at?->translatedFormat('d M Y') ?? 'Belum dijadwalkan' }}</p>
                            </td>
                            <td class="px-5 py-4 text-xs font-semibold text-brand-dark">
                                {{ $article->category?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 text-xs font-bold {{ $article->status === \App\Enums\PublishStatus::Published ? 'bg-brand/15 text-brand-dark' : 'bg-line text-muted' }}">
                                    {{ $article->status->label() }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('articles.show', $article) }}" target="_blank" class="text-xs font-semibold text-muted hover:text-ink">Lihat</a>
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-xs font-semibold text-brand-dark hover:underline">Edit</a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-muted">Tidak ada artikel yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($articles->hasPages())
                <div class="border-t border-line p-4">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        {{-- Kolom samping: Kategori --}}
        <aside class="border border-line bg-white p-6 lg:col-span-4">
            <h2 class="text-base font-bold text-ink">Tambah Kategori</h2>
            <p class="mt-1 text-xs text-muted">Buat kategori baru untuk mengelompokkan berita &amp; pengumuman.</p>
            <form action="{{ route('admin.articles.categories.store') }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="name" required placeholder="Nama kategori baru..." class="field">
                <x-button type="submit" variant="brand" class="shrink-0 !px-4">Tambah</x-button>
            </form>

            <ul class="mt-5 divide-y divide-line border-t border-line text-sm">
                @foreach ($categories as $cat)
                    <li class="flex items-center justify-between py-2.5">
                        <a href="{{ route('admin.articles.index', ['category_id' => $cat->id]) }}" class="font-medium text-ink hover:text-brand-dark hover:underline">{{ $cat->name }}</a>
                        <span class="text-xs text-muted">{{ $cat->articles_count }} artikel</span>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
</x-layouts.admin>
