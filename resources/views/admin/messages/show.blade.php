<x-layouts.admin :title="'Detail Pesan: '.$message->subject">
    <div class="max-w-3xl border border-line bg-white p-6 sm:p-8">
        <div class="flex flex-wrap items-start justify-between gap-4 border-b border-line pb-5">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">{{ $message->status->label() }}</span>
                <h2 class="mt-1 text-xl font-bold text-ink">{{ $message->subject }}</h2>
                <p class="mt-1 text-xs text-muted">Diterima pada {{ $message->created_at?->translatedFormat('d F Y, H:i') }}</p>
            </div>

            <form action="{{ route('admin.messages.status', $message) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="field !py-1.5 text-xs">
                    @foreach ($statuses as $st)
                        <option value="{{ $st->value }}" @selected($message->status === $st)>{{ $st->label() }}</option>
                    @endforeach
                </select>
                <x-button type="submit" variant="brand" class="!px-3.5 !py-2 text-xs">Simpan Status</x-button>
            </form>
        </div>

        <dl class="mt-5 grid gap-4 bg-soft p-4 text-xs sm:grid-cols-3">
            <div>
                <dt class="font-bold uppercase text-muted">Nama Pengirim</dt>
                <dd class="mt-1 text-sm font-bold text-ink">{{ $message->name }}</dd>
            </div>
            <div>
                <dt class="font-bold uppercase text-muted">Email</dt>
                <dd class="mt-1 text-sm font-medium text-ink">
                    <a href="mailto:{{ $message->email }}" class="underline">{{ $message->email }}</a>
                </dd>
            </div>
            <div>
                <dt class="font-bold uppercase text-muted">Telepon / WhatsApp</dt>
                <dd class="mt-1 text-sm font-medium text-ink">{{ $message->phone ?: '—' }}</dd>
            </div>
        </dl>

        <div class="mt-6 border-t border-line pt-6">
            <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-muted">Isi Pesan</h3>
            <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-ink">{{ $message->message }}</div>
        </div>

        <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-5">
            <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-muted hover:text-ink">&larr; Kembali ke daftar pesan</a>

            <div class="flex items-center gap-3">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.$message->subject) }}" class="inline-flex min-h-11 items-center gap-2 bg-brand-dark px-4 py-2 text-xs font-semibold text-white hover:bg-brand-deep">
                    <x-icon name="mail" class="h-4 w-4" /> Balas via Email
                </a>
                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex min-h-11 cursor-pointer items-center border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
