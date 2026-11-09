@php
    $isEdit = $article->exists;
@endphp
<x-layouts.admin :title="$isEdit ? 'Edit Artikel: '.$article->title : 'Tulis Artikel Baru'">
    <form
        action="{{ $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-4xl space-y-6 border border-line bg-white p-6 sm:p-8"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Judul Artikel *</label>
            <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" required class="field">
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            <div>
                <label for="category_id" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Kategori</label>
                <select id="category_id" name="category_id" class="field">
                    <option value="">— Pilih Kategori —</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected((int) old('category_id', $article->category_id) === $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Status *</label>
                <select id="status" name="status" class="field">
                    @foreach ($statuses as $s)
                        <option value="{{ $s->value }}" @selected(old('status', $article->status?->value) === $s->value)>{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="published_at" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tanggal Terbit</label>
                <input id="published_at" type="date" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="field">
            </div>
        </div>

        <div>
            <label for="excerpt" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Ringkasan Singkat (Excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="2" class="field" placeholder="Ringkasan 1-2 kalimat yang tampil pada daftar artikel">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <div>
            <label for="body" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Isi Artikel *</label>
            <textarea id="body" name="body" rows="10" required class="field">{{ old('body', $article->body) }}</textarea>
            <p class="mt-1 text-xs text-muted">Mendukung paragraf teks maupun tag HTML standar (&lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;li&gt;).</p>
        </div>

        <div>
            <label for="thumbnail" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Gambar Sampul (Thumbnail)</label>
            <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="field text-xs">
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-line pt-5">
            <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-muted hover:text-ink">&larr; Batal dan kembali</a>
            <x-button type="submit">{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}</x-button>
        </div>
    </form>
</x-layouts.admin>
