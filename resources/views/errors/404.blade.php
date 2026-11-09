<x-layouts.app title="Halaman Tidak Ditemukan">
    <section class="py-24 lg:py-32">
        <div class="container-page max-w-2xl text-center">
            <p class="eyebrow">Kode 404</p>
            <h1 class="mt-3 text-3xl font-bold text-ink sm:text-5xl">Halaman tidak ditemukan.</h1>
            <p class="mt-4 text-sm leading-relaxed text-muted sm:text-base">
                Tautan yang Anda tuju mungkin telah dipindahkan, berubah alamat, atau tidak tersedia. Silakan kembali ke halaman utama atau pilih menu layanan di bawah ini.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <x-button :href="route('home')" icon="arrow-right">Kembali ke Beranda</x-button>
                <x-button :href="route('products.index')" variant="outline">Lihat Produk Kami</x-button>
                <x-button :href="route('contact')" variant="outline">Hubungi Kantor</x-button>
            </div>
        </div>
    </section>
</x-layouts.app>
