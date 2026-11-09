<x-layouts.app
    title="Laporan Keuangan"
    description="Kumpulan laporan keuangan publikasi, laporan tahunan, neraca, dan laporan laba rugi resmi {{ $profile->name }} dalam format PDF."
>
    <x-page-header
        eyebrow="Transparansi informasi"
        title="Laporan Keuangan Publikasi"
        subtitle="Sebagai wujud keterbukaan informasi kepada nasabah dan publik, laporan keuangan {{ $profile->name }} dapat dilihat langsung atau diunduh dalam format PDF."
        :breadcrumbs="['Laporan Keuangan' => null]"
    />

    <section class="py-14 lg:py-20">
        <div class="container-page">
            {{-- Filter Tahun & Jenis Laporan --}}
            <form action="{{ route('reports.index') }}" method="GET" class="grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12 sm:items-end">
                <div class="sm:col-span-4">
                    <label for="filter-tahun" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.12em] text-ink">Tahun Laporan</label>
                    <select id="filter-tahun" name="tahun" class="field">
                        <option value="">Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" @selected($selectedYear === (int) $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-5">
                    <label for="filter-jenis" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.12em] text-ink">Jenis Laporan</label>
                    <select id="filter-jenis" name="jenis" class="field">
                        <option value="">Semua Jenis Laporan</option>
                        @foreach ($reportTypes as $type)
                            <option value="{{ $type->value }}" @selected($selectedType === $type)>{{ $type->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 sm:col-span-3">
                    <x-button type="submit" variant="brand" class="flex-1">Terapkan</x-button>
                    @if ($selectedYear || $selectedType)
                        <x-button :href="route('reports.index')" variant="outline">Reset</x-button>
                    @endif
                </div>
            </form>

            {{-- Daftar Laporan Keuangan Terkelompok Per Tahun --}}
            @if ($reportsByYear->isEmpty())
                <div class="mt-10 border border-line p-10 text-center">
                    <p class="text-base font-bold text-ink">Belum ada dokumen laporan keuangan yang sesuai kriteria filter.</p>
                    <p class="mt-1 text-sm text-muted">Dokumen laporan keuangan resmi diunggah dan dikelola secara berkala melalui dashboard admin.</p>
                </div>
            @else
                <div class="mt-12 space-y-14">
                    @foreach ($reportsByYear as $year => $items)
                        <section aria-labelledby="tahun-{{ $year }}">
                            <div class="flex items-baseline justify-between border-b-2 border-ink pb-3">
                                <h2 id="tahun-{{ $year }}" class="text-2xl font-bold text-ink">Tahun {{ $year }}</h2>
                                <span class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">{{ $items->count() }} dokumen</span>
                            </div>

                            <div class="divide-y divide-line border-b border-line">
                                @foreach ($items as $report)
                                    <article class="flex flex-col gap-5 py-6 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex items-start gap-4">
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center border border-line bg-soft text-brand-dark">
                                                <x-icon name="file-text" class="h-5 w-5" />
                                            </div>
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                                    <span class="font-bold uppercase tracking-[0.1em] text-brand-dark">{{ $report->type->label() }}</span>
                                                    <span class="text-muted">·</span>
                                                    <span class="font-medium text-ink">Periode: {{ $report->period }}</span>
                                                    @if ($report->file_size > 0)
                                                        <span class="text-muted">·</span>
                                                        <span class="text-muted">PDF ({{ $report->readable_size }})</span>
                                                    @endif
                                                </div>
                                                <h3 class="mt-1 text-base font-bold text-ink sm:text-lg">{{ $report->title }}</h3>
                                                @if ($report->published_at)
                                                    <p class="mt-1 text-xs text-muted">Dipublikasikan: {{ $report->published_at->translatedFormat('d F Y') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2.5 sm:shrink-0">
                                            <button
                                                type="button"
                                                data-pdf-preview="{{ route('reports.preview', $report) }}"
                                                data-pdf-title="{{ $report->title }} ({{ $report->period }} {{ $report->year }})"
                                                data-pdf-download="{{ route('reports.download', $report) }}"
                                                class="inline-flex min-h-11 cursor-pointer items-center gap-2 border border-line bg-white px-4 py-2.5 text-xs font-semibold text-ink transition-colors hover:border-brand hover:text-brand-dark"
                                            >
                                                <x-icon name="eye" class="h-4 w-4" /> Pratinjau PDF
                                            </button>
                                            <a
                                                href="{{ route('reports.download', $report) }}"
                                                class="inline-flex min-h-11 items-center gap-2 bg-brand-dark px-4 py-2.5 text-xs font-semibold text-white transition-colors hover:bg-brand-deep"
                                            >
                                                <x-icon name="download" class="h-4 w-4" /> Unduh PDF
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Dialog Modal Pratinjau PDF --}}
    <dialog data-pdf-modal class="m-auto h-[88vh] w-[94vw] max-w-5xl border-t-4 border-accent bg-white p-0 text-ink shadow-2xl backdrop:bg-ink/70">
        <div class="flex h-full flex-col">
            <div class="flex items-center justify-between gap-4 border-b border-line bg-brand-deep px-5 py-3.5 text-white">
                <h2 data-pdf-modal-title class="truncate text-sm font-bold !text-white sm:text-base">Pratinjau Laporan PDF</h2>
                <div class="flex items-center gap-2">
                    <a data-pdf-modal-download href="#" class="inline-flex min-h-11 items-center gap-1.5 bg-accent px-3.5 py-2 text-xs font-semibold text-ink hover:bg-accent-dark">
                        <x-icon name="download" class="h-4 w-4" /> Unduh
                    </a>
                    <button type="button" data-pdf-close aria-label="Tutup pratinjau" class="flex h-11 w-11 cursor-pointer items-center justify-center border border-white/30 text-white hover:bg-white hover:text-brand-deep">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>
            </div>
            <div class="relative flex-1 bg-soft">
                <iframe data-pdf-frame title="Pratinjau dokumen PDF" class="h-full w-full border-0"></iframe>
            </div>
        </div>
    </dialog>
</x-layouts.app>
