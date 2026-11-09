<x-layouts.admin title="Profil Perusahaan, Testimoni & Media Beranda">
    {{-- Navigasi bagian halaman --}}
    <div class="mb-8 flex flex-wrap gap-2 border-b border-line pb-4">
        @foreach ([
            ['#profil', 'Profil & Kontak'],
            ['#testimoni', 'Testimoni Nasabah'],
            ['#media', 'Banner & Poster Produk'],
            ['#pengurus', 'Struktur Organisasi'],
            ['#kantor', 'Jaringan Kantor'],
        ] as [$href, $label])
            <a href="{{ $href }}" class="border border-line bg-white px-4 py-2 text-xs font-bold text-ink transition-colors hover:border-brand hover:text-brand-dark">{{ $label }}</a>
        @endforeach
    </div>

    <div class="space-y-12">
        {{-- 1. PROFIL PERUSAHAAN & KONTAK --}}
        <section id="profil" class="scroll-mt-8 border border-line bg-white p-6 sm:p-8">
            <h2 class="text-lg font-bold text-ink">1. Identitas, Visi Misi &amp; Kontak Resmi</h2>
            <p class="mt-1 text-xs text-muted">Data ini digunakan pada halaman Tentang Kami, Kontak Kami, serta bagian header dan footer seluruh website.</p>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nama Resmi BPR *</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $profile->name) }}" required class="field">
                    </div>
                    <div>
                        <label for="tagline" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tagline</label>
                        <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="field">
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="about" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tentang BPR</label>
                        <textarea id="about" name="about" rows="4" class="field">{{ old('about', $profile->about) }}</textarea>
                    </div>
                    <div>
                        <label for="history" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Sejarah Singkat</label>
                        <textarea id="history" name="history" rows="4" class="field">{{ old('history', $profile->history) }}</textarea>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="vision" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Visi Perusahaan</label>
                        <textarea id="vision" name="vision" rows="3" class="field">{{ old('vision', $profile->vision) }}</textarea>
                    </div>
                    <div>
                        <label for="missions_text" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Misi Perusahaan (satu per baris)</label>
                        <textarea id="missions_text" name="missions_text" rows="3" class="field">{{ old('missions_text', implode("\n", $profile->missions ?? [])) }}</textarea>
                    </div>
                </div>

                <div>
                    <label for="license_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Keterangan Izin &amp; Pengawasan (OJK &amp; LPS)</label>
                    <input id="license_info" type="text" name="license_info" value="{{ old('license_info', $profile->license_info) }}" class="field">
                </div>

                <div class="grid gap-5 border-t border-line pt-5 sm:grid-cols-3">
                    <div>
                        <label for="address" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Alamat Kantor Pusat</label>
                        <input id="address" type="text" name="address" value="{{ old('address', $profile->address) }}" class="field">
                    </div>
                    <div>
                        <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor Telepon</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="field">
                    </div>
                    <div>
                        <label for="whatsapp" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor WhatsApp (mis. 62812...)</label>
                        <input id="whatsapp" type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" class="field">
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-3">
                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Email Resmi</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}" class="field">
                    </div>
                    <div>
                        <label for="operating_hours" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Jam Operasional</label>
                        <input id="operating_hours" type="text" name="operating_hours" value="{{ old('operating_hours', $profile->operating_hours) }}" class="field">
                    </div>
                    <div>
                        <label for="maps_embed_url" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">URL Embed Google Maps</label>
                        <input id="maps_embed_url" type="text" name="maps_embed_url" value="{{ old('maps_embed_url', $profile->maps_embed_url) }}" class="field">
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="logo" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Ganti Logo BPR</label>
                        <input id="logo" type="file" name="logo" accept="image/*" class="field text-xs">
                    </div>
                    <div>
                        <label for="hero_image" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Foto Utama Halaman Tentang Kami</label>
                        <input id="hero_image" type="file" name="hero_image" accept="image/*" class="field text-xs">
                    </div>
                </div>

                <div class="pt-2">
                    <x-button type="submit">Simpan Profil Perusahaan</x-button>
                </div>
            </form>
        </section>

        {{-- 2. TESTIMONI NASABAH --}}
        <section id="testimoni" class="scroll-mt-8 border border-line bg-white p-6 sm:p-8">
            <h2 class="text-lg font-bold text-ink">2. Testimoni Nasabah (Tampil di Beranda)</h2>
            <p class="mt-1 text-xs text-muted">Tambahkan foto persegi nasabah, kutipan testimoni, nama, dan profesi/usaha nasabah.</p>

            <form action="{{ route('admin.profile.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Nama Nasabah *</label>
                    <input type="text" name="name" required placeholder="Mis. Teh Ratna" class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Usaha / Peran</label>
                    <input type="text" name="role" placeholder="Mis. Pemilik Warung Sembako" class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Foto Nasabah</label>
                    <input type="file" name="photo" accept="image/*" class="field text-xs">
                </div>
                <div class="sm:col-span-9">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Isi Kutipan Testimoni *</label>
                    <input type="text" name="quote" required placeholder="Pelayanannya bagus dan ramah..." class="field">
                </div>
                <div class="sm:col-span-3 sm:self-end">
                    <input type="hidden" name="status" value="published">
                    <x-button type="submit" variant="brand" class="w-full">Tambah Testimoni</x-button>
                </div>
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                @foreach ($testimonials as $item)
                    <div class="flex items-start justify-between gap-4 border border-line p-4">
                        <div class="flex items-start gap-3">
                            @if ($item->photo_url)
                                <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="h-14 w-14 shrink-0 object-cover">
                            @endif
                            <div>
                                <p class="text-sm font-bold text-ink">{{ $item->name }}</p>
                                <p class="text-xs font-semibold text-brand-dark">{{ $item->role }}</p>
                                <p class="mt-1 text-xs text-muted">&ldquo;{{ $item->quote }}&rdquo;</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.profile.testimonials.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 3. MEDIA BANNER & POSTER PRODUK --}}
        <section id="media" class="scroll-mt-8 border border-line bg-white p-6 sm:p-8">
            <h2 class="text-lg font-bold text-ink">3. Slide Banner Hero &amp; Poster Produk</h2>
            <p class="mt-1 text-xs text-muted">Koleksi <strong>banner</strong> tampil pada slider atas Beranda; koleksi <strong>promo</strong> tampil sebagai poster di bagian Produk dan Layanan.</p>

            <form action="{{ route('admin.profile.media.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Koleksi *</label>
                    <select name="collection" class="field">
                        <option value="banner">Slide Hero (banner)</option>
                        <option value="promo">Poster Produk (promo)</option>
                    </select>
                </div>
                <div class="sm:col-span-5">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Judul *</label>
                    <input type="text" name="title" required class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Gambar *</label>
                    <input type="file" name="image" accept="image/*" required class="field text-xs">
                </div>
                <div class="sm:col-span-6">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Keterangan Singkat</label>
                    <input type="text" name="caption" class="field">
                </div>
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">URL Tautan</label>
                    <input type="text" name="link_url" placeholder="/produk" class="field">
                </div>
                <div class="sm:col-span-3 sm:self-end">
                    <x-button type="submit" variant="brand" class="w-full">Unggah Media</x-button>
                </div>
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($banners as $item)
                    <div class="border border-line p-3">
                        <img src="{{ $item->url }}" alt="{{ $item->title }}" class="aspect-[16/10] w-full object-cover">
                        <div class="mt-3 flex items-start justify-between gap-2">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">{{ $item->collection }}</span>
                                <p class="text-sm font-bold text-ink">{{ $item->title }}</p>
                            </div>
                            <form action="{{ route('admin.profile.media.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 4. STRUKTUR ORGANISASI & PENGURUS --}}
        <section id="pengurus" class="scroll-mt-8 border border-line bg-white p-6 sm:p-8">
            <h2 class="text-lg font-bold text-ink">4. Susunan Pengurus (Komisaris, Direksi &amp; Pejabat)</h2>

            <form action="{{ route('admin.profile.structures.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Nama Lengkap *</label>
                    <input type="text" name="name" required class="field">
                </div>
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Jabatan *</label>
                    <input type="text" name="position" required placeholder="Mis. Direktur Utama" class="field">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Jajaran *</label>
                    <select name="group" class="field">
                        <option value="komisaris">Komisaris</option>
                        <option value="direksi">Direksi</option>
                        <option value="pejabat">Pejabat Eksekutif</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Foto</label>
                    <input type="file" name="photo" accept="image/*" class="field text-xs">
                </div>
                <div class="sm:col-span-2 sm:self-end">
                    <x-button type="submit" variant="brand" class="w-full">Tambah</x-button>
                </div>
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($structures as $member)
                    <div class="flex items-center justify-between border border-line p-4">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">{{ $member->position }}</p>
                            <p class="text-sm font-bold text-ink">{{ $member->name }}</p>
                        </div>
                        <form action="{{ route('admin.profile.structures.destroy', $member) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 5. JARINGAN KANTOR LAYANAN --}}
        <section id="kantor" class="scroll-mt-8 border border-line bg-white p-6 sm:p-8">
            <h2 class="text-lg font-bold text-ink">5. Jaringan Kantor Layanan</h2>

            <form action="{{ route('admin.profile.branches.store') }}" method="POST" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Nama Kantor *</label>
                    <input type="text" name="name" required placeholder="Mis. Kantor Kas Pasar" class="field">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Jenis *</label>
                    <select name="type" class="field">
                        <option value="pusat">Kantor Pusat</option>
                        <option value="cabang">Kantor Cabang</option>
                        <option value="kas">Kantor Kas</option>
                    </select>
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Alamat Lengkap *</label>
                    <input type="text" name="address" required class="field">
                </div>
                <div class="sm:col-span-3 sm:self-end">
                    <x-button type="submit" variant="brand" class="w-full">Tambah Kantor</x-button>
                </div>
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                @foreach ($branches as $branch)
                    <div class="flex items-start justify-between border border-line p-4">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">{{ $branch->type }}</span>
                            <p class="text-sm font-bold text-ink">{{ $branch->name }}</p>
                            <p class="text-xs text-muted">{{ $branch->address }}</p>
                        </div>
                        <form action="{{ route('admin.profile.branches.destroy', $branch) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.admin>
