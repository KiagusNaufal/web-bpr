<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Branch;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\FinancialReport;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Konten PLACEHOLDER. Tidak ada angka, suku bunga, atau izin resmi:
 * seluruh data tersebut harus diisi admin dari sumber resmi BPR.
 */
class ContentSeeder extends Seeder
{
    private const TBD = '[Diisi admin sesuai ketentuan resmi]';

    public function run(): void
    {
        CompanyProfile::query()->updateOrCreate(['id' => 1], [
            'name' => 'PT BPR Arta Gandhita',
            'logo_path' => '/images/logo.png',
            'tagline' => 'Mitra keuangan yang dekat dengan masyarakat dan pelaku usaha.',
            'about' => 'PT BPR Arta Gandhita adalah Bank Perekonomian Rakyat yang melayani simpanan, pembiayaan, dan deposito bagi masyarakat serta pelaku usaha di wilayah kami. [Deskripsi resmi diisi admin.]',
            'history' => '[Sejarah berdirinya BPR diisi admin: tahun pendirian, pendiri, dan tonggak penting perusahaan.]',
            'vision' => '[Visi perusahaan diisi admin.]',
            'missions' => ['[Misi 1 diisi admin]', '[Misi 2 diisi admin]', '[Misi 3 diisi admin]'],
            'values' => [
                ['title' => 'Integritas', 'description' => '[Deskripsi nilai diisi admin]'],
                ['title' => 'Pelayanan', 'description' => '[Deskripsi nilai diisi admin]'],
                ['title' => 'Kehati-hatian', 'description' => '[Deskripsi nilai diisi admin]'],
                ['title' => 'Kebersamaan', 'description' => '[Deskripsi nilai diisi admin]'],
            ],
            'license_info' => 'Berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan Peserta Penjaminan LPS.',
            'address' => '[Alamat kantor pusat]',
            'phone' => '[Nomor telepon]',
            'email' => 'bprartagandhita@yahoo.com',
            'whatsapp' => null,
            'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 [sesuaikan]',
            'maps_embed_url' => 'https://maps.google.com/maps?q=bpr%20arta%20gandhita&t=&z=14&ie=UTF8&iwloc=B&output=embed',
            'hero_image_path' => '/images/demo/market.jpg',
        ]);

        $this->banners();
        $this->promos();
        $this->products();
        $this->articles();
        $this->testimonials();
        $this->reports();

        Branch::query()->delete();
        Branch::create([
            'name' => 'Kantor Pusat', 'type' => 'pusat', 'address' => '[Alamat kantor pusat]',
            'phone' => '[Nomor telepon]', 'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 [sesuaikan]',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=BPR+Arta+Gandhita',
            'sort_order' => 1,
        ]);

        OrganizationalStructure::query()->delete();
        foreach ([
            ['Komisaris Utama', 'komisaris'], ['Komisaris', 'komisaris'],
            ['Direktur Utama', 'direksi'], ['Direktur', 'direksi'],
        ] as $i => [$position, $group]) {
            OrganizationalStructure::create([
                'name' => '[Nama '.$position.']', 'position' => $position, 'group' => $group, 'sort_order' => $i,
            ]);
        }
    }

