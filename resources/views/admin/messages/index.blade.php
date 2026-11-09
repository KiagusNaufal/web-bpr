<x-layouts.admin title="Pesan Kontak & Konsultasi Masuk">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <nav aria-label="Filter status pesan" class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.messages.index') }}"
                class="border px-3.5 py-2 text-xs font-bold {{ $activeStatus === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand' }}"
            >
                Semua Pesan
            </a>
            @foreach ($statuses as $st)
                <a
                    href="{{ route('admin.messages.index', ['status' => $st->value]) }}"
                    class="border px-3.5 py-2 text-xs font-bold {{ $activeStatus === $st ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand' }}"
                >
                    {{ $st->label() }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="mt-6 overflow-x-auto border border-line bg-white">
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
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Tidak ada pesan kontak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
