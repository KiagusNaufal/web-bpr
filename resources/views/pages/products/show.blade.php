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
    />

    <section class="py-14 lg:py-20">
        <div class="container-page grid gap-10 lg:grid-cols-12 lg:gap-14">
            {{-- Kolom Kiri: Gambar, Penjelasan Singkat, Manfaat & Syarat --}}
            <div class="lg:col-span-7">
                @if ($product->image_url)
                    <div class="mb-8 overflow-hidden border border-line bg-soft">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="800" height="531" class="w-full object-cover">
                    </div>
                @endif

                <h2 class="text-xl font-bold text-ink">Ringkasan Produk</h2>
                <p class="mt-3 text-sm leading-relaxed text-muted sm:text-base">
                    {{ $product->description ?: $product->summary }}
                </p>

                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    <div class="border border-line bg-soft/60 p-5">
                        <h3 class="text-sm font-bold text-ink">Manfaat Utama</h3>
                        @if (!empty($product->benefits))
                            <ul class="mt-3 space-y-2 text-sm text-ink">
                                @foreach ($product->benefits as $benefit)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 bg-brand-dark"></span>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-2 text-xs text-muted">Hubungi petugas untuk rincian manfaat.</p>
                        @endif
                    </div>

                    <div class="border border-line bg-soft/60 p-5">
                        <h3 class="text-sm font-bold text-ink">Syarat Dokumen</h3>
                        @if (!empty($product->requirements))
                            <ul class="mt-3 space-y-2 text-sm text-ink">
                                @foreach ($product->requirements as $req)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 bg-accent"></span>
                                        <span>{{ $req }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-2 text-xs text-muted">KTP dan dokumen pendukung sesuai ketentuan.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-6">
                    <a href="{{ route('products.index') }}" class="link-arrow text-xs">
                        <x-icon name="chevron-left" /> Kembali ke semua produk
                    </a>
                    <x-button :href="route('contact', ['subjek' => 'Konsultasi '.$product->name])" icon="arrow-right">
                        Tanya / Ajukan Produk Ini
                    </x-button>
                </div>
            </div>

            {{-- Kolom Kanan: Kalkulator Simulasi (untuk Kredit/Deposito) atau Langkah Mudah (untuk Tabungan) --}}
            <aside class="lg:col-span-5">
                @if ($product->type === \App\Enums\ProductType::Kredit)
                    <div class="border-t-4 border-accent bg-brand-deep p-6 text-white sm:p-8">
                        <h3 class="text-lg font-bold !text-white">Simulasi Angsuran</h3>
                        <form data-simulator onsubmit="return false" class="mt-5 space-y-5">
                            <div>
                                <div class="flex justify-between text-xs font-semibold">
                                    <label for="prod-sim-amount">Pinjaman</label>
                                    <output data-sim="amount-label" class="font-bold text-accent"></output>
                                </div>
                                <input id="prod-sim-amount" data-sim="amount" type="range" min="1000000" max="500000000" step="1000000" value="25000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-semibold">
                                    <label for="prod-sim-tenor">Jangka waktu</label>
                                    <output data-sim="tenor-label" class="font-bold text-accent"></output>
                                </div>
                                <input id="prod-sim-tenor" data-sim="tenor" type="range" min="3" max="120" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                            </div>
                            <div>
                                <label for="prod-sim-rate" class="mb-1 block text-xs font-semibold">Bunga per tahun (%)</label>
                                <input id="prod-sim-rate" data-sim="rate" type="text" inputmode="decimal" value="12" class="field !border-white/30 !bg-white/10 !text-white">
                            </div>
                            <dl class="bg-white p-4 text-ink">
                                <dt class="text-[11px] font-bold uppercase tracking-[0.1em] text-muted">Angsuran per bulan</dt>
                                <dd data-sim="result" class="mt-1 text-2xl font-bold tabular-nums text-brand-dark">—</dd>
                                <div class="mt-3 grid grid-cols-2 gap-3 border-t border-line pt-3 text-xs">
                                    <div><dt class="text-muted">Total bunga</dt><dd data-sim="interest" class="font-semibold">—</dd></div>
                                    <div><dt class="text-muted">Total bayar</dt><dd data-sim="total" class="font-semibold">—</dd></div>
                                </div>
                            </dl>
                        </form>
                    </div>
                @elseif ($product->type === \App\Enums\ProductType::Deposito)
                    <div class="border-t-4 border-accent bg-brand-deep p-6 text-white sm:p-8">
                        <h3 class="text-lg font-bold !text-white">Simulasi Deposito</h3>
                        <form data-deposito-sim onsubmit="return false" class="mt-5 space-y-5">
                            <div>
                                <div class="flex justify-between text-xs font-semibold">
                                    <label for="prod-dep-amount">Dana ditempatkan</label>
                                    <output data-dep="amount-label" class="font-bold text-accent"></output>
                                </div>
                                <input id="prod-dep-amount" data-dep="amount" type="range" min="1000000" max="1000000000" step="1000000" value="50000000" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-semibold">
                                    <label for="prod-dep-tenor">Jangka waktu</label>
                                    <output data-dep="tenor-label" class="font-bold text-accent"></output>
                                </div>
                                <input id="prod-dep-tenor" data-dep="tenor" type="range" min="1" max="24" step="1" value="12" class="mt-2 min-h-11 w-full cursor-pointer accent-accent">
                            </div>
                            <div>
                                <label for="prod-dep-rate" class="mb-1 block text-xs font-semibold">Bunga per tahun (%)</label>
                                <input id="prod-dep-rate" data-dep="rate" type="text" inputmode="decimal" value="6" class="field !border-white/30 !bg-white/10 !text-white">
                            </div>
                            <dl class="bg-white p-4 text-ink">
                                <dt class="text-[11px] font-bold uppercase tracking-[0.1em] text-muted">Perkiraan bunga (sebelum pajak)</dt>
                                <dd data-dep="interest" class="mt-1 text-2xl font-bold tabular-nums text-brand-dark">—</dd>
                                <div class="mt-3 border-t border-line pt-3 text-xs">
                                    <dt class="text-muted">Total dana akhir</dt>
                                    <dd data-dep="total" class="font-semibold">—</dd>
                                </div>
                            </dl>
                        </form>
                    </div>
                @else
                    <div class="border-t-4 border-accent bg-brand-deep p-6 text-white sm:p-8">
                        <h3 class="text-lg font-bold !text-white">Cara Membuka Rekening</h3>
                        <ol class="mt-4 space-y-3 text-sm text-white/85">
                            <li><strong class="text-accent">1.</strong> Siapkan KTP / identitas diri.</li>
                            <li><strong class="text-accent">2.</strong> Datang ke kantor layanan {{ $profile->name }}.</li>
                            <li><strong class="text-accent">3.</strong> Isi formulir &amp; lakukan setoran awal.</li>
                        </ol>
                    </div>
                @endif

                @if ($related->isNotEmpty())
                    <div class="mt-6 border border-line bg-white p-5">
                        <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-brand-dark">{{ $product->type->label() }} Lainnya</h3>
                        <ul class="mt-3 divide-y divide-line text-sm">
                            @foreach ($related as $item)
                                <li class="py-2.5 first:pt-0 last:pb-0">
                                    <a href="{{ route('products.show', $item) }}" class="flex items-center justify-between font-semibold text-ink hover:text-brand-dark">
                                        <span>{{ $item->name }}</span>
                                        <x-icon name="arrow-right" class="h-4 w-4 text-muted" />
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