    private function products(): void
    {
        Product::query()->delete();

        $common = [
            'rate_info' => null, 'tenor_info' => null, 'min_amount_info' => null,
            'fee_info' => null, 'terms' => '[Ketentuan resmi diisi admin.]', 'status' => 'published',
        ];

        $items = [
            ['tabungan', 'Tabungan Umum', 'Simpanan harian untuk menyimpan dana dengan aman dan mudah diakses.', '/images/banners/tabungan-umum.jpg', true,
                ['Admin rendah', 'Bunga menarik', 'Setoran awal rendah'],
                ['Fotokopi KTP', 'NPWP (jika ada)', 'Setoran awal sesuai ketentuan']],
            ['tabungan', 'Tabungan Pegawai', 'Tabungan untuk mengamankan gaji bulanan pegawai. [Ketentuan lengkap diisi admin.]', '/images/banners/tabungan-pegawai.jpg', false,
                ['Cocok untuk menyimpan gaji bulanan', 'Dijamin sesuai ketentuan LPS yang berlaku'], ['Fotokopi KTP', '[Persyaratan tambahan diisi admin]']],
            ['tabungan', 'Tabungan Pelajar', 'Tabungan untuk pelajar agar terbiasa menyisihkan uang jajan. [Ketentuan lengkap diisi admin.]', '/images/banners/tabungan-pelajar.jpg', false,
                ['Membiasakan menabung sejak dini', 'Dijamin sesuai ketentuan LPS yang berlaku'], ['[Persyaratan diisi admin]']],
            ['tabungan', 'Tabungan Berencana', 'Simpanan terencana untuk tujuan tertentu seperti pendidikan atau ibadah.', null, false,
                ['Setoran rutin sesuai rencana', 'Membantu disiplin menabung'], ['Fotokopi KTP', 'Setoran awal sesuai ketentuan']],
            ['kredit', 'Kredit Modal Kerja', 'Pembiayaan untuk kebutuhan operasional dan perputaran usaha.', '/images/demo/stall.jpg', true,
                ['Disesuaikan dengan arus kas usaha', 'Proses survei oleh petugas'], ['KTP pemohon', 'Bukti usaha', 'Agunan sesuai ketentuan']],
            ['kredit', 'Kredit Investasi', 'Pembiayaan untuk pengadaan aset usaha jangka menengah dan panjang.', null, false,
                ['Tenor menyesuaikan jenis investasi'], ['KTP pemohon', 'Rencana investasi', 'Agunan sesuai ketentuan']],
            ['kredit', 'Kredit Konsumtif', 'Pembiayaan untuk kebutuhan konsumsi dan keperluan pribadi.', null, false,
                ['Angsuran tetap setiap bulan'], ['KTP pemohon', 'Bukti penghasilan']],
            ['kredit', 'Kredit Kendaraan', 'Pembiayaan pembelian kendaraan bermotor.', null, false,
                ['Kendaraan menjadi jaminan sesuai ketentuan'], ['KTP pemohon', 'Bukti penghasilan', 'Dokumen kendaraan']],
            ['kredit', 'Kredit Multiguna', 'Pembiayaan serbaguna untuk berbagai kebutuhan.', null, false,
                ['Penggunaan dana fleksibel'], ['KTP pemohon', 'Bukti penghasilan', 'Agunan sesuai ketentuan']],
            ['deposito', 'Deposito Berjangka', 'Penempatan dana berjangka dengan pilihan jangka waktu.', '/images/demo/market.jpg', true,
                ['Pilihan jangka waktu', 'Bunga sesuai ketentuan yang berlaku'], ['Fotokopi KTP', 'NPWP', 'Penempatan sesuai minimal yang ditetapkan']],
        ];

        foreach ($items as $i => [$type, $name, $summary, $image, $featured, $benefits, $requirements]) {
            Product::create($common + [
                'type' => $type, 'name' => $name, 'slug' => Str::slug($name), 'summary' => $summary,
                'description' => $summary.' [Penjelasan lengkap produk diisi admin.]',
                'image_path' => $image, 'is_featured' => $featured, 'benefits' => $benefits,
                'requirements' => $requirements, 'sort_order' => $i,
            ]);
        }
    }

    private function articles(): void
    {
        Article::query()->delete();

        $categories = collect([
            'Berita Perusahaan', 'Pengumuman', 'Edukasi Keuangan', 'Informasi Produk', 'Kegiatan', 'Layanan Operasional',
        ])->mapWithKeys(fn ($n) => [$n => Category::firstOrCreate(['slug' => Str::slug($n)], ['name' => $n])]);

        $items = [
            ['Edukasi Keuangan', 'Menyusun anggaran usaha kecil dengan sederhana', '/images/demo/market.jpg'],
            ['Kegiatan', 'Kunjungan petugas ke pelaku usaha pasar', '/images/demo/stall.jpg'],
            ['Pengumuman', 'Informasi jam layanan [contoh pengumuman]', null],
            ['Informasi Produk', 'Mengenal pilihan tabungan untuk kebutuhan Anda', '/images/demo/vendor.jpg'],
            ['Berita Perusahaan', '[Contoh berita perusahaan]', null],
        ];

        foreach ($items as $i => [$cat, $title, $img]) {
            Article::create([
                'category_id' => $categories[$cat]->id,
                'title' => $title, 'slug' => Str::slug($title),
                'excerpt' => 'Contoh ringkasan artikel. Ganti dengan konten resmi dari halaman admin.',
                'body' => '<p>Ini adalah konten contoh. Admin dapat mengganti judul, isi, gambar, kategori, dan tanggal terbit melalui dashboard.</p>',
                'thumbnail_path' => $img, 'status' => 'published', 'published_at' => now()->subDays($i * 6 + 1),
            ]);
        }
    }

    private function promos(): void
    {
        Media::query()->where('collection', 'promo')->delete();

        foreach ([
            ['Tabungan Pegawai', 'Amankan gaji bulanan Anda di tabungan yang aman.', '/images/banners/tabungan-pegawai.jpg'],
            ['Tabungan Pelajar', 'Uang jajan bisa jadi tabungan sejak dini.', '/images/banners/tabungan-pelajar.jpg'],
            ['Tabungan Umum', 'Admin rendah, bunga menarik, setoran awal rendah.', '/images/banners/tabungan-umum.jpg'],
        ] as $i => [$title, $caption, $path]) {
            Media::create([
                'collection' => 'promo', 'title' => $title, 'caption' => $caption, 'path' => $path,
                'mime_type' => 'image/jpeg', 'link_url' => '/produk?jenis=tabungan', 'link_label' => 'Lihat produk', 'sort_order' => $i,
            ]);
        }
    }

