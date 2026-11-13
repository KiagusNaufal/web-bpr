<x-layouts.admin title="Pesan, Pengajuan Online & Pengaduan Nasabah">
    <div class="flex flex-col justify-between gap-4 border border-line bg-white p-4 lg:flex-row lg:items-center">
        <div class="flex flex-wrap items-center gap-2">
            {{-- Filter Kategori Pesan --}}
            @foreach ([
                [null, 'Semua Jenis'],
                ['pengajuan', 'Pengajuan Produk'],
                ['pengaduan', 'Pengaduan Nasabah'],
                ['umum', 'Pesan Umum'],
            ] as [$catVal, $catLabel])
                <a
                    href="{{ route('admin.messages.index', array_filter(['category' => $catVal, 'status' => $activeStatus?->value, 'q' => $search ?? ''])) }}"
                    class="border px-3.5 py-2 text-xs font-bold transition-colors {{ ($activeCategory ?? null) === $catVal ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
                >
                    {{ $catLabel }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if ($activeCategory ?? null)
                <input type="hidden" name="category" value="{{ $activeCategory }}">
            @endif
            <select name="status" onchange="this.form.submit()" class="field !w-auto !py-2 text-xs font-semibold">
                <option value="">Semua Status</option>
                @foreach ($statuses as $st)
                    <option value="{{ $st->value }}" @selected($activeStatus === $st)>{{ $st->label() }}</option>
                @endforeach
            </select>
            <input
                type="search"
                name="q"
                value="{{ $search ?? '' }}"
                placeholder="Cari pengirim / subjek..."
                class="field !w-48 !py-2 text-xs"
            >
            <button type="submit" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white hover:bg-brand-deep">
                Cari
            </button>
            @if (($activeCategory ?? null) || $activeStatus || ($search ?? '') !== '')
                <a href="{{ route('admin.messages.index') }}" class="border border-line bg-soft px-3 py-2 text-xs font-semibold text-muted hover:text-ink">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="mt-4 overflow-x-auto border border-line bg-white">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-line bg-brand-deep text-xs uppercase tracking-[0.1em] text-white">
                <tr>
                    <th class="px-5 py-3.5 font-semibold">Pengirim</th>
                    <th class="px-5 py-3.5 font-semibold">Jenis &amp; Subjek</th>
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
                            @php
                                $catBadge = match ($msg->category ?? 'umum') {
                                    'pengajuan' => ['bg-brand/15 text-brand-dark', 'Pengajuan Online'],
                                    'pengaduan' => ['bg-red-100 text-red-800', 'Pengaduan Nasabah'],
                                    default => ['bg-soft text-muted', 'Pesan Umum'],
                                };
                            @endphp
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase {{ $catBadge[0] }}">{{ $catBadge[1] }}</span>
                            <p class="mt-1 font-semibold text-brand-dark">{{ $msg->subject }}</p>
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
                            <div class="inline-flex items-center gap-3">
                                @if ($msg->phone)
                                    @php
                                        $waNum = preg_replace('/^0/', '62', preg_replace('/\D/', '', $msg->phone));
                                    @endphp
                                    <a href="https://wa.me/{{ $waNum }}" target="_blank" rel="noopener" class="text-xs font-bold text-brand-dark hover:underline">Chat WA</a>
                                @endif
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-bold text-ink hover:underline">Detail</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Tidak ada data pesan/pengajuan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
