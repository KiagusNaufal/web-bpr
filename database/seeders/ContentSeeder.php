<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Branch;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use App\Models\Product;
use Illuminate\Database\Seeder;
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
            'license_info' => '[Nomor izin usaha OJK dan keanggotaan LPS diisi admin]',
            'address' => '[Alamat kantor pusat]',
            'phone' => '[Nomor telepon]',
            'email' => 'info@bpr-nama.example',
            'whatsapp' => null,
            'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 [sesuaikan]',
            'maps_embed_url' => null,
            'hero_image_path' => '/images/demo/market.jpg',
        ]);

        $this->banners();
        $this->products();
        $this->articles();

        Branch::query()->delete();
        Branch::create([
            'name' => 'Kantor Pusat', 'type' => 'pusat', 'address' => '[Alamat kantor pusat]',
            'phone' => '[Nomor telepon]', 'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 [sesuaikan]', 'sort_order' => 1,
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
            ['tabungan', 'Tabungan Umum', 'Simpanan harian untuk menyimpan dana dengan aman dan mudah diakses.', '/images/demo/vendor.jpg', true,
                ['Setoran dan penarikan di kantor', 'Dijamin sesuai ketentuan LPS yang berlaku', 'Pembukaan rekening sederhana'],
                ['Fotokopi KTP', 'NPWP (jika ada)', 'Setoran awal sesuai ketentuan']],
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

    private function banners(): void
    {
        Media::query()->where('collection', 'banner')->delete();

        foreach ([
            ['Simpan dengan tenang, usaha berjalan lancar.', 'Tabungan dan deposito dengan layanan langsung dari petugas yang mengenal Anda.', '/images/demo/vendor.jpg', 'Lihat Tabungan', '/produk?jenis=tabungan'],
            ['Modal usaha, dibicarakan dengan jelas.', 'Konsultasikan kebutuhan kredit modal kerja, investasi, hingga multiguna.', '/images/demo/market.jpg', 'Lihat Kredit', '/produk?jenis=kredit'],
            ['Laporan keuangan terbuka untuk publik.', 'Unduh laporan publikasi resmi kapan saja dalam format PDF.', '/images/demo/stall.jpg', 'Buka Laporan', '/laporan-keuangan'],
        ] as $i => [$title, $caption, $path, $label, $link]) {
            Media::create([
                'collection' => 'banner', 'title' => $title, 'caption' => $caption, 'path' => $path,
                'mime_type' => 'image/jpeg', 'link_url' => $link, 'link_label' => $label, 'sort_order' => $i,
            ]);
        }
    }
}
