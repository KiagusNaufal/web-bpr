<x-layouts.app
    :title="$product->name"
    :description="$product->summary"
    :image="$product->image_url"
>
    <x-page-header
        :eyebrow="$product->type->label()"
        :title="$product->name"
        :subtitle="$product->summary"
        :breadcrumbs="[
            'Produk dan Layanan' => route('products.index'),
            $product->type->label() => route('products.index', ['jenis' => $product->type->value]),
            $product->name => null,
        ]"
    >
        <x-button :href="route('contact', ['subjek' => 'Pengajuan / Konsultasi '.$product->name])" icon="arrow-right">
            Ajukan / Konsultasi
        </x-button>
    </x-page-header>

    <section class="py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12 lg:gap-16">
            {{-- Kolom utama: Gambar, Penjelasan, Manfaat, Persyaratan, Ketentuan --}}
            <div class="lg:col-span-7">
                @if ($product->image_url)
                    <div class="mb-10 overflow-hidden border border-line bg-soft">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="800" height="520" class="w-full object-cover">
                    </div>
                @endif

                <div class="prose max-w-none">
                    <h2 class="text-xl font-bold text-ink sm:text-2xl">Tentang {{ $product->name }}</h2>
                    <div class="mt-4 space-y-4 text-sm leading-relaxed text-ink/90 sm:text-base">
                        {!! nl2br(e($product->description ?: $product->summary)) !!}
                    </div>
                </div>

                {{-- Ringkasan Ketentuan --}}
                <dl class="mt-10 grid gap-6 border-y border-line bg-soft/60 p-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Suku bunga / Bagi hasil</dt>
                        <dd class="mt-1 text-base font-bold text-ink">{{ $product->rate_info ?: 'Mengikuti ketentuan resmi yang berlaku di BPR' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Jangka waktu (Tenor)</dt>
                        <dd class="mt-1 text-base font-bold text-ink">{{ $product->tenor_info ?: 'Menyesuaikan jenis layanan & kesepakatan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Minimal setoran / plafon</dt>
                        <dd class="mt-1 text-base font-bold text-ink">{{ $product->min_amount_info ?: 'Hubungi petugas kantor layanan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Biaya administrasi</dt>
                        <dd class="mt-1 text-base font-bold text-ink">{{ $product->fee_info ?: 'Dijelaskan secara terbuka saat pembukaan/akad' }}</dd>
                    </div>
                </dl>

                {{-- Manfaat & Persyaratan --}}
                <div class="mt-10 grid gap-8 sm:grid-cols-2">
                    <div class="border-t-2 border-brand pt-5">
                        <h3 class="text-base font-bold text-ink">Manfaat &amp; Keunggulan</h3>
                        @if (!empty($product->benefits))
                            <ul class="mt-4 space-y-3 text-sm text-ink">
                                @foreach ($product->benefits as $benefit)
                                    <li class="flex items-start gap-2.5">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 bg-brand-dark" aria-hidden="true"></span>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-3 text-sm text-muted">Hubungi petugas kami untuk penjelasan rincian manfaat produk ini.</p>
                        @endif
                    </div>

                    <div class="border-t-2 border-accent pt-5">
                        <h3 class="text-base font-bold text-ink">Persyaratan Dokumen</h3>
                        @if (!empty($product->requirements))
                            <ul class="mt-4 space-y-3 text-sm text-ink">
                                @foreach ($product->requirements as $req)
                                    <li class="flex items-start gap-2.5">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 bg-accent" aria-hidden="true"></span>
                                        <span>{{ $req }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-3 text-sm text-muted">Identitas diri (KTP) dan dokumen pendukung sesuai ketentuan BPR.</p>
                        @endif
                    </div>
                </div>

                @if ($product->terms)
                    <div class="mt-10 border border-line bg-soft p-5">
                        <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">Ketentuan Tambahan</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $product->terms }}</p>
                    </div>
                @endif
            </div>

            {{-- Kolom samping: Simulasi kontekstual (Kredit / Deposito) atau Panduan Pembukaan Rekening --}}
            <aside class="lg:col-span-5">
                @if ($product->type === \App\Enums\ProductType::Kredit)
                    <div class="border-t-4 border-accent bg-brand-deep p-7 text-white sm:p-8">
                        <h3 class="text-xl font-bold !text-white">Simulasi Angsuran {{ $product->name }}</h3>
                        <p class="mt-2 text-xs text-white/75">Atur nominal dan jangka waktu untuk melihat perkiraan angsuran per bulan.</p>

                        <form data-simulator onsubmit="return false" class="mt-6">
                            <div class="space-y-5">
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="prod-sim-amount" class="text-sm font-semibold">Jumlah pinjaman</label>
                                        <output data-sim="amount-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="prod-sim-amount" data-sim="amount" type="range" min="1000000" max="500000000" step="1000000" value="25000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>Rp 1 Jt</span><span>Rp 500 Jt</span></div>
                                </div>
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="prod-sim-tenor" class="text-sm font-semibold">Jangka waktu</label>
                                        <output data-sim="tenor-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="prod-sim-tenor" data-sim="tenor" type="range" min="3" max="120" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>3 bulan</span><span>120 bulan</span></div>
                                </div>
                                <div>
                                    <label for="prod-sim-rate" class="mb-1.5 block text-sm font-semibold">Suku bunga per tahun (%)</label>
                                    <input id="prod-sim-rate" data-sim="rate" type="text" inputmode="decimal" value="12" class="field !border-white/30 !bg-white/10 !text-white">
                                </div>
                            </div>

                            <dl class="mt-6 bg-white p-5 text-ink">
                                <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Angsuran per bulan</dt>
                                <dd data-sim="result" aria-live="polite" class="mt-1 text-2xl font-bold tabular-nums text-brand-dark sm:text-3xl">—</dd>
                                <div class="mt-4 grid grid-cols-2 gap-4 border-t border-line pt-4 text-xs sm:text-sm">
                                    <div><dt class="text-muted">Total bunga</dt><dd data-sim="interest" class="font-semibold tabular-nums">—</dd></div>
                                    <div><dt class="text-muted">Total pembayaran</dt><dd data-sim="total" class="font-semibold tabular-nums">—</dd></div>
                                </div>
                            </dl>
                            <p class="mt-3 text-xs text-white/60">Perhitungan sebagai ilustrasi; bukan penawaran mengikat.</p>
                            <x-button :href="route('contact', ['subjek' => 'Pengajuan '.$product->name])" class="mt-5 w-full">Ajukan {{ $product->name }}</x-button>
                        </form>
                    </div>
                @elseif ($product->type === \App\Enums\ProductType::Deposito)
                    <div class="border-t-4 border-accent bg-brand-deep p-7 text-white sm:p-8">
                        <h3 class="text-xl font-bold !text-white">Simulasi {{ $product->name }}</h3>
                        <p class="mt-2 text-xs text-white/75">Hitung perkiraan bunga deposito sebelum pajak.</p>

                        <form data-deposito-sim onsubmit="return false" class="mt-6">
                            <div class="space-y-5">
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="prod-dep-amount" class="text-sm font-semibold">Dana ditempatkan</label>
                                        <output data-dep="amount-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="prod-dep-amount" data-dep="amount" type="range" min="1000000" max="1000000000" step="1000000" value="50000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>Rp 1 Jt</span><span>Rp 1 M</span></div>
                                </div>
                                <div>
                                    <div class="flex items-baseline justify-between">
                                        <label for="prod-dep-tenor" class="text-sm font-semibold">Jangka waktu</label>
                                        <output data-dep="tenor-label" class="text-sm font-bold text-accent"></output>
                                    </div>
                                    <input id="prod-dep-tenor" data-dep="tenor" type="range" min="1" max="24" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                                    <div class="flex justify-between text-[11px] text-white/60"><span>1 bulan</span><span>24 bulan</span></div>
                                </div>
                                <div>
                                    <label for="prod-dep-rate" class="mb-1.5 block text-sm font-semibold">Suku bunga per tahun (%)</label>
                                    <input id="prod-dep-rate" data-dep="rate" type="text" inputmode="decimal" value="6" class="field !border-white/30 !bg-white/10 !text-white">
                                </div>
                            </div>

                            <dl class="mt-6 bg-white p-5 text-ink">
                                <dt class="text-xs font-semibold uppercase tracking-[0.12em] text-muted">Perkiraan bunga (sebelum pajak)</dt>
                                <dd data-dep="interest" aria-live="polite" class="mt-1 text-2xl font-bold tabular-nums text-brand-dark sm:text-3xl">—</dd>
                                <div class="mt-4 border-t border-line pt-4 text-xs sm:text-sm">
                                    <dt class="text-muted">Total dana akhir</dt>
                                    <dd data-dep="total" class="font-semibold tabular-nums">—</dd>
                                </div>
                            </dl>
                            <p class="mt-3 text-xs text-white/60">Ilustrasi bunga sederhana sebelum pajak; tidak mengikat.</p>
                            <x-button :href="route('contact', ['subjek' => 'Penempatan '.$product->name])" class="mt-5 w-full">Konsultasi Deposito</x-button>
                        </form>
                    </div>
                @else
                    <div class="border-t-4 border-accent bg-brand-deep p-7 text-white sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-accent">Cara Membuka Rekening</p>
                        <h3 class="mt-2 text-xl font-bold !text-white">Mudah dan dibantu langsung oleh petugas.</h3>
                        <ol class="mt-6 space-y-4 border-y border-white/15 py-6 text-sm text-white/85">
                            <li class="flex gap-3">
                                <span class="font-bold text-accent">01</span>
                                <span>Siapkan kartu identitas (KTP/Kartu Pelajar) dan dokumen persyaratan.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-accent">02</span>
                                <span>Kunjungi kantor layanan {{ $profile->name }} pada jam operasional atau hubungi petugas kami.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-accent">03</span>
                                <span>Isi formulir pembukaan rekening dan lakukan setoran awal sesuai ketentuan produk.</span>
                            </li>
                        </ol>
                        <x-button :href="route('contact', ['subjek' => 'Pembukaan '.$product->name])" class="mt-6 w-full">Hubungi Petugas Kami</x-button>
                    </div>
                @endif

                @if ($related->isNotEmpty())
                    <div class="mt-10 border border-line p-6">
                        <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">{{ $product->type->label() }} Lainnya</h3>
                        <ul class="mt-4 divide-y divide-line">
                            @foreach ($related as $item)
                                <li class="py-3 first:pt-0 last:pb-0">
                                    <a href="{{ route('products.show', $item) }}" class="group flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-bold text-ink group-hover:text-brand-dark">{{ $item->name }}</p>
                                            <p class="mt-0.5 line-clamp-1 text-xs text-muted">{{ $item->summary }}</p>
                                        </div>
                                        <x-icon name="arrow-right" class="h-4 w-4 shrink-0 text-muted transition-transform group-hover:translate-x-1 group-hover:text-accent" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</x-layouts.app>
