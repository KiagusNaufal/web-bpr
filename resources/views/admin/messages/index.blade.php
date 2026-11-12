<x-layouts.admin title="Pesan Kontak & Konsultasi Masuk">
    <div class="flex flex-col justify-between gap-4 border border-line bg-white p-4 lg:flex-row lg:items-center">
        <nav aria-label="Filter status pesan" class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.messages.index', array_filter(['q' => $search ?? ''])) }}"
                class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeStatus === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
            >
                Semua Pesan
            </a>
            @foreach ($statuses as $st)
                <a
                    href="{{ route('admin.messages.index', array_filter(['status' => $st->value, 'q' => $search ?? ''])) }}"
                    class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeStatus === $st ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
                >
                    {{ $st->label() }}
                </a>
            @endforeach
        </nav>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-1.5">
            @if ($activeStatus)
                <input type="hidden" name="status" value="{{ $activeStatus->value }}">
            @endif
            <input
                type="search"
                name="q"
                value="{{ $search ?? '' }}"
                placeholder="Cari pengirim / subjek..."
                class="field !w-52 !py-2 text-xs"
            >
            <button type="submit" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white hover:bg-brand-deep">
                Cari
            </button>
            @if ($activeStatus || ($search ?? '') !== '')
                <a href="{{ route('admin.messages.index') }}" class="border border-line bg-soft px-3 py-2 text-xs font-semibold text-muted hover:text-ink">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="mt-4 overflow-x-auto border border-line bg-white">
        <table class="w-full min-w-[680px] text-left text-sm">
            <thead class="border-b border-line bg-brand-deep text-xs uppercase tracking-[0.1em] text-white">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Pengirim</th>
                    <th class="px-5 py-3.5 font-semibold">Subjek &amp; Ringkasan</th>
                    <th class="px-5 py-3.5 font-semibold">Waktu</th>
                    <th class="px-5 py-3.5 font-semibold">Status</th>
                    <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($messages as $msg)
                    <tr class="hover:bg-soft/60">
                        <td class="px-5 py-4">
                            <p class="font-bold text-ink">{{ $msg->name }}</p>
                            <p class="text-xs text-muted">{{ $msg->email }} {{ $msg->phone ? '· '.$msg->phone : '' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-semibold text-brand-dark">{{ $msg->subject }}</p>
                            <p class="mt-0.5 line-clamp-1 text-xs text-muted">{{ $msg->message }}</p>
                        </td>
                        <td class="px-5 py-4 text-xs text-muted">
                            {{ $msg->created_at?->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold {{ $msg->status === \App\Enums\MessageStatus::New ? 'bg-accent text-ink' : 'bg-soft text-brand-dark' }}">
                                {{ $msg->status->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-bold text-brand-dark hover:underline">Buka Pesan</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Tidak ada pesan kontak yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
