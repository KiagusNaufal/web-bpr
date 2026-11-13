<x-layouts.app
    title="Formulir Pengajuan Online"
    description="Formulir pengajuan online pembukaan rekening Tabungan, penempatan Deposito, dan pengajuan Kredit di {{ $profile->name }}."
>
    <x-page-header
        eyebrow="Layanan nasabah"
        title="Formulir Pengajuan Online"
        subtitle="Isi data singkat di bawah ini untuk mengajukan Kredit, membuka Tabungan, atau menempatkan Deposito. Petugas kami akan menghubungi Anda untuk pendampingan."
        :breadcrumbs="['Produk dan Layanan' => route('products.index'), 'Pengajuan Online' => null]"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            {{-- Form Pengajuan Cepat --}}
            <div class="lg:col-span-7">
                <div class="border border-line border-t-4 border-t-brand-dark bg-white p-6 sm:p-10">
                    <h2 class="text-xl font-bold text-ink">Data Pengajuan Nasabah</h2>
                    <p class="mt-1.5 text-xs text-muted">Data Anda bersifat rahasia dan hanya digunakan oleh petugas resmi {{ $profile->name }}.</p>

                    <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-5">
                        @csrf
                        <input type="hidden" name="category" value="pengajuan">
                        <input type="hidden" name="redirect_to" value="application">
                        <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="app-name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nama Lengkap Sesuai KTP *</label>
                                <input id="app-name" type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap Anda" class="field">
                                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="app-phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor WhatsApp / Telepon Aktif *</label>
                                <input id="app-phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="0812xxxx" class="field">
                                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="app-email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Alamat Email *</label>
                                <input id="app-email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="field">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="app-subject" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Produk yang Diajukan *</label>
                                <select id="app-subject" name="subject" required class="field">
                                    @foreach ($products as $prod)
                                        @php $val = 'Pengajuan ' . $prod->type->label() . ' — ' . $prod->name; @endphp
                                        <option value="{{ $val }}" @selected(old('subject', $selectedProduct) === $val || $selectedProduct === $prod->name)>
                                            {{ $prod->type->label() }} — {{ $prod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="app-message" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Rencana Nominal, Domisili &amp; Keterangan Tambahan *</label>
                            <textarea
                                id="app-message"
                                name="message"
                                rows="4"
                                required
                                placeholder="Contoh: Rencana pengajuan Rp 25.000.000 jangka waktu 12 bulan untuk modal warung sembako di wilayah..."
                                class="field"
                            >{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="border-t border-line pt-4">
                            <x-button type="submit" icon="arrow-right">Kirim Pengajuan Sekarang</x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Panduan Singkat & Jaminan LPS --}}
            <aside class="space-y-6 lg:col-span-5">
                <div class="border-t-4 border-accent bg-brand-deep p-6 text-white sm:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">Tahapan Pengajuan</p>
                    <h3 class="mt-2 text-xl font-bold !text-white">Mudah, Terarah &amp; Didampingi Petugas</h3>
                    <ol class="mt-5 space-y-4 text-sm text-white/85">
                        <li class="flex gap-3">
                            <span class="font-bold text-accent">01.</span>
                            <span>Isi formulir pengajuan online sesuai produk yang Anda butuhkan.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-accent">02.</span>
                            <span>Petugas resmi kami akan menghubungi Anda via WhatsApp/telepon pada jam kerja.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-accent">03.</span>
                            <span>Penjelasan syarat dokumen, verifikasi data, hingga pembukaan rekening atau pencairan.</span>
                        </li>
                    </ol>
                </div>

                <div class="border border-line bg-soft p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Informasi Penjaminan LPS</p>
                    <p class="mt-2 text-sm font-bold text-ink">Tingkat Bunga Penjaminan LPS BPR: {{ $profile->lps_rate ?: '6,75%' }}</p>
                    <p class="mt-1.5 text-xs leading-relaxed text-muted">
                        Simpanan nasabah dijamin oleh Lembaga Penjamin Simpanan (LPS) hingga maksimum <strong>Rp 2.000.000.000 (Dua Miliar Rupiah)</strong> per nasabah per bank sesuai ketentuan yang berlaku.
                    </p>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
