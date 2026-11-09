<x-layouts.app
    title="Kontak Kami"
    description="Hubungi kantor layanan {{ $profile->name }}. Informasi alamat kantor, nomor telepon, email, WhatsApp, jam operasional, dan formulir pesan."
>
    <x-page-header
        eyebrow="Hubungi kami"
        title="Kami siap mendengarkan dan membantu rencana Anda."
        subtitle="Kunjungi kantor kami pada jam layanan, hubungi lewat telepon atau WhatsApp, atau kirimkan pertanyaan Anda melalui formulir di bawah ini."
        :breadcrumbs="['Kontak Kami' => null]"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            {{-- Kolom Kiri: Informasi Kontak Resmi & Lokasi --}}
            <div class="lg:col-span-5">
                <p class="eyebrow">Informasi kantor</p>
                <h2 class="mt-2 text-2xl font-bold text-ink">{{ $profile->name }}</h2>

                <dl class="mt-8 divide-y divide-line border-y border-line text-sm">
                    <div class="flex items-start gap-4 py-4">
                        <x-icon name="map-pin" class="mt-0.5 h-5 w-5 shrink-0 text-brand-dark" />
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-muted">Alamat Kantor Pusat</dt>
                            <dd class="mt-1 font-medium text-ink">{{ $profile->address }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 py-4">
                        <x-icon name="phone" class="mt-0.5 h-5 w-5 shrink-0 text-brand-dark" />
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-muted">Telepon</dt>
                            <dd class="mt-1 font-medium text-ink">{{ $profile->phone }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 py-4">
                        <x-icon name="mail" class="mt-0.5 h-5 w-5 shrink-0 text-brand-dark" />
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-muted">Email Resmi</dt>
                            <dd class="mt-1 font-medium text-ink">
                                @if ($profile->email)
                                    <a href="mailto:{{ $profile->email }}" class="underline decoration-brand hover:text-brand-dark">{{ $profile->email }}</a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 py-4">
                        <x-icon name="clock" class="mt-0.5 h-5 w-5 shrink-0 text-brand-dark" />
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-[0.12em] text-muted">Jam Operasional</dt>
                            <dd class="mt-1 font-medium text-ink">{{ $profile->operating_hours }}</dd>
                        </div>
                    </div>
                </dl>

                @if ($profile->whatsapp_url)
                    <div class="mt-6">
                        <x-button :href="$profile->whatsapp_url" target="_blank" rel="noopener" class="w-full" icon="message-circle">
                            Hubungi via WhatsApp
                        </x-button>
                    </div>
                @endif

                {{-- Daftar Kantor / Cabang --}}
                @if ($branches->isNotEmpty())
                    <div class="mt-10">
                        <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Daftar Kantor Layanan</h3>
                        <ul class="mt-4 divide-y divide-line border border-line bg-soft/50">
                            @foreach ($branches as $branch)
                                <li class="p-4 text-sm">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.1em] text-brand-dark">{{ ucfirst($branch->type) }}</p>
                                    <p class="mt-0.5 font-bold text-ink">{{ $branch->name }}</p>
                                    <p class="mt-1 text-xs text-muted">{{ $branch->address }}</p>
                                    @if ($branch->phone)
                                        <p class="mt-1 text-xs font-medium text-ink">Telp: {{ $branch->phone }}</p>
                                    @endif
                                    @if ($branch->maps_url)
                                        <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="link-arrow mt-2 text-xs">Buka Google Maps <x-icon name="arrow-up-right" /></a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Formulir Kirim Pesan --}}
            <div class="lg:col-span-7">
                <div class="border border-line border-t-4 border-t-accent bg-white p-7 sm:p-10">
                    <p class="eyebrow">Formulir layanan</p>
                    <h2 class="mt-2 text-2xl font-bold text-ink">Kirim Pesan atau Permintaan Konsultasi</h2>
                    <p class="mt-2 text-sm text-muted">Isi data di bawah ini. Pesan Anda akan langsung masuk ke sistem layanan nasabah {{ $profile->name }}.</p>

                    <form action="{{ route('contact.store') }}" method="POST" class="mt-8 space-y-5" novalidate>
                        @csrf
                        {{-- Honeypot anti-spam --}}
                        <div class="hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="contact-name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                                    Nama Lengkap <span class="text-red-600">*</span>
                                </label>
                                <input
                                    id="contact-name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    placeholder="Nama lengkap Anda"
                                    class="field @error('name') !border-red-600 @enderror"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact-phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <input
                                    id="contact-phone"
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    autocomplete="tel"
                                    placeholder="Contoh: 0812xxxxxxxx"
                                    class="field @error('phone') !border-red-600 @enderror"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="contact-email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                                    Alamat Email <span class="text-red-600">*</span>
                                </label>
                                <input
                                    id="contact-email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="nama@email.com"
                                    class="field @error('email') !border-red-600 @enderror"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact-subject" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                                    Subjek / Keperluan <span class="text-red-600">*</span>
                                </label>
                                <input
                                    id="contact-subject"
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject', $prefillSubject) }}"
                                    required
                                    placeholder="Mis. Konsultasi Kredit Modal Kerja"
                                    class="field @error('subject') !border-red-600 @enderror"
                                >
                                @error('subject')
                                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="contact-message" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">
                                Isi Pesan <span class="text-red-600">*</span>
                            </label>
                            <textarea
                                id="contact-message"
                                name="message"
                                rows="5"
                                required
                                placeholder="Tuliskan pertanyaan atau kebutuhan Anda..."
                                class="field @error('message') !border-red-600 @enderror"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                            <p class="text-xs text-muted">Data Anda dijaga kerahasiaannya dan hanya digunakan untuk menindaklanjuti pesan ini.</p>
                            <x-button type="submit" icon="arrow-right">Kirim Pesan</x-button>
                        </div>
                    </form>
                </div>

                {{-- Peta Lokasi --}}
                <div class="mt-10 border border-line bg-soft">
                    @if ($profile->maps_embed_url)
                        <iframe
                            src="{{ $profile->maps_embed_url }}"
                            title="Peta lokasi {{ $profile->name }}"
                            width="100%"
                            height="320"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="block w-full border-0"
                        ></iframe>
                    @else
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Peta Lokasi Kantor</p>
                            <p class="mt-1 text-sm text-muted">Sematkan tautan Google Maps resmi melalui menu Profil Perusahaan di Dashboard Admin agar peta interaktif tampil di bagian ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
