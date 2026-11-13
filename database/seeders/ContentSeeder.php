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

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        CompanyProfile::query()->updateOrCreate(['id' => 1], [
            'name' => 'PT BPR Arta Gandhita',
            'logo_path' => '/images/logo.png',
            'tagline' => 'Mitra keuangan yang dekat dengan masyarakat dan pelaku usaha.',
            'about' => "PT BPR Arta Gandhita adalah Bank Perekonomian Rakyat yang berkomitmen menghadirkan layanan perbankan yang aman, mudah dijangkau, dan bersahabat bagi masyarakat luas maupun pelaku Usaha Mikro, Kecil, dan Menengah (UMKM).\n\nMelalui produk Tabungan, Kredit, dan Deposito Berjangka, kami senantiasa mendampingi pertumbuhan usaha lokal dan perencanaan keuangan keluarga dengan proses yang transparan serta pelayanan tatap muka yang komunikatif.",
            'history' => "PT BPR Arta Gandhita didirikan dengan semangat untuk memperluas akses layanan perbankan formal bagi masyarakat dan pelaku usaha kecil di daerah. Sejak awal beroperasi, kami berfokus pada pelayanan simpanan dan penyaluran kredit produktif yang menjangkau pedagang pasar, wirausaha, serta pegawai.\n\nSeiring berjalannya waktu dan meningkatnya kepercayaan masyarakat, PT BPR Arta Gandhita terus memperkuat permodalan, tata kelola perusahaan, serta kualitas sumber daya manusia. Pendekatan layanan jemput bola dan komunikasi yang terbuka menjadi ciri khas kami dalam membangun hubungan jangka panjang dengan nasabah.\n\nHingga saat ini, PT BPR Arta Gandhita terus bertumbuh secara sehat di bawah pengawasan Otoritas Jasa Keuangan (OJK) dan menjadi peserta penjaminan Lembaga Penjamin Simpanan (LPS), guna memastikan setiap dana nasabah dikelola secara profesional, aman, dan memberikan manfaat nyata bagi perekonomian daerah.",
            'vision' => 'Menjadi Bank Perekonomian Rakyat yang sehat, terpercaya, dan unggul dalam mendukung pertumbuhan ekonomi masyarakat serta pelaku usaha mikro, kecil, dan menengah.',
            'missions' => [
                'Memberikan layanan perbankan yang cepat, ramah, dan mudah dijangkau oleh seluruh lapisan masyarakat.',
                'Menyalurkan pembiayaan kredit yang sehat dan tepat sasaran untuk mendorong perkembangan UMKM di daerah.',
                'Menjaga keamanan dana simpanan nasabah melalui penerapan prinsip kehati-hatian dan tata kelola perusahaan yang baik.',
                'Meningkatkan profesionalisme sumber daya manusia serta nilai tambah yang berkelanjutan bagi seluruh pemangku kepentingan.',
            ],
            'values' => [
                ['title' => 'Integritas', 'description' => 'Menjunjung tinggi kejujuran, keterbukaan, dan tanggung jawab dalam setiap layanan perbankan.'],
                ['title' => 'Pelayanan', 'description' => 'Mengutamakan keramahan, ketepatan waktu, dan solusi yang relevan bagi kebutuhan nasabah.'],
                ['title' => 'Kehati-hatian', 'description' => 'Mengelola dana simpanan dan penyaluran kredit secara terukur sesuai regulasi perbankan.'],
                ['title' => 'Kebersamaan', 'description' => 'Tumbuh berdampingan bersama masyarakat, pelaku usaha, dan seluruh insan perusahaan.'],
            ],
            'license_info' => 'Berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK) serta merupakan Peserta Penjaminan LPS.',
            'lps_rate' => '6,75%',
            'address' => 'Jl. Raya Utama Kantor Pusat PT BPR Arta Gandhita',
            'phone' => '(021) 800-0000',
            'email' => 'bprartagandhita@yahoo.com',
            'whatsapp' => '6281234567890',
            'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 WIB',
            'maps_embed_url' => 'https://maps.google.com/maps?q=bpr%20arta%20gandhita&t=&z=14&ie=UTF8&iwloc=B&output=embed',
            'hero_image_path' => '/images/demo/market.jpg',
        ]);

        $this->banners();
        $this->promos();
        $this->orgChart();
        $this->awards();
        $this->galleryAndCareersAndCollaterals();
        $this->products();
        $this->articles();
        $this->testimonials();
        $this->reports();

        Branch::query()->delete();
        Branch::create([
            'name' => 'Kantor Pusat PT BPR Arta Gandhita',
            'type' => 'pusat',
            'address' => 'Jl. Raya Utama Kantor Pusat PT BPR Arta Gandhita',
            'phone' => '(021) 800-0000',
            'operating_hours' => 'Senin – Jumat, 08.00 – 15.00 WIB',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=BPR+Arta+Gandhita',
            'sort_order' => 1,
        ]);

        OrganizationalStructure::query()->delete();
        foreach ([
            ['Komisaris Utama', 'komisaris'],
            ['Komisaris', 'komisaris'],
            ['Direktur Utama', 'direksi'],
            ['Direktur Operasional & Kepatuhan', 'direksi'],
            ['Pejabat Eksekutif Audit Intern', 'pejabat'],
            ['Pejabat Eksekutif Kepatuhan & Risiko', 'pejabat'],
            ['Kabag Kredit & Pemasaran', 'pejabat'],
            ['Kabag Operasional & Pelayanan', 'pejabat'],
        ] as $i => [$position, $group]) {
            OrganizationalStructure::create([
                'name' => $position,
                'position' => $position,
                'group' => $group,
                'sort_order' => $i,
            ]);
        }
    }

    private function products(): void
    {
        Product::query()->delete();

        $common = [
            'rate_info' => 'Sesuai ketentuan LPS / BPR',
            'tenor_info' => 'Fleksibel',
            'min_amount_info' => 'Terjangkau',
            'fee_info' => 'Biaya ringan & transparan',
            'terms' => 'Syarat dan ketentuan mengikuti kebijakan resmi PT BPR Arta Gandhita.',
            'status' => 'published',
        ];

        $items = [
            ['tabungan', 'Tabungan Umum', 'Simpanan harian untuk menyimpan dana dengan aman dan mudah diakses kapan saja.', '/images/banners/tabungan-umum.jpg', true,
                ['Biaya administrasi bulanan sangat ringan', 'Suku bunga tabungan menarik dan dijamin LPS', 'Setoran awal terjangkau dan penarikan mudah pada jam layanan'],
                ['Fotokopi KTP yang masih berlaku', 'NPWP (jika ada)', 'Mengisi formulir pembukaan rekening di kantor']],
            ['tabungan', 'Tabungan Pegawai', 'Tabungan praktis untuk mengamankan gaji bulanan karyawan dan pegawai instansi.', '/images/banners/tabungan-pegawai.jpg', true,
                ['Dirancang khusus untuk pengelolaan gaji bulanan', 'Aman dan dijamin sesuai ketentuan LPS', 'Layanan pencatatan transaksi yang rapi dan transparan'],
                ['Fotokopi KTP', 'Surat keterangan kerja atau identitas instansi']],
            ['tabungan', 'Tabungan Pelajar', 'Tabungan edukatif bagi pelajar agar terbiasa menyisihkan uang saku sejak dini.', '/images/banners/tabungan-pelajar.jpg', true,
                ['Setoran awal dan setoran selanjutnya sangat ringan', 'Bebas biaya administrasi bulanan', 'Membentuk kebiasaan menabung sejak bangku sekolah'],
                ['Kartu Pelajar atau Kartu Identitas Anak (KIA)', 'Fotokopi KTP Orang Tua / Wali dan Kartu Keluarga']],
            ['tabungan', 'Tabungan Berencana', 'Simpanan berjangka untuk mempersiapkan biaya pendidikan, hari raya, atau kebutuhan keluarga.', '/images/demo/saving-family.jpg', false,
                ['Setoran bulanan rutin sesuai target dana', 'Membantu disiplin menabung untuk rencana masa depan'],
                ['Fotokopi KTP', 'Setoran awal sesuai program yang dipilih']],
            ['kredit', 'Kredit Modal Kerja', 'Tambahan modal untuk kebutuhan operasional, stok barang, dan perputaran usaha UMKM.', '/images/demo/stall.jpg', true,
                ['Plafon dan jangka waktu disesuaikan dengan arus kas usaha', 'Proses survei cepat dan dibantu langsung oleh petugas', 'Suku bunga bersaing dengan rincian angsuran yang jelas'],
                ['Fotokopi KTP Suami & Istri serta Kartu Keluarga', 'Surat Keterangan Usaha (SKU) / NIB / bukti usaha berjalan', 'Dokumen agunan (BPKB kendaraan atau Sertifikat SHM/SHGB)']],
            ['kredit', 'Kredit Investasi', 'Pembiayaan pengadaan tempat usaha, renovasi ruko, atau pembelian peralatan usaha.', '/images/demo/sme-shop.jpg', true,
                ['Jangka waktu menengah hingga panjang sesuai skala usaha', 'Mendukung ekspansi dan peningkatan kapasitas bisnis'],
                ['Fotokopi KTP & Kartu Keluarga', 'Rencana penggunaan dana investasi usaha', 'Dokumen agunan sesuai ketentuan']],
            ['kredit', 'Kredit Konsumtif', 'Pembiayaan untuk berbagai kebutuhan pribadi dan keluarga dengan angsuran tetap.', '/images/demo/hero-consult.jpg', false,
                ['Angsuran tetap setiap bulan hingga lunas', 'Persyaratan dokumen jelas dan proses terarah'],
                ['Fotokopi KTP & Kartu Keluarga', 'Slip gaji atau bukti penghasilan tetap', 'Dokumen agunan sesuai ketentuan']],
            ['kredit', 'Kredit Kendaraan', 'Pembiayaan pembelian kendaraan bermotor untuk menunjang mobilitas usaha maupun keluarga.', '/images/demo/hero-business.jpg', false,
                ['Pilihan tenor fleksibel', 'Proses pengajuan cepat dan transparan'],
                ['Fotokopi KTP & Kartu Keluarga', 'Bukti penghasilan / usaha', 'Dokumen kendaraan dan agunan']],
            ['kredit', 'Kredit Multiguna', 'Pembiayaan serbaguna untuk renovasi rumah, biaya pendidikan anak, atau kebutuhan mendesak.', '/images/demo/vendor.jpg', false,
                ['Penggunaan dana fleksibel untuk berbagai keperluan', 'Didampingi petugas mulai dari konsultasi hingga akad'],
                ['Fotokopi KTP & Kartu Keluarga', 'Bukti penghasilan / usaha berjalan', 'Agunan BPKB atau Sertifikat']],
            ['deposito', 'Deposito Berjangka', 'Penempatan dana berjangka dengan pilihan tenor 1, 3, 6, hingga 12 bulan dan imbal hasil optimal.', '/images/demo/market.jpg', true,
                ['Suku bunga lebih tinggi dibandingkan tabungan biasa', 'Pilihan tenor fleksibel 1, 3, 6, atau 12 bulan', 'Bunga dapat ditransfer setiap bulan atau diperpanjang otomatis (ARO)'],
                ['Fotokopi KTP yang masih berlaku', 'NPWP (jika ada)', 'Penempatan dana sesuai nominal minimum deposito']],
        ];

        foreach ($items as $i => [$type, $name, $summary, $image, $featured, $benefits, $requirements]) {
            Product::create($common + [
                'type' => $type,
                'name' => $name,
                'slug' => Str::slug($name),
                'summary' => $summary,
                'description' => $summary.' Petugas PT BPR Arta Gandhita siap memberikan penjelasan lengkap mengenai simulasi, persyaratan dokumen, serta tahapan pembukaan rekening maupun pengajuan di kantor kami.',
                'image_path' => $image,
                'is_featured' => $featured,
                'benefits' => $benefits,
                'requirements' => $requirements,
                'sort_order' => $i,
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
            [
                'Edukasi Keuangan',
                'Menyusun anggaran usaha kecil dengan sederhana',
                '/images/demo/market.jpg',
                'Langkah praktis memisahkan keuangan pribadi dan pencatatan arus kas harian agar modal usaha tetap terjaga.',
                '<p>Bagi pelaku usaha mikro dan kecil, memisahkan uang pribadi dengan uang usaha merupakan langkah pertama yang sangat penting agar perputaran modal tetap sehat.</p><p>Mulailah dengan mencatat pemasukan dan pengeluaran harian secara rutin, menyisihkan sebagian keuntungan di rekening tabungan terpisah, serta merencanakan tambahan modal kerja sesuai kemampuan arus kas usaha Anda.</p>',
            ],
            [
                'Kegiatan',
                'Kunjungan petugas ke pelaku usaha pasar',
                '/images/demo/stall.jpg',
                'Pendampingan langsung kepada pedagang pasar untuk memudahkan layanan setoran tabungan dan konsultasi modal kerja.',
                '<p>Petugas PT BPR Arta Gandhita secara rutin melakukan kunjungan langsung ke pusat perniagaan dan pasar tradisional untuk mendekatkan layanan perbankan kepada para pedagang.</p><p>Melalui layanan tatap muka ini, nasabah dapat berkonsultasi mengenai pengelolaan simpanan maupun kebutuhan pembiayaan usaha tanpa harus meninggalkan aktivitas berdagang terlalu lama.</p>',
            ],
            [
                'Pengumuman',
                'Informasi jam layanan operasional kantor',
                '/images/demo/office.jpg',
                'Layanan kantor operasional PT BPR Arta Gandhita buka setiap hari kerja Senin hingga Jumat pukul 08.00 – 15.00 WIB.',
                '<p>Kami menginformasikan kepada seluruh nasabah bahwa layanan operasional kas dan pelayanan nasabah di kantor PT BPR Arta Gandhita berlangsung setiap hari Senin sampai Jumat pukul 08.00 hingga 15.00 WIB.</p><p>Untuk konsultasi awal mengenai produk tabungan, kredit, maupun deposito, Anda juga dapat menghubungi petugas kami melalui telepon atau WhatsApp resmi.</p>',
            ],
            [
                'Informasi Produk',
                'Mengenal pilihan tabungan untuk kebutuhan Anda',
                '/images/demo/vendor.jpg',
                'Mulai dari Tabungan Umum, Tabungan Pegawai, hingga Tabungan Pelajar yang dirancang sesuai kebutuhan keluarga.',
                '<p>Setiap keluarga dan pelaku usaha memiliki tujuan keuangan yang berbeda. Oleh karena itu, PT BPR Arta Gandhita menyediakan berbagai pilihan produk tabungan yang aman dan dijamin oleh LPS.</p><p>Silakan kunjungi kantor layanan kami untuk memilih jenis rekening tabungan yang paling sesuai dengan rencana keuangan Anda.</p>',
            ],
        ];

        foreach ($items as $i => [$cat, $title, $img, $excerpt, $body]) {
            Article::create([
                'category_id' => $categories[$cat]->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => $excerpt,
                'body' => $body,
                'thumbnail_path' => $img,
                'status' => 'published',
                'published_at' => now()->subDays($i * 5 + 1),
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

    private function orgChart(): void
    {
        Media::query()->where('collection', 'org_chart')->delete();

        Media::create([
            'collection' => 'org_chart',
            'title' => 'Struktur Organisasi PT BPR Arta Gandhita',
            'caption' => 'Bagan struktur organisasi resmi perusahaan.',
            'path' => '/images/struktur-organisasi.png',
            'mime_type' => 'image/png',
            'sort_order' => 1,
        ]);
    }

    private function awards(): void
    {
        Media::query()->where('collection', 'award')->delete();

        foreach ([
            ['Predikat "Sangat Bagus" Kinerja Keuangan BPR', '2025 · Infobank Award', 'Penghargaan atas kinerja pertumbuhan aset dan kesehatan keuangan BPR.', '/images/awards/award-1.png'],
            ['BPR Terbaik Kategori Aset & Pelayanan UMKM', '2024 · Perbarindo Daerah', 'Apresiasi atas dedikasi penyaluran pembiayaan bagi pelaku usaha mikro dan kecil di daerah.', '/images/awards/award-2.png'],
            ['Penghargaan Kepatuhan & Tata Kelola BPR', '2023 · Lembaga Keuangan', 'Komitmen penerapan prinsip tata kelola perusahaan yang baik dan transparan.', '/images/awards/award-3.png'],
        ] as $i => [$title, $issuerYear, $caption, $path]) {
            Media::create([
                'collection' => 'award',
                'title' => $title,
                'link_label' => $issuerYear,
                'caption' => $caption,
                'path' => $path,
                'mime_type' => 'image/png',
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function galleryAndCareersAndCollaterals(): void
    {
        Media::query()->whereIn('collection', ['gallery', 'career', 'collateral'])->delete();

        foreach ([
            ['Kunjungan & Pendampingan Pelaku UMKM Pasar', 'Kegiatan Lapangan', 'Petugas PT BPR Arta Gandhita mendampingi pedagang pasar dalam pengelolaan tabungan dan modal usaha.', '/images/demo/stall.jpg'],
            ['Edukasi Literasi Keuangan & Budaya Menabung', 'Edukasi Masyarakat', 'Sosialisasi pentingnya perencanaan keuangan keluarga dan pengenalan produk simpanan yang dijamin LPS.', '/images/demo/saving-family.jpg'],
            ['Peningkatan Mutu Layanan Operasional Kantor', 'Internal BPR', 'Komitmen seluruh jajaran pengurus dan staf dalam memberikan pelayanan yang ramah, cepat, dan akurat.', '/images/demo/meeting.jpg'],
        ] as $i => [$title, $badge, $caption, $path]) {
            Media::create([
                'collection' => 'gallery',
                'title' => $title,
                'link_label' => $badge,
                'caption' => $caption,
                'path' => $path,
                'mime_type' => 'image/jpeg',
                'sort_order' => $i + 1,
            ]);
        }

        foreach ([
            ['Account Officer (AO) Kredit & Pemasaran', 'Penuh Waktu · Kantor Pusat', 'Kualifikasi: Pendidikan min. D3/S1 semua jurusan, komunikatif, menyukai pekerjaan lapangan, memiliki SIM C, dan berorientasi pada target pembiayaan UMKM.'],
            ['Staf Customer Service & Teller', 'Penuh Waktu · Kantor Pusat', 'Kualifikasi: Pendidikan min. D3/S1, berpenampilan rapi, teliti, jujur, ramah dalam melayani nasabah, serta mampu mengoperasikan komputer dengan baik.'],
        ] as $i => [$title, $badge, $caption]) {
            Media::create([
                'collection' => 'career',
                'title' => $title,
                'link_label' => $badge,
                'caption' => $caption,
                'path' => '/images/demo/office.jpg',
                'mime_type' => 'image/jpeg',
                'sort_order' => $i + 1,
            ]);
        }

        foreach ([
            ['Tanah & Bangunan Rumah Tinggal Strategis', 'SHM · Hubungi Petugas untuk Harga Limit', 'Akses jalan kendaraan roda empat, lingkungan aman dan dekat fasilitas umum. Dokumen kepemilikan lengkap.', '/images/demo/hero-office.jpg'],
            ['Tempat Usaha / Ruko di Kawasan Perniagaan', 'SHGB · Hubungi Petugas untuk Harga Limit', 'Cocok untuk toko, gudang usaha, maupun kantor dengan lokasi strategis di tepi jalan utama.', '/images/demo/sme-shop.jpg'],
        ] as $i => [$title, $badge, $caption, $path]) {
            Media::create([
                'collection' => 'collateral',
                'title' => $title,
                'link_label' => $badge,
                'caption' => $caption,
                'path' => $path,
                'mime_type' => 'image/jpeg',
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function testimonials(): void
    {
        Testimonial::query()->delete();

        foreach ([
            ['Ibu Ratna Sari', 'Pemilik Warung Sembako', 'Pelayanannya bagus dan ramah. Proses pengajuan modal usaha dijelaskan dengan jelas oleh petugas dari awal sampai pencairan.', '/images/demo/vendor.jpg'],
            ['Bapak Hendra Wijaya', 'Pedagang Pasar', 'Menabung dan mengatur perputaran uang harian jadi lebih mudah karena petugas rutin berkunjung dan komunikatif.', '/images/demo/stall.jpg'],
            ['Ibu Elfa Nuraeni', 'Pelaku Usaha Kuliner', 'Terima kasih kepada PT BPR Arta Gandhita, penempatan deposito dijelaskan terbuka dengan rincian bunga yang jelas.', '/images/demo/market.jpg'],
            ['Bapak Ruswandi', 'Pegawai Swasta', 'Menyimpan gaji bulanan di Tabungan Pegawai terasa tenang, biaya administrasinya ringan dan pelayanannya cepat.', '/images/demo/sme-shop.jpg'],
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

        $samplePdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 118>>stream\nBT /F1 14 Tf 56 760 Td (PT BPR Arta Gandhita - Dokumen Laporan Keuangan Publikasi) Tj 0 -24 Td /F1 10 Tf (Unggah berkas PDF resmi melalui Dashboard Admin.) Tj ET\nendstream\nendobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\nxref\n0 6\n0000000000 65535 f \n0000000009 00000 n \n0000000052 00000 n \n0000000101 00000 n \n0000000204 00000 n \n0000000372 00000 n \ntrailer<</Size 6/Root 1 0 R>>\nstartxref\n439\n%%EOF";

        Storage::disk('public')->put('reports/contoh-laporan-keuangan.pdf', $samplePdf);
        $size = strlen($samplePdf);

        foreach ([
            ['Laporan Keuangan Publikasi Triwulan IV', 'publikasi', 2025, 'Triwulan IV', '2026-01-15'],
            ['Laporan Keuangan Publikasi Triwulan III', 'publikasi', 2025, 'Triwulan III', '2025-10-15'],
            ['Laporan Keuangan Tahunan 2025', 'tahunan', 2025, 'Tahunan', '2026-02-01'],
            ['Laporan Keuangan Publikasi Triwulan IV', 'publikasi', 2024, 'Triwulan IV', '2025-01-15'],
            ['Laporan Keuangan Tahunan 2024', 'tahunan', 2024, 'Tahunan', '2025-02-10'],
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
