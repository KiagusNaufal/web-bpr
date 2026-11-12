@php
    $sections = [
        'profil' => 'Profil Perusahaan',
        'sejarah' => 'Sejarah Perusahaan',
        'visi-misi' => 'Visi, Misi & Nilai',
        'struktur-organisasi' => 'Struktur Organisasi',
        'penghargaan' => 'Penghargaan',
        'kantor' => 'Jaringan Kantor',
    ];
    $currentSection = $activeSection ?? 'profil';
    $sectionTitle = $sections[$currentSection] ?? 'Profil Perusahaan';
@endphp

<x-layouts.app
    :title="$sectionTitle . ' — Tentang Kami'"
    description="Profil perusahaan, sejarah, visi dan misi, struktur organisasi, penghargaan, serta jaringan kantor {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Tentang kami"
        :title="$profile->name"
        :subtitle="$profile->tagline"
        :breadcrumbs="['Tentang Kami' => route('about'), $sectionTitle => null]"
    />

    {{-- 1. PROFIL PERUSAHAAN --}}
    <section id="profil" data-about-panel="profil" class="{{ $currentSection === 'profil' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-6">
                <p class="eyebrow">Profil perusahaan</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Hadir melayani masyarakat dan pelaku usaha dengan pendekatan yang dekat.</h2>
                <div class="mt-5 space-y-4 text-sm leading-relaxed text-ink/90 sm:text-base">
                    {!! nl2br(e($profile->about)) !!}
                </div>

                @if ($profile->license_info)
                    <div class="mt-8 border-l-4 border-accent bg-soft p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Perizinan &amp; Pengawasan</p>
                        <p class="mt-1.5 text-sm font-medium text-ink">{{ $profile->license_info }}</p>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-6">
                <div class="overflow-hidden border border-line bg-soft">
                    <img
                        src="{{ $profile->hero_image_url ?: '/images/demo/market.jpg' }}"
                        alt="Suasana layanan {{ $profile->name }}"
                        width="800"
                        height="520"
                        loading="lazy"
                        class="aspect-[16/10] w-full object-cover"
                    >
                </div>
            </div>
        </div>
    </section>

    {{-- 2. SEJARAH PERUSAHAAN (Layout lega untuk teks panjang / banyak paragraf) --}}
    <section id="sejarah" data-about-panel="sejarah" class="{{ $currentSection === 'sejarah' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-4">
                    <p class="eyebrow">Perjalanan kami</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Sejarah Perusahaan</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Rekam jejak berdirinya {{ $profile->name }} serta perkembangan layanan kami dari masa ke masa dalam mendampingi masyarakat dan pelaku usaha.
                    </p>

                    <div class="mt-6 overflow-hidden border border-line bg-soft">
                        <img
                            src="{{ $profile->hero_image_url ?: '/images/demo/market.jpg' }}"
                            alt="{{ $profile->name }}"
                            width="600"
                            height="400"
                            loading="lazy"
                            class="aspect-[16/10] w-full object-cover"
                        >
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="border border-line border-t-4 border-t-brand-dark bg-white p-6 sm:p-10">
                        @php
                            $historyParagraphs = array_values(array_filter(array_map('trim', preg_split('/\r\n\r\n|\n\n/', (string) $profile->history))));
                        @endphp

                        @if (! empty($historyParagraphs))
                            <div class="space-y-5 text-sm leading-relaxed text-ink/90 sm:text-base sm:leading-loose">
                                @foreach ($historyParagraphs as $para)
                                    <p>{!! nl2br(e($para)) !!}</p>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-muted">Sejarah perusahaan akan segera diperbarui oleh admin.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. VISI, MISI, DAN NILAI PERUSAHAAN --}}
    <section id="visi-misi" data-about-panel="visi-misi" class="{{ $currentSection === 'visi-misi' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5">
                    <p class="eyebrow">Arah perusahaan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Visi &amp; Misi</h2>

                    <div class="mt-6 border-t-4 border-accent bg-brand-deep p-7 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">Visi</p>
                        <p class="mt-3 text-lg font-bold leading-snug !text-white">
                            {{ $profile->vision ?: '[Visi perusahaan diisi admin]' }}
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <p class="eyebrow">Langkah nyata</p>
                    <h3 class="mt-2 text-xl font-bold sm:text-2xl">Misi Kami</h3>

                    @if (!empty($profile->missions))
                        <ol class="mt-6 divide-y divide-line border-y border-line bg-white">
                            @foreach ($profile->missions as $idx => $mission)
                                <li class="flex items-start gap-5 p-5">
                                    <span class="text-sm font-extrabold text-accent">{{ sprintf('%02d', $idx + 1) }}</span>
                                    <p class="text-sm leading-relaxed text-ink sm:text-base">{{ $mission }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

            {{-- Nilai-Nilai Perusahaan --}}
            @if (!empty($profile->values))
                <div class="mt-16 border-t border-line pt-14">
                    <div class="max-w-2xl">
                        <p class="eyebrow">Budaya kerja</p>
                        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Nilai-Nilai Perusahaan</h2>
                    </div>

                    <div class="mt-8 grid gap-px border border-line bg-line sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($profile->values as $idx => $val)
                            <div class="bg-white p-6">
                                <span class="text-xs font-bold text-accent">{{ sprintf('%02d', $idx + 1) }}</span>
                                <h3 class="mt-2 text-lg font-bold text-ink">{{ $val['title'] ?? '' }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-muted">{{ $val['description'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- 4. STRUKTUR ORGANISASI (Gambar Bagan) --}}
    <section id="struktur-organisasi" data-about-panel="struktur-organisasi" class="{{ $currentSection === 'struktur-organisasi' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page">
            <div class="max-w-2xl">
                <p class="eyebrow">Tata kelola perusahaan</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Struktur Organisasi</h2>
                <p class="mt-3 text-sm text-muted">Bagan susunan organisasi {{ $profile->name }}. Klik pada gambar untuk memperbesar tampilan bagan.</p>
            </div>

            <div class="mt-8">
                @include('partials.org-chart', ['orgChart' => $orgChart])
            </div>
        </div>
    </section>

    {{-- 5. PENGHARGAAN & APRESIASI --}}
    <section id="penghargaan" data-about-panel="penghargaan" class="{{ $currentSection === 'penghargaan' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page">
            <div class="max-w-2xl">
                <p class="eyebrow">Rekam jejak &amp; apresiasi</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Penghargaan</h2>
                <p class="mt-3 text-sm text-muted">Apresiasi dan penghargaan yang diterima {{ $profile->name }} atas komitmen pelayanan, tata kelola, dan kinerja keuangan.</p>
            </div>

            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($awards as $award)
                    <article class="flex flex-col border border-line bg-white">
                        @if ($award->url)
                            <div class="overflow-hidden border-b border-line bg-soft">
                                <img
                                    src="{{ $award->url }}"
                                    alt="{{ $award->title }}"
                                    width="600"
                                    height="400"
                                    loading="lazy"
                                    class="aspect-[16/10] w-full object-cover"
                                >
                            </div>
                        @endif
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div>
                                @if ($award->link_label)
                                    <span class="inline-block bg-soft px-2.5 py-1 text-[11px] font-bold uppercase tracking-[0.12em] text-brand-dark">
                                        {{ $award->link_label }}
                                    </span>
                                @endif
                                <h3 class="mt-2.5 text-lg font-bold text-ink">{{ $award->title }}</h3>
                                @if ($award->caption)
                                    <p class="mt-2 text-xs leading-relaxed text-muted">{{ $award->caption }}</p>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full border border-line bg-soft p-8 text-center text-sm text-muted">
                        Belum ada data penghargaan yang diunggah.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 6. JARINGAN KANTOR LAYANAN --}}
    <section id="kantor" data-about-panel="kantor" class="{{ $currentSection === 'kantor' ? '' : 'hidden' }} py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Jaringan layanan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Kantor Layanan Kami</h2>
                </div>
                <a href="{{ route('contact') }}" class="link-arrow">Hubungi kantor <x-icon name="arrow-right" /></a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($branches as $branch)
                    <article class="border border-line bg-white p-6">
                        <span class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Kantor {{ ucfirst($branch->type) }}</span>
                        <h3 class="mt-1 text-lg font-bold text-ink">{{ $branch->name }}</h3>
                        <p class="mt-3 text-sm text-muted">{{ $branch->address }}</p>
                        @if ($branch->phone)
                            <p class="mt-2 text-sm font-medium text-ink">Telp: {{ $branch->phone }}</p>
                        @endif
                        @if ($branch->operating_hours)
                            <p class="mt-1 text-xs text-muted">{{ $branch->operating_hours }}</p>
                        @endif
                        @if ($branch->maps_url)
                            <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="link-arrow mt-4 text-xs">Lihat di Google Maps <x-icon name="arrow-up-right" /></a>
                        @endif
                    </article>
                @empty
                    <p class="text-sm text-muted">Data jaringan kantor belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
