@php
    $isEdit = $product->exists;
@endphp
<x-layouts.admin :title="$isEdit ? 'Edit Produk: '.$product->name : 'Tambah Produk Baru'">
    <form
        action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-4xl space-y-6 border border-line bg-white p-6 sm:p-8"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-5 sm:grid-cols-12">
            <div class="sm:col-span-6">
                <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nama Produk *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required class="field">
            </div>

            <div class="sm:col-span-3">
                <label for="type" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Kategori *</label>
                <select id="type" name="type" class="field">
                    @foreach ($types as $t)
                        <option value="{{ $t->value }}" @selected(old('type', $product->type?->value) === $t->value)>{{ $t->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-3">
                <label for="status" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Status *</label>
                <select id="status" name="status" class="field">
                    @foreach ($statuses as $s)
                        <option value="{{ $s->value }}" @selected(old('status', $product->status?->value) === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="summary" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Ringkasan Singkat *</label>
            <input id="summary" type="text" name="summary" value="{{ old('summary', $product->summary) }}" required class="field" placeholder="Satu kalimat penjelasan utama produk">
        </div>

        <div>
            <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Penjelasan Lengkap</label>
            <textarea id="description" name="description" rows="4" class="field">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid gap-5 border-y border-line py-5 sm:grid-cols-4">
            <div>
                <label for="rate_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Suku Bunga</label>
                <input id="rate_info" type="text" name="rate_info" value="{{ old('rate_info', $product->rate_info) }}" class="field" placeholder="Mis. Sesuai ketentuan">
            </div>
            <div>
                <label for="tenor_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Jangka Waktu</label>
                <input id="tenor_info" type="text" name="tenor_info" value="{{ old('tenor_info', $product->tenor_info) }}" class="field" placeholder="Mis. 1 - 60 bulan">
            </div>
            <div>
                <label for="min_amount_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Minimal Dana / Plafon</label>
                <input id="min_amount_info" type="text" name="min_amount_info" value="{{ old('min_amount_info', $product->min_amount_info) }}" class="field" placeholder="Mis. Rp 50.000">
            </div>
            <div>
                <label for="fee_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Biaya Administrasi</label>
                <input id="fee_info" type="text" name="fee_info" value="{{ old('fee_info', $product->fee_info) }}" class="field" placeholder="Mis. Bebas biaya bulanan">
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="benefits_text" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Manfaat Utama (satu per baris)</label>
                <textarea id="benefits_text" name="benefits_text" rows="5" class="field" placeholder="Setoran awal ringan&#10;Dijamin LPS">{{ old('benefits_text', implode("\n", $product->benefits ?? [])) }}</textarea>
            </div>

            <div>
                <label for="requirements_text" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Persyaratan Dokumen (satu per baris)</label>
                <textarea id="requirements_text" name="requirements_text" rows="5" class="field" placeholder="Fotokopi KTP&#10;NPWP (jika ada)">{{ old('requirements_text', implode("\n", $product->requirements ?? [])) }}</textarea>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-12">
            <div class="sm:col-span-6">
                <label for="terms" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Ketentuan Tambahan</label>
                <input id="terms" type="text" name="terms" value="{{ old('terms', $product->terms) }}" class="field">
            </div>

            <div class="sm:col-span-4">
                <label for="image" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Gambar / Poster Produk</label>
                <input id="image" type="file" name="image" accept="image/*" class="field text-xs">
            </div>

            <div class="sm:col-span-2">
                <label for="sort_order" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Urutan</label>
                <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0" class="field">
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-line pt-5">
            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-muted hover:text-ink">&larr; Batal dan kembali</a>
            <x-button type="submit">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' }}</x-button>
        </div>
    </form>
</x-layouts.admin>
