@php
    $activeTab = request('tab', 'profil');
    if (! in_array($activeTab, ['profil', 'media', 'pengurus', 'penghargaan', 'testimoni', 'kantor'], true)) {
        $activeTab = 'profil';
    }
@endphp

<x-layouts.admin title="Profil Perusahaan & Konten Beranda">
    <div data-admin-tabs data-default-tab="{{ $activeTab }}">
        {{-- Navigasi Tab Utama (Hanya menampilkan 1 bagian agar tidak penuh) --}}
        <div class="mb-6 flex flex-wrap gap-2 border-b border-line pb-4" role="tablist">
            @foreach ([
                ['profil', 'building-2', 'Profil & Kontak'],
                ['media', 'image', 'Banner & Poster (' . $banners->count() . ')'],
                ['pengurus', 'network', 'Struktur Organisasi'],
                ['penghargaan', 'check', 'Penghargaan (' . ($awards ?? collect())->count() . ')'],
                ['testimoni', 'message-square-quote', 'Testimoni (' . $testimonials->count() . ')'],
                ['kantor', 'map-pin', 'Jaringan Kantor (' . $branches->count() . ')'],
            ] as [$tabKey, $tabIcon, $tabLabel])
                <button
                    type="button"
                    role="tab"
                    data-admin-tab-btn="{{ $tabKey }}"
                    aria-selected="{{ $activeTab === $tabKey ? 'true' : 'false' }}"
                    class="inline-flex cursor-pointer items-center gap-2 border px-4 py-2.5 text-xs font-bold transition-colors {{ $activeTab === $tabKey ? 'border-brand-dark bg-brand-dark text-white' : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark' }}"
                >
                    <x-icon :name="$tabIcon" class="h-4 w-4" />
                    <span>{{ $tabLabel }}</span>
                </button>
            @endforeach
        </div>

        {{-- TAB 1: PROFIL PERUSAHAAN, KONTAK & SOSIAL MEDIA --}}
        <section id="profil" data-admin-tab-panel="profil" class="{{ $activeTab === 'profil' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8">
            <div class="border-b border-line pb-4">
                <h2 class="text-lg font-bold text-ink">Identitas, Visi Misi &amp; Kontak Resmi</h2>
                <p class="mt-1 text-xs text-muted">Data ini tampil pada halaman Tentang Kami, Kontak Kami, serta Header dan Footer di seluruh halaman.</p>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Blok A: Identitas & Logo --}}
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nama Resmi BPR *</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $profile->name) }}" required class="field">
                    </div>
                    <div>
                        <label for="tagline" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tagline Singkat</label>
                        <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="field">
                    </div>
                    <div>
                        <label for="logo" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Ganti Logo BPR</label>
                        <input id="logo" type="file" name="logo" accept="image/*" class="field text-xs">
                    </div>
                    <div>
                        <label for="hero_image" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Foto Utama Halaman Tentang Kami</label>
                        <input id="hero_image" type="file" name="hero_image" accept="image/*" class="field text-xs">
                    </div>
                </div>

                {{-- Blok B: Kontak & Jam Layanan --}}
                <div class="border-t border-line pt-5">
                    <h3 class="mb-4 text-xs font-extrabold uppercase tracking-[0.14em] text-brand-dark">Kontak &amp; Lokasi Kantor</h3>
                    <div class="grid gap-5 sm:grid-cols-3">
                        <div>
                            <label for="address" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Alamat Kantor Pusat</label>
                            <input id="address" type="text" name="address" value="{{ old('address', $profile->address) }}" class="field">
                        </div>
                        <div>
                            <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor Telepon</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="field">
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Email Resmi</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}" class="field">
                        </div>
                        <div>
                            <label for="operating_hours" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Jam Operasional</label>
                            <input id="operating_hours" type="text" name="operating_hours" value="{{ old('operating_hours', $profile->operating_hours) }}" class="field">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="maps_embed_url" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">URL / Kode Embed Google Maps</label>
                            <input id="maps_embed_url" type="text" name="maps_embed_url" value="{{ old('maps_embed_url', $profile->maps_embed_url) }}" class="field">
                        </div>
                    </div>
                </div>

                {{-- Blok C: Media Sosial & WhatsApp Footer --}}
                <div class="border-t border-line pt-5">
                    <h3 class="mb-4 text-xs font-extrabold uppercase tracking-[0.14em] text-brand-dark">Ikon WhatsApp &amp; Media Sosial (Footer)</h3>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="whatsapp" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Nomor WhatsApp</label>
                            <input id="whatsapp" type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" placeholder="628123456789" class="field">
                        </div>
                        <div>
                            <label for="facebook_url" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Link Facebook</label>
                            <input id="facebook_url" type="url" name="facebook_url" value="{{ old('facebook_url', $profile->facebook_url) }}" placeholder="https://facebook.com/..." class="field">
                        </div>
                        <div>
                            <label for="instagram_url" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Link Instagram</label>
                            <input id="instagram_url" type="url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" placeholder="https://instagram.com/..." class="field">
                        </div>
                        <div>
                            <label for="tiktok_url" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Link TikTok</label>
                            <input id="tiktok_url" type="url" name="tiktok_url" value="{{ old('tiktok_url', $profile->tiktok_url) }}" placeholder="https://tiktok.com/@..." class="field">
                        </div>
                    </div>
                </div>

                {{-- Blok D: Tentang, Sejarah, Visi & Misi --}}
                <div class="border-t border-line pt-5">
                    <h3 class="mb-4 text-xs font-extrabold uppercase tracking-[0.14em] text-brand-dark">Profil, Sejarah &amp; Visi Misi</h3>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="about" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Tentang BPR (Tampil di halaman Profil Perusahaan)</label>
                            <textarea id="about" name="about" rows="4" class="field">{{ old('about', $profile->about) }}</textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="history" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Sejarah Perusahaan (Tampil di halaman Sejarah Perusahaan — pisahkan antar paragraf dengan baris kosong)</label>
                            <textarea id="history" name="history" rows="8" class="field">{{ old('history', $profile->history) }}</textarea>
                        </div>
                        <div>
                            <label for="vision" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Visi Perusahaan</label>
                            <textarea id="vision" name="vision" rows="3" class="field">{{ old('vision', $profile->vision) }}</textarea>
                        </div>
                        <div>
                            <label for="missions_text" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Misi Perusahaan (1 baris per poin)</label>
                            <textarea id="missions_text" name="missions_text" rows="3" class="field">{{ old('missions_text', implode("\n", $profile->missions ?? [])) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="license_info" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.1em] text-ink">Keterangan Izin &amp; Pengawasan (OJK &amp; LPS)</label>
                        <input id="license_info" type="text" name="license_info" value="{{ old('license_info', $profile->license_info) }}" class="field">
                    </div>
                </div>

                <div class="border-t border-line pt-4">
                    <x-button type="submit">Simpan Perubahan Profil</x-button>
                </div>
            </form>
        </section>

        {{-- TAB 2: MEDIA BANNER & POSTER PRODUK (DENGAN FILTER) --}}
        <section id="media" data-admin-tab-panel="media" class="{{ $activeTab === 'media' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8" data-filter-scope>
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-line pb-4">
                <div>
                    <h2 class="text-lg font-bold text-ink">Slide Banner Hero &amp; Poster Produk</h2>
                    <p class="mt-1 text-xs text-muted">Koleksi <strong>banner</strong> tampil pada slider atas Beranda; koleksi <strong>promo</strong> tampil sebagai poster di bagian Produk dan Layanan.</p>
                </div>

                {{-- Tombol Filter Koleksi Media --}}
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-filter-btn="all" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white">
                        Semua ({{ $banners->count() }})
                    </button>
                    <button type="button" data-filter-btn="banner" class="cursor-pointer border border-line bg-soft px-3.5 py-2 text-xs font-bold text-ink hover:border-brand">
                        Slide Hero ({{ $banners->where('collection', 'banner')->count() }})
                    </button>
                    <button type="button" data-filter-btn="promo" class="cursor-pointer border border-line bg-soft px-3.5 py-2 text-xs font-bold text-ink hover:border-brand">
                        Poster Produk ({{ $banners->where('collection', 'promo')->count() }})
                    </button>
                </div>
            </div>

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
                    <div data-filter-item="{{ $item->collection }}" class="border border-line p-3">
                        <img src="{{ $item->url }}" alt="{{ $item->title }}" class="aspect-[16/10] w-full object-cover">
                        <div class="mt-3 flex items-start justify-between gap-2">
                            <div>
                                <span class="inline-block bg-soft px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">
                                    {{ $item->collection === 'banner' ? 'Slide Hero' : 'Poster Produk' }}
                                </span>
                                <p class="mt-1 text-sm font-bold text-ink">{{ $item->title }}</p>
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

        {{-- TAB 3: GAMBAR BAGAN STRUKTUR ORGANISASI --}}
        <section id="pengurus" data-admin-tab-panel="pengurus" class="{{ $activeTab === 'pengurus' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8">
            <div class="border-b border-line pb-4">
                <h2 class="text-lg font-bold text-ink">Gambar Bagan Struktur Organisasi</h2>
                <p class="mt-1 text-xs text-muted">Unggah satu gambar bagan Struktur Organisasi resmi (format JPG/PNG/WebP). Gambar baru akan menggantikan bagan sebelumnya di Beranda dan Tentang Kami.</p>
            </div>

            <form action="{{ route('admin.profile.media.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <input type="hidden" name="collection" value="org_chart">
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Judul Bagan *</label>
                    <input type="text" name="title" value="{{ $orgChart?->title ?: 'Struktur Organisasi '.$profile->name }}" required class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Keterangan Singkat</label>
                    <input type="text" name="caption" value="{{ $orgChart?->caption ?: 'Bagan struktur organisasi resmi perusahaan.' }}" class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">File Gambar Bagan *</label>
                    <input type="file" name="image" accept="image/*" required class="field text-xs">
                </div>
                <div class="sm:col-span-12 sm:text-right">
                    <x-button type="submit" variant="brand">Unggah &amp; Ganti Gambar Struktur Organisasi</x-button>
                </div>
            </form>

            <div class="mt-6 border border-line bg-soft p-4">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.1em] text-brand-dark">Pratinjau Bagan Saat Ini:</p>
                <img src="{{ $orgChart?->url ?: '/images/struktur-organisasi.png' }}" alt="Struktur Organisasi" class="max-h-96 w-auto border border-line bg-white object-contain">
            </div>
        </section>

        {{-- TAB 3B: PENGHARGAAN & SERTIFIKASI --}}
        <section id="penghargaan" data-admin-tab-panel="penghargaan" class="{{ $activeTab === 'penghargaan' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8">
            <div class="border-b border-line pb-4">
                <h2 class="text-lg font-bold text-ink">Penghargaan &amp; Apresiasi</h2>
                <p class="mt-1 text-xs text-muted">Tambahkan foto piagam/piala, nama penghargaan, tahun/penyelenggara, dan keterangan singkat untuk halaman Tentang Kami.</p>
            </div>

            <form action="{{ route('admin.profile.media.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 border border-line bg-soft p-5 sm:grid-cols-12">
                @csrf
                <input type="hidden" name="collection" value="award">
                <div class="sm:col-span-5">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Nama Penghargaan *</label>
                    <input type="text" name="title" required placeholder="Mis. Predikat Sangat Bagus Infobank" class="field">
                </div>
                <div class="sm:col-span-3">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Tahun / Penyelenggara</label>
                    <input type="text" name="link_label" placeholder="Mis. 2025 · Infobank" class="field">
                </div>
                <div class="sm:col-span-4">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Foto Piagam / Piala *</label>
                    <input type="file" name="image" accept="image/*" required class="field text-xs">
                </div>
                <div class="sm:col-span-9">
                    <label class="mb-1 block text-xs font-bold uppercase text-ink">Keterangan Singkat</label>
                    <input type="text" name="caption" placeholder="Penjelasan singkat mengenai penghargaan yang diraih..." class="field">
                </div>
                <div class="sm:col-span-3 sm:self-end">
                    <x-button type="submit" variant="brand" class="w-full">Tambah Penghargaan</x-button>
                </div>
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($awards ?? [] as $award)
                    <div class="border border-line p-3">
                        <img src="{{ $award->url }}" alt="{{ $award->title }}" class="aspect-[16/10] w-full object-cover">
                        <div class="mt-3 flex items-start justify-between gap-2">
                            <div>
                                @if ($award->link_label)
                                    <span class="inline-block bg-soft px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">
                                        {{ $award->link_label }}
                                    </span>
                                @endif
                                <p class="mt-1 text-sm font-bold text-ink">{{ $award->title }}</p>
                                @if ($award->caption)
                                    <p class="mt-1 text-xs text-muted">{{ $award->caption }}</p>
                                @endif
                            </div>
                            <form action="{{ route('admin.profile.media.destroy', $award) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- TAB 4: TESTIMONI NASABAH --}}
        <section id="testimoni" data-admin-tab-panel="testimoni" class="{{ $activeTab === 'testimoni' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8">
            <div class="border-b border-line pb-4">
                <h2 class="text-lg font-bold text-ink">Testimoni Nasabah (Tampil di Beranda)</h2>
                <p class="mt-1 text-xs text-muted">Tambahkan foto persegi nasabah, kutipan testimoni, nama, dan profesi/usaha nasabah.</p>
            </div>

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

        {{-- TAB 5: JARINGAN KANTOR LAYANAN (DENGAN FILTER) --}}
        <section id="kantor" data-admin-tab-panel="kantor" class="{{ $activeTab === 'kantor' ? '' : 'hidden' }} border border-line bg-white p-6 sm:p-8" data-filter-scope>
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-line pb-4">
                <div>
                    <h2 class="text-lg font-bold text-ink">Jaringan Kantor Layanan</h2>
                    <p class="mt-1 text-xs text-muted">Daftar Kantor Pusat, Kantor Cabang, dan Kantor Kas.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button" data-filter-btn="all" class="cursor-pointer border border-brand-dark bg-brand-dark px-3.5 py-2 text-xs font-bold text-white">
                        Semua ({{ $branches->count() }})
                    </button>
                    <button type="button" data-filter-btn="pusat" class="cursor-pointer border border-line bg-soft px-3.5 py-2 text-xs font-bold text-ink hover:border-brand">
                        Pusat ({{ $branches->where('type', 'pusat')->count() }})
                    </button>
                    <button type="button" data-filter-btn="cabang" class="cursor-pointer border border-line bg-soft px-3.5 py-2 text-xs font-bold text-ink hover:border-brand">
                        Cabang ({{ $branches->where('type', 'cabang')->count() }})
                    </button>
                    <button type="button" data-filter-btn="kas" class="cursor-pointer border border-line bg-soft px-3.5 py-2 text-xs font-bold text-ink hover:border-brand">
                        Kas ({{ $branches->where('type', 'kas')->count() }})
                    </button>
                </div>
            </div>

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
                    <div data-filter-item="{{ $branch->type }}" class="flex items-start justify-between border border-line p-4">
                        <div>
                            <span class="inline-block bg-soft px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.1em] text-brand-dark">{{ $branch->type }}</span>
                            <p class="mt-1 text-sm font-bold text-ink">{{ $branch->name }}</p>
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
