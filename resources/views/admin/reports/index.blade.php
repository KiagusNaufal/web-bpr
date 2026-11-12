<x-layouts.admin title="Kelola Laporan Keuangan PDF">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Unggah dan kelola dokumen PDF Laporan Keuangan Publikasi, Tahunan, Neraca, dan Laba Rugi.</p>
        <x-button :href="route('admin.reports.create')" icon="plus">Unggah Laporan PDF</x-button>
    </div>

    {{-- Bar Filter Jenis Laporan, Tahun, dan Pencarian --}}
    <div class="mt-6 flex flex-col justify-between gap-4 border border-line bg-white p-4 lg:flex-row lg:items-center">
        <nav aria-label="Filter jenis laporan" class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.reports.index', array_filter(['year' => $activeYear, 'q' => $search])) }}"
                class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeType === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
            >
                Semua Jenis
            </a>
            @foreach ($types as $t)
                <a
                    href="{{ route('admin.reports.index', array_filter(['type' => $t->value, 'year' => $activeYear, 'q' => $search])) }}"
                    class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeType === $t ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
                >
                    {{ $t->label() }}
                </a>
            @endforeach
        </nav>

        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if ($activeType)
                <input type="hidden" name="type" value="{{ $activeType->value }}">
            @endif
            <select name="year" onchange="this.form.submit()" class="field !w-auto !py-2 text-xs font-semibold">
                <option value="">Semua Tahun</option>
                @foreach ($years as $yr)
                    <option value="{{ $yr }}" @selected($activeYear === (int) $yr)>Tahun {{ $yr }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-1.5">
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari judul / periode..."
                    class="field !w-48 !py-2 text-xs"
                >
                <button type="submit" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white hover:bg-brand-deep">
                    Cari
                </button>
                @if ($activeType || $activeYear || $search !== '')
                    <a href="{{ route('admin.reports.index') }}" class="border border-line bg-soft px-3 py-2 text-xs font-semibold text-muted hover:text-ink">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="mt-4 overflow-x-auto border border-line bg-white">
        <table class="w-full min-w-[680px] text-left text-sm">
            <thead class="border-b border-line bg-brand-deep text-xs uppercase tracking-[0.1em] text-white">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Judul Laporan</th>
                    <th class="px-5 py-3.5 font-semibold">Jenis</th>
                    <th class="px-5 py-3.5 font-semibold">Tahun / Periode</th>
                    <th class="px-5 py-3.5 font-semibold">Status</th>
                    <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($reports as $report)
                    <tr class="hover:bg-soft/60">
                        <td class="px-5 py-4">
                            <p class="font-bold text-ink">{{ $report->title }}</p>
                            <p class="mt-0.5 text-xs text-muted">Ukuran: {{ $report->readable_size }} · Terbit: {{ $report->published_at?->translatedFormat('d M Y') ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-4 text-xs font-semibold text-brand-dark">
                            {{ $report->type->label() }}
                        </td>
                        <td class="px-5 py-4 text-xs">
                            <strong class="text-ink">{{ $report->year }}</strong> · {{ $report->period }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold {{ $report->status === \App\Enums\PublishStatus::Published ? 'bg-brand/15 text-brand-dark' : 'bg-line text-muted' }}">
                                {{ $report->status->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('reports.download', $report) }}" class="text-xs font-semibold text-muted hover:text-ink">Unduh</a>
                                <a href="{{ route('admin.reports.edit', $report) }}" class="text-xs font-semibold text-brand-dark hover:underline">Edit</a>
                                <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Hapus laporan keuangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Tidak ada laporan keuangan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
