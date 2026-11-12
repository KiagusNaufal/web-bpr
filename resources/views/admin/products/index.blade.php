<x-layouts.admin title="Kelola Produk & Layanan">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Atur produk Tabungan, Kredit, dan Deposito beserta suku bunga, manfaat, dan persyaratan dokumen.</p>
        <x-button :href="route('admin.products.create')" icon="plus">Tambah Produk Baru</x-button>
    </div>

    {{-- Bar Filter Kategori, Status, dan Pencarian --}}
    <div class="mt-6 flex flex-col justify-between gap-4 border border-line bg-white p-4 lg:flex-row lg:items-center">
        <nav aria-label="Filter kategori produk" class="flex flex-wrap gap-2">
            <a
                href="{{ route('admin.products.index', array_filter(['status' => $activeStatus?->value, 'q' => $search])) }}"
                class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeType === null ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
            >
                Semua ({{ $counts['all'] ?? 0 }})
            </a>
            @foreach ($types as $t)
                <a
                    href="{{ route('admin.products.index', array_filter(['type' => $t->value, 'status' => $activeStatus?->value, 'q' => $search])) }}"
                    class="border px-3.5 py-2 text-xs font-bold transition-colors {{ $activeType === $t ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-soft text-ink hover:border-brand' }}"
                >
                    {{ $t->label() }} ({{ $counts[$t->value] ?? 0 }})
                </a>
            @endforeach
        </nav>

        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if ($activeType)
                <input type="hidden" name="type" value="{{ $activeType->value }}">
            @endif
            <select name="status" onchange="this.form.submit()" class="field !w-auto !py-2 text-xs font-semibold">
                <option value="">Semua Status</option>
                @foreach ($statuses as $st)
                    <option value="{{ $st->value }}" @selected($activeStatus === $st)>{{ $st->label() }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-1.5">
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari nama produk..."
                    class="field !w-48 !py-2 text-xs"
                >
                <button type="submit" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white hover:bg-brand-deep">
                    Cari
                </button>
                @if ($activeType || $activeStatus || $search !== '')
                    <a href="{{ route('admin.products.index') }}" class="border border-line bg-soft px-3 py-2 text-xs font-semibold text-muted hover:text-ink">
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
                    <th class="px-5 py-3.5 font-semibold">Nama Produk</th>
                    <th class="px-5 py-3.5 font-semibold">Kategori</th>
                    <th class="px-5 py-3.5 font-semibold">Suku Bunga / Tenor</th>
                    <th class="px-5 py-3.5 font-semibold">Status</th>
                    <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                @forelse ($products as $product)
                    <tr class="hover:bg-soft/60">
                        <td class="px-5 py-4">
                            <p class="font-bold text-ink">{{ $product->name }}</p>
                            <p class="mt-0.5 line-clamp-1 text-xs text-muted">{{ $product->summary }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="border border-line bg-soft px-2.5 py-1 text-xs font-bold text-brand-dark">{{ $product->type->label() }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-muted">
                            <div>Bunga: <strong class="text-ink">{{ $product->rate_info ?: '—' }}</strong></div>
                            <div>Tenor: <strong class="text-ink">{{ $product->tenor_info ?: '—' }}</strong></div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold {{ $product->status === \App\Enums\PublishStatus::Published ? 'bg-brand/15 text-brand-dark' : 'bg-line text-muted' }}">
                                {{ $product->status->label() }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('products.show', $product) }}" target="_blank" class="text-xs font-semibold text-muted hover:text-ink">Lihat</a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold text-brand-dark hover:underline">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Tidak ada produk yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
