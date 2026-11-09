# Website Company Profile — PT BPR Arta Gandhita

Website **Company Profile** resmi untuk **PT BPR Arta Gandhita** (Bank Perekonomian Rakyat), dibangun menggunakan **Laravel**, **Tailwind CSS v4 (Vite)**, **JavaScript Vanilla**, **Lucide Icons**, dan **MySQL**.

---

## Fitur Utama

### 1. Halaman Publik
- **Beranda (`/`)**:
  - Slider Banner Hero dengan efek *Ken Burns* halus & indikator progres.
  - Bagian **Produk dan Layanan** terpadu: 3 poster produk resmi (`Tabungan Pegawai`, `Tabungan Pelajar`, `Tabungan Umum`) dan indeks kategori (`Tabungan`, `Kredit`, `Deposito`).
  - **Alur Pengajuan Kredit** 4 langkah.
  - **Informasi & Berita** terbaru dengan filter kategori interaktif.
  - **Kalkulator Simulasi Interaktif**: Pemilih tab **Simulasi Kredit** (perhitungan angsuran anuitas, total bunga, total pembayaran) dan **Simulasi Deposito** (perkiraan bunga sebelum pajak dan total dana akhir) dengan animasi angka *real-time*.
  - **Testimonials**: Susunan grid 2×2 foto persegi nasabah dan kutipan testimoni.
  - **Pertanyaan Umum (FAQ)** & **Lokasi Kantor Layanan**.
- **Produk dan Layanan (`/produk` & `/produk/{slug}`)**:
  - Filter per kategori (`Tabungan`, `Kredit`, `Deposito`), rincian manfaat, persyaratan dokumen, ketentuan suku bunga/tenor/minimal dana, serta kalkulator simulasi kontekstual pada halaman detail produk.
- **Tentang Kami (`/tentang-kami`)**:
  - Profil BPR, sejarah singkat, perizinan & pengawasan (OJK & LPS), Visi & Misi, Nilai-Nilai Perusahaan, Susunan Pengurus (Dewan Komisaris, Direksi, Pejabat Eksekutif), dan Jaringan Kantor Layanan.
- **Informasi (`/informasi` & `/informasi/{slug}`)**:
  - Daftar berita, pengumuman, edukasi keuangan, dan kegiatan dengan pencarian kata kunci, filter kategori, paginasi, serta halaman baca artikel lengkap beserta artikel terkait.
- **Laporan Keuangan (`/laporan-keuangan`)**:
  - Arsip laporan keuangan publikasi, tahunan, neraca, dan laba rugi yang dikelompokkan per tahun, dilengkapi filter tahun & jenis laporan, **Modal Pratinjau PDF**, serta tombol **Unduh PDF**.
- **Kontak Kami (`/kontak`)**:
  - Informasi alamat kantor, nomor telepon, email, jam operasional, tautan WhatsApp, peta lokasi Google Maps, dan formulir pesan/konsultasi tervalidasi yang tersimpan langsung ke database.

### 2. Panel Pengelola / Dashboard Admin (`/admin`)
- **Autentikasi & Hak Akses (`/admin/login`)**:
  - Login khusus admin dengan *role* `Super Admin` dan `Editor` serta proteksi *middleware* (`EnsureActiveAdmin`).
- **Ringkasan Dashboard (`/admin`)**:
  - Statistik total produk, artikel informasi, laporan keuangan PDF, testimoni nasabah, dan pesan kontak baru yang belum dibaca.
- **Kelola Produk & Layanan (`/admin/produk`)**:
  - Tambah, edit, dan hapus produk beserta gambar/poster, manfaat, persyaratan dokumen, suku bunga, tenor, dan status terbit.
- **Kelola Informasi & Berita (`/admin/informasi`)**:
  - Tambah, edit, dan hapus artikel berita/pengumuman/edukasi beserta kategori dan gambar sampul (*thumbnail*).
- **Kelola Laporan Keuangan PDF (`/admin/laporan-keuangan`)**:
  - Unggah berkas `.pdf` (hingga 20 MB), atur jenis laporan, tahun, periode, dan status publikasi.
- **Kelola Profil, Testimoni, Banner & Struktur (`/admin/profil`)**:
  - Pembaruan identitas BPR, sejarah, visi & misi, kontak, logo, testimoni nasabah, slide banner hero & poster produk, susunan pengurus, serta jaringan kantor.
- **Kelola Pesan Masuk (`/admin/pesan`)**:
  - Daftar pesan dari formulir kontak publik, pembaruan status (`Baru`, `Dibaca`, `Dibalas`, `Diarsipkan`), dan balas langsung via email.

---

## Panduan Instalasi & Menjalankan Proyek

### 1. Prasyarat
- PHP >= 8.2 (beserta ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`)
- Composer
- Node.js >= 20 & NPM
- MySQL 8.x

### 2. Konfigurasi Environment (`.env`)
Pastikan konfigurasi database pada berkas `.env` sesuai dengan lingkungan lokal Anda:
```env
APP_NAME="PT BPR Arta Gandhita"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bpr_website
DB_USERNAME=root
DB_PASSWORD=

ADMIN_EMAIL=admin@bpr.test
ADMIN_PASSWORD=ganti-password-ini
```

### 3. Migrasi Database, Seeder & Storage Symlink
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### 4. Kompilasi Aset Frontend (Tailwind CSS v4 & Vite)
```bash
npm install
npm run build
```

### 5. Menjalankan Server Lokal
```bash
php artisan serve
```
- **Halaman Publik**: `http://127.0.0.1:8000`
- **Login Admin**: `http://127.0.0.1:8000/admin/login`
  - **Email Default**: `admin@bpr.test`
  - **Password Default**: `ganti-password-ini` (dapat diubah melalui variabel `ADMIN_PASSWORD` di `.env`)

### 6. Menjalankan Pengujian Otomatis (PHPUnit)
```bash
php vendor/bin/phpunit tests/Feature/PublicPagesTest.php
```
