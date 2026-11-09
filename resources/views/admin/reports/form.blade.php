@php
    $isEdit = $report->exists;
@endphp
<x-layouts.admin :title="$isEdit ? 'Edit Laporan Keuangan' : 'Unggah Laporan Keuangan PDF'">
    <form
        action="{{ $isEdit ? route('admin.reports.update', $report) : route('admin.reports.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-3xl space-y-6 border border-line bg-white p-6 sm:p-8"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Judul Laporan *</label>
            <input id="title" type="text" name="title" value="{{ old('title', $report->title) }}" required placeholder="Mis. Laporan Keuangan Publikasi Triwulan I 2026" class="field">
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            <div>
                <label for="type" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Jenis Laporan *</label>
                <select id="type" name="type" class="field">
                    @foreach ($types as $t)
                        <option value="{{ $t->value }}" @selected(old('type', $report->type?->value) === $t->value)>{{ $t->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tahun *</label>
                <input id="year" type="number" name="year" value="{{ old('year', $report->year) }}" min="2000" max="2100" required class="field">
            </div>

            <div>
                <label for="period" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Periode *</label>
                <input id="period" type="text" name="period" value="{{ old('period', $report->period) }}" required placeholder="Mis. Triwulan I / Tahunan" class="field">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="published_at" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tanggal Publikasi</label>
                <input id="published_at" type="date" name="published_at" value="{{ old('published_at', $report->published_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="field">
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Status *</label>
                <select id="status" name="status" class="field">
                    @foreach ($statuses as $s)
                        <option value="{{ $s->value }}" @selected(old('status', $report->status?->value) === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="file" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                Berkas Dokumen PDF {{ $isEdit ? '(Kosongkan jika tidak diganti)' : '*' }}
            </label>
            <input id="file" type="file" name="file" accept="application/pdf" {{ $isEdit ? '' : 'required' }} class="field text-xs">
            <p class="mt-1 text-xs text-muted">Hanya menerima berkas .pdf (maksimal 20 MB).</p>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-line pt-5">
            <a href="{{ route('admin.reports.index') }}" class="text-xs font-semibold text-muted hover:text-ink">&larr; Batal dan kembali</a>
            <x-button type="submit">{{ $isEdit ? 'Simpan Perubahan' : 'Unggah Laporan' }}</x-button>
        </div>
    </form>
</x-layouts.admin>
