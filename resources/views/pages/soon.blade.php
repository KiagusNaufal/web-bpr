<x-layouts.app :title="$title">
    <section class="container-page py-32">
        <p class="eyebrow">Segera hadir</p>
        <h1 class="mt-3 text-4xl font-semibold">{{ $title }}</h1>
        <p class="mt-4 max-w-xl text-muted">Halaman ini sedang disiapkan pada tahap pengembangan berikutnya.</p>
        <x-button :href="route('home')" class="mt-8" variant="outline">Kembali ke Beranda</x-button>
    </section>
</x-layouts.app>
