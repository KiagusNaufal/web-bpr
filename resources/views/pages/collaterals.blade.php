<x-layouts.app
    title="Info Lelang & Penjualan Agunan"
    description="Daftar informasi lelang dan penjualan aset agunan (properti, tanah, bangunan, dan kendaraan) di {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Informasi aset"
        title="Info Lelang & Agunan"
        subtitle="Daftar aset properti dan kendaraan yang dipasarkan atau dilelang secara resmi melalui {{ $profile->name }}. Hubungi petugas kami untuk jadwal survei lokasi dan rincian dokumen."
        :breadcrumbs="['Produk dan Layanan' => route('products.index'), 'Info Lelang & Agunan' => null]"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($collaterals as $item)
                    <article class="flex flex-col border border-line bg-white transition-colors hover:border-brand">
                        @if ($item->url)
                            <div class="overflow-hidden border-b border-line bg-soft">
                                <img
                                    src="{{ $item->url }}"
                                    alt="{{ $item->title }}"
                                    width="800"
                                    height="500"
                                    loading="lazy"
                                    class="aspect-[16/10] w-full object-cover"
                                >
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div>
                                @if ($item->link_label)
                                    <span class="inline-block bg-soft px-2.5 py-1 text-[11px] font-bold uppercase tracking-[0.12em] text-brand-dark">
                                        {{ $item->link_label }}
                                    </span>
                                @endif
                                <h2 class="mt-2.5 text-lg font-bold text-ink">{{ $item->title }}</h2>
                                @if ($item->caption)
                                    <p class="mt-2 text-xs leading-relaxed text-muted">{{ $item->caption }}</p>
                                @endif
                            </div>

                            <div class="mt-6 border-t border-line pt-4">
                                <a
                                    href="{{ $profile->whatsapp_url ? $profile->whatsapp_url . '?text=' . urlencode('Halo, saya ingin menanyakan info aset/agunan: ' . $item->title) : route('contact', ['subjek' => 'Info Agunan: ' . $item->title]) }}"
                                    @if ($profile->whatsapp_url) target="_blank" rel="noopener" @endif
                                    class="link-arrow text-xs"
                                >
                                    Tanya harga &amp; survei lokasi <x-icon name="arrow-right" />
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full border border-line bg-soft p-10 text-center text-sm text-muted">
                        Saat ini belum ada daftar aset lelang/agunan yang ditampilkan. Silakan hubungi kantor kami untuk informasi terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
