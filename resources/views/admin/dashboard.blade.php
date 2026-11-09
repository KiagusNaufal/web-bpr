<x-layouts.admin title="Ringkasan Dashboard">
    {{-- Kartu Statistik Utama --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ([
            ['Total Produk', $stats['products'], route('admin.products.index'), 'Kelola produk'],
            ['Artikel Informasi', $stats['articles'], route('admin.articles.index'), 'Kelola berita'],
            ['Laporan Keuangan', $stats['reports'], route('admin.reports.index'), 'Kelola PDF'],
            ['Testimoni Nasabah', $stats['testimonials'], route('admin.profile.edit').'#testimoni', 'Kelola testimoni'],
            ['Pesan Baru', $stats['unread_messages'], route('admin.messages.index'), 'Lihat pesan masuk'],
        ] as [$label, $count, $url, $cta])
            <a href="{{ $url }}" class="border border-line border-t-4 border-t-brand-dark bg-white p-5 transition-colors hover:border-t-accent">
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-muted">{{ $label }}</p>
                <p class="mt-2 text-3xl font-extrabold tabular-nums text-ink">{{ $count }}</p>
                <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-brand-dark">
                    {{ $cta }} <x-icon name="arrow-right" class="h-3.5 w-3.5" />
                </span>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-12">
        {{-- Pesan Kontak Terbaru --}}
        <section class="border border-line bg-white lg:col-span-7">
            <div class="flex items-center justify-between border-b border-line px-6 py-4">
                <div>
                    <h2 class="text-base font-bold text-ink">Pesan Kontak &amp; Konsultasi Terbaru</h2>
                    <p class="text-xs text-muted">Pesan yang dikirim pengunjung dari halaman Kontak Kami</p>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-brand-dark hover:underline">Lihat semua</a>
            </div>

            <div class="divide-y divide-line">
                @forelse ($recentMessages as $msg)
                    <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-start justify-between gap-4 px-6 py-4 transition-colors hover:bg-soft/60">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-ink">{{ $msg->name }}</span>
                                @if ($msg->status === \App\Enums\MessageStatus::New)
                                    <span class="bg-accent px-2 py-0.5 text-[10px] font-bold uppercase text-ink">Baru</span>
                                @endif
                            </div>
                            <p class="mt-0.5 text-xs font-semibold text-brand-dark">{{ $msg->subject }}</p>
                            <p class="mt-1 line-clamp-1 text-xs text-muted">{{ $msg->message }}</p>
                        </div>
                        <span class="shrink-0 text-[11px] text-muted">{{ $msg->created_at?->diffForHumans() }}</span>
                    </a>
                @empty
                    <p class="p-6 text-sm text-muted">Belum ada pesan masuk dari pengunjung.</p>
                @endforelse
            </div>
        </section>

        {{-- Pintasan Cepat & Artikel Terbaru --}}
        <div class="space-y-8 lg:col-span-5">
            <section class="border border-line bg-white p-6">
                <h2 class="text-base font-bold text-ink">Tindakan Cepat</h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <x-button :href="route('admin.products.create')" variant="brand" class="w-full !justify-start" icon="plus">Tambah Produk</x-button>
                    <x-button :href="route('admin.articles.create')" variant="brand" class="w-full !justify-start" icon="plus">Tulis Artikel</x-button>
                    <x-button :href="route('admin.reports.create')" variant="outline" class="w-full !justify-start" icon="plus">Unggah Laporan PDF</x-button>
                    <x-button :href="route('admin.profile.edit')" variant="outline" class="w-full !justify-start" icon="pencil">Edit Profil &amp; Banner</x-button>
                </div>
            </section>

            <section class="border border-line bg-white">
                <div class="flex items-center justify-between border-b border-line px-6 py-4">
                    <h2 class="text-base font-bold text-ink">Artikel Informasi Terbaru</h2>
                    <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-brand-dark hover:underline">Semua</a>
                </div>
                <ul class="divide-y divide-line">
                    @forelse ($recentArticles as $art)
                        <li class="flex items-center justify-between gap-3 px-6 py-3.5">
                            <div>
                                <p class="text-sm font-semibold text-ink">{{ $art->title }}</p>
                                <p class="text-xs text-muted">{{ $art->category?->name ?? 'Tanpa kategori' }} · {{ $art->status->label() }}</p>
                            </div>
                            <a href="{{ route('admin.articles.edit', $art) }}" class="text-xs font-semibold text-brand-dark hover:underline">Edit</a>
                        </li>
                    @empty
                        <li class="p-6 text-sm text-muted">Belum ada artikel.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </div>
</x-layouts.admin>
