<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Halaman berikut akan diimplementasikan pada tahap berikutnya.
foreach ([
    ['produk', 'products.index', 'Produk dan Layanan'],
    ['tentang-kami', 'about', 'Tentang Kami'],
    ['informasi', 'articles.index', 'Informasi'],
    ['laporan-keuangan', 'reports.index', 'Laporan Keuangan'],
    ['kontak', 'contact', 'Kontak Kami'],
] as [$uri, $name, $title]) {
    Route::view($uri, 'pages.soon', ['title' => $title])->name($name);
}
