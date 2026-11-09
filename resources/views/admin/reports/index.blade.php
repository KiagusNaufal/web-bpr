<x-layouts.admin title="Kelola Laporan Keuangan PDF">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Unggah dan kelola dokumen PDF Laporan Keuangan Publikasi, Tahunan, Neraca, dan Laba Rugi.</p>
        <x-button :href="route('admin.reports.create')" icon="plus">Unggah Laporan PDF</x-button>
    </div>

    <div class="mt-6 overflow-x-auto border border-line bg-white">
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
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Belum ada laporan keuangan yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
