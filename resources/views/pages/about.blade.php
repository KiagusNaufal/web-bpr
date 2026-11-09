<x-layouts.app
    title="Tentang Kami"
    description="Profil perusahaan, sejarah, visi dan misi, nilai-nilai, jajaran pengurus, serta jaringan kantor {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Tentang kami"
        :title="$profile->name"
        :subtitle="$profile->tagline"
        :breadcrumbs="['Tentang Kami' => null]"
    />

    {{-- 1. PROFIL & SEJARAH SINGKAT --}}
    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="reveal lg:col-span-6">
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

            <div class="reveal lg:col-span-6" style="--reveal-delay: 120ms">
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

                @if ($profile->history)
                    <div class="mt-8 border-t border-line pt-6">
                        <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Sejarah Singkat</h3>
                        <div class="mt-3 space-y-3 text-sm leading-relaxed text-muted">
                            {!! nl2br(e($profile->history)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- 2. VISI, MISI, DAN NILAI PERUSAHAAN --}}
    <section class="border-y border-line bg-soft py-16 lg:py-24">
        <div class="container-page">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="reveal lg:col-span-5">
                    <p class="eyebrow">Arah perusahaan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Visi &amp; Misi</h2>

                    <div class="mt-6 border-t-4 border-accent bg-brand-deep p-7 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">Visi</p>
                        <p class="mt-3 text-lg font-bold leading-snug !text-white">
                            {{ $profile->vision ?: '[Visi perusahaan diisi admin]' }}
                        </p>
                    </div>
                </div>

                <div class="reveal lg:col-span-7" style="--reveal-delay: 120ms">
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
                    <div class="reveal max-w-2xl">
                        <p class="eyebrow">Budaya kerja</p>
                        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Nilai-Nilai Perusahaan</h2>
                    </div>

                    <div data-stagger="100" class="mt-8 grid gap-px border border-line bg-line sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($profile->values as $idx => $val)
                            <div class="reveal bg-white p-6">
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

    {{-- 3. STRUKTUR ORGANISASI & PENGURUS --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <div class="reveal max-w-2xl">
                <p class="eyebrow">Tata kelola</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Susunan Pengurus &amp; Struktur Organisasi</h2>
                <p class="mt-3 text-sm text-muted">Jajaran Dewan Komisaris dan Direksi yang menjalankan fungsi pengawasan serta pengelolaan operasional {{ $profile->name }}.</p>
            </div>

            <div class="mt-12 space-y-14">
                @foreach ([
                    'komisaris' => 'Dewan Komisaris',
                    'direksi' => 'Direksi',
                    'pejabat' => 'Pejabat Eksekutif',
                ] as $groupKey => $groupLabel)
                    @php
                        $members = $structures->get($groupKey, collect());
                    @endphp
                    @if ($members->isNotEmpty())
                        <div>
                            <h3 class="border-b-2 border-ink pb-3 text-lg font-bold uppercase tracking-[0.08em] text-ink">{{ $groupLabel }}</h3>
                            <div data-stagger="100" class="mt-6 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach ($members as $member)
                                    <article class="reveal border border-line bg-white">
                                        <div class="aspect-[4/4] w-full overflow-hidden border-b border-line bg-soft">
                                            @if ($member->photo_url)
                                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" width="320" height="320" loading="lazy" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex h-full w-full flex-col items-center justify-center p-6 text-center">
                                                    <span class="text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark">{{ $member->position }}</span>
                                                    <span class="mt-1 text-[11px] text-muted">Foto pengurus dikelola melalui admin</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-5">
                                            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-brand-dark">{{ $member->position }}</p>
                                            <h4 class="mt-1 text-base font-bold text-ink">{{ $member->name }}</h4>
                                            @if ($member->bio)
                                                <p class="mt-2 text-xs leading-relaxed text-muted">{{ $member->bio }}</p>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. JARINGAN KANTOR LAYANAN --}}
    <section class="border-t border-line bg-soft py-16 lg:py-24">
        <div class="container-page">
            <div class="reveal flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Jaringan layanan</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Kantor Layanan Kami</h2>
                </div>
                <a href="{{ route('contact') }}" class="link-arrow">Hubungi kantor <x-icon name="arrow-right" /></a>
            </div>

            <div data-stagger="100" class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($branches as $branch)
                    <article class="reveal border border-line bg-white p-6">
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