    private function banners(): void
    {
        Media::query()->where('collection', 'banner')->delete();

        foreach ([
            ['Mitra keuangan yang dekat dengan masyarakat.', 'Simpanan, pembiayaan, dan deposito dengan layanan langsung dari petugas yang mengenal lingkungan Anda.', '/images/demo/market.jpg', 'Kenali Kami', '/tentang-kami'],
            ['Tumbuh bersama usaha dan keluarga di sekitar kita.', 'Pedagang pasar, pelaku UMKM, hingga keluarga membutuhkan layanan keuangan yang mudah dijangkau.', '/images/demo/vendor.jpg', 'Hubungi Kami', '/kontak'],
            ['Terbuka dan transparan untuk publik.', 'Laporan keuangan publikasi dapat dilihat dan diunduh kapan saja dalam format PDF.', '/images/demo/stall.jpg', 'Buka Laporan', '/laporan-keuangan'],
        ] as $i => [$title, $caption, $path, $label, $link]) {
            Media::create([
                'collection' => 'banner', 'title' => $title, 'caption' => $caption, 'path' => $path,
                'mime_type' => 'image/jpeg', 'link_url' => $link, 'link_label' => $label, 'sort_order' => $i,
            ]);
        }
    }

    private function testimonials(): void
    {
        Testimonial::query()->delete();

        foreach ([
            ['[Nama Nasabah 1]', 'Pemilik Warung Sembako', 'Pelayanannya bagus dan ramah. Proses pengajuan modal usaha dijelaskan dengan jelas oleh petugas dari awal sampai pencairan.', '/images/demo/vendor.jpg'],
            ['[Nama Nasabah 2]', 'Pedagang Pasar', 'Menabung dan mengatur perputaran uang harian jadi lebih mudah karena petugas rutin berkunjung dan komunikatif.', '/images/demo/stall.jpg'],
            ['[Nama Nasabah 3]', 'Pelaku Usaha Kuliner', 'Terima kasih kepada PT BPR Arta Gandhita, penempatan deposito dijelaskan terbuka dengan rincian bunga yang jelas.', '/images/demo/market.jpg'],
            ['[Nama Nasabah 4]', 'Pegawai Swasta', 'Menyimpan gaji bulanan di Tabungan Pegawai terasa tenang, biaya administrasinya ringan dan pelayanannya cepat.', '/images/demo/sme-shop.jpg'],
        ] as $i => [$name, $role, $quote, $photo]) {
            Testimonial::create([
                'name' => $name,
                'role' => $role,
                'quote' => $quote,
                'photo_path' => $photo,
                'status' => 'published',
                'sort_order' => $i,
            ]);
        }
    }

    private function reports(): void
    {
        FinancialReport::query()->delete();

        $samplePdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 118>>stream\nBT /F1 14 Tf 56 760 Td (PT BPR Arta Gandhita - Dokumen Contoh Laporan Keuangan) Tj 0 -24 Td /F1 10 Tf (Unggah berkas PDF resmi melalui Dashboard Admin.) Tj ET\nendstream\nendobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\nxref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000052 00000 n \n0000000101 00000 n \n0000000204 00000 n \n0000000372 00000 n \ntrailer<</Size 6/Root 1 0 R>>\nstartxref\n439\n%%EOF";

        Storage::disk('public')->put('reports/contoh-laporan-keuangan.pdf', $samplePdf);
        $size = strlen($samplePdf);

        foreach ([
            ['Laporan Keuangan Publikasi Triwulan IV [Contoh]', 'publikasi', 2025, 'Triwulan IV', '2026-01-15'],
            ['Laporan Keuangan Publikasi Triwulan III [Contoh]', 'publikasi', 2025, 'Triwulan III', '2025-10-15'],
            ['Laporan Keuangan Tahunan 2025 [Contoh]', 'tahunan', 2025, 'Tahunan', '2026-02-01'],
            ['Laporan Keuangan Publikasi Triwulan IV [Contoh]', 'publikasi', 2024, 'Triwulan IV', '2025-01-15'],
            ['Laporan Keuangan Tahunan 2024 [Contoh]', 'tahunan', 2024, 'Tahunan', '2025-02-10'],
        ] as [$title, $type, $year, $period, $date]) {
            FinancialReport::create([
                'title' => $title,
                'type' => $type,
                'year' => $year,
                'period' => $period,
                'published_at' => $date,
                'status' => 'published',
                'file_path' => 'reports/contoh-laporan-keuangan.pdf',
                'file_size' => $size,
            ]);
        }
    }
}
