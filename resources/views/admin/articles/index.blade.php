<x-layouts.admin title="Kelola Informasi & Berita">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Kelola berita perusahaan, pengumuman, edukasi keuangan, dan dokumentasi kegiatan.</p>
        <x-button :href="route('admin.articles.create')" icon="plus">Tulis Artikel Baru</x-button>
    </div>

    <div class="mt-6 grid gap-8 lg:grid-cols-12">
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
                            <td colspan="4" class="px-5 py-8 text-center text-muted">Belum ada artikel informasi.</td>
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
            <h2 class="text-base font-bold text-ink">Kategori Informasi</h2>
            <form action="{{ route('admin.articles.categories.store') }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="name" required placeholder="Nama kategori baru..." class="field">
                <x-button type="submit" variant="brand" class="shrink-0 !px-4">Tambah</x-button>
            </form>

            <ul class="mt-5 divide-y divide-line border-t border-line text-sm">
                @foreach ($categories as $cat)
                    <li class="flex items-center justify-between py-2.5">
                        <span class="font-medium text-ink">{{ $cat->name }}</span>
                        <span class="text-xs text-muted">{{ $cat->articles_count }} artikel</span>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
</x-layouts.admin>
