<x-layouts.admin title="Kelola Produk & Layanan">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-muted">Atur produk Tabungan, Kredit, dan Deposito beserta suku bunga, manfaat, dan persyaratan dokumen.</p>
        <x-button :href="route('admin.products.create')" icon="plus">Tambah Produk Baru</x-button>
    </div>

    <div class="mt-6 overflow-x-auto border border-line bg-white">
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
                        <td colspan="5" class="px-5 py-8 text-center text-muted">Belum ada produk yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
