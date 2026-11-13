<x-layouts.app
    title="Layanan Pengaduan Nasabah"
    description="Prosedur dan formulir resmi Layanan Pengaduan Nasabah {{ $profile->name }} sesuai ketentuan Perlindungan Konsumen OJK."
>
    <x-page-header
        eyebrow="Perlindungan konsumen"
        title="Layanan Pengaduan Nasabah"
        subtitle="Kami berkomitmen menindaklanjuti setiap masukan dan pengaduan nasabah secara transparan, objektif, dan tepat waktu sesuai ketentuan Otoritas Jasa Keuangan (OJK)."
        :breadcrumbs="['Kontak' => route('contact'), 'Pengaduan Nasabah' => null]"
    />

    <section class="py-16 lg:py-24">
        <div class="container-page">
            {{-- Alur Penyelesaian Pengaduan --}}
            <div class="mb-14">
                <p class="eyebrow">Alur resmi</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Mekanisme Penanganan Pengaduan</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-4">
                    @foreach ([
                        ['01', 'Penyampaian Pengaduan', 'Nasabah menyampaikan pengaduan secara lisan (telepon/tatap muka) atau tertulis melalui formulir ini dan kantor layanan.'],
                        ['02', 'Registrasi & Bukti Terima', 'Petugas mencatat pengaduan dan memverifikasi kelengkapan data identitas serta kronologi kejadian.'],
                        ['03', 'Pemeriksaan & Tindak Lanjut', 'Unit kerja terkait melakukan penelusuran dan penyelesaian sesuai standar waktu layanan perbankan (maks. 5 hari kerja untuk lisan, 10 hari kerja untuk tertulis).'],
                        ['04', 'Penyampaian Hasil', 'Hasil penyelesaian disampaikan secara resmi kepada nasabah melalui telepon, surat, atau pertemuan langsung.'],
                    ] as [$no, $title, $desc])
                        <div class="border border-line border-t-4 border-t-brand-dark bg-white p-6">
                            <span class="text-xs font-extrabold text-accent">{{ $no }}</span>
                            <h3 class="mt-2 text-base font-bold text-ink">{{ $title }}</h3>
                            <p class="mt-2 text-xs leading-relaxed text-muted">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Pengaduan Tertulis --}}
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <div class="border border-line bg-white p-6 sm:p-10">
                        <h2 class="text-xl font-bold text-ink">Formulir Pengaduan Tertulis</h2>
                        <p class="mt-1.5 text-xs text-muted">Sampaikan rincian keluhan layanan Anda dengan jelas agar dapat segera kami tindak lanjuti.</p>

                        <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-5">
                            @csrf
                            <input type="hidden" name="category" value="pengaduan">
                            <input type="hidden" name="redirect_to" value="complaint">
                            <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="cmp-name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nama Lengkap Nasabah *</label>
                                    <input id="cmp-name" type="text" name="name" value="{{ old('name') }}" required class="field">
                                </div>
                                <div>
                                    <label for="cmp-phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor Telepon / WhatsApp *</label>
                                    <input id="cmp-phone" type="tel" name="phone" value="{{ old('phone') }}" required class="field">
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="cmp-email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Alamat Email *</label>
                                    <input id="cmp-email" type="email" name="email" value="{{ old('email') }}" required class="field">
                                </div>
                                <div>
                                    <label for="cmp-subject" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Jenis Layanan yang Diadukan *</label>
                                    <select id="cmp-subject" name="subject" required class="field">
                                        <option value="Pengaduan Layanan Tabungan">Layanan Tabungan</option>
                                        <option value="Pengaduan Layanan Kredit">Layanan Kredit / Angsuran</option>
                                        <option value="Pengaduan Layanan Deposito">Layanan Deposito</option>
                                        <option value="Pengaduan Pelayanan Petugas / Kantor">Pelayanan Petugas / Kantor</option>
                                        <option value="Pengaduan Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="cmp-message" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Kronologi &amp; Rincian Pengaduan *</label>
                                <textarea
                                    id="cmp-message"
                                    name="message"
                                    rows="5"
                                    required
                                    placeholder="Jelaskan tanggal kejadian, jenis transaksi/layanan, dan keluhan yang Anda alami..."
                                    class="field"
                                >{{ old('message') }}</textarea>
                            </div>

                            <div class="border-t border-line pt-4">
                                <x-button type="submit">Kirim Laporan Pengaduan</x-button>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="space-y-6 lg:col-span-5">
                    <div class="border border-line bg-soft p-6">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Saluran Pengaduan Langsung</p>
                        <h3 class="mt-2 text-lg font-bold text-ink">Unit Pelayanan &amp; Pengaduan Nasabah</h3>
                        <ul class="mt-4 space-y-3 text-sm text-muted">
                            <li><strong class="text-ink">Kantor:</strong> {{ $profile->address }}</li>
                            <li><strong class="text-ink">Telepon:</strong> {{ $profile->phone }}</li>
                            <li><strong class="text-ink">Email:</strong> {{ $profile->email }}</li>
                            <li><strong class="text-ink">Jam Layanan:</strong> {{ $profile->operating_hours }}</li>
                        </ul>
                    </div>

                    <div class="border border-line bg-white p-6">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Kontak OJK (APPK)</p>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Apabila nasabah belum memperoleh kesepakatan penyelesaian dari BPR, nasabah dapat menyampaikan pengaduan melalui Aplikasi Portal Perlindungan Konsumen (APPK) Otoritas Jasa Keuangan atau Kontak OJK <strong>157</strong>.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
