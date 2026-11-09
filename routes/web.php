<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FinancialReportController as AdminFinancialReportController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/tentang-kami', AboutController::class)->name('about');

Route::get('/informasi', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/informasi/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/laporan-keuangan', [FinancialReportController::class, 'index'])->name('reports.index');
Route::get('/laporan-keuangan/{report}/pratinjau', [FinancialReportController::class, 'preview'])->whereNumber('report')->name('reports.preview');
Route::get('/laporan-keuangan/{report}/unduh', [FinancialReportController::class, 'download'])->whereNumber('report')->name('reports.download');

Route::get('/kontak', [ContactController::class, 'show'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');

/*
|--------------------------------------------------------------------------
| Autentikasi & Dashboard Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');

        // Produk & Layanan
        Route::get('/produk', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/produk/tambah', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/produk', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/produk/{product:id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/produk/{product:id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/produk/{product:id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

        // Informasi & Berita
        Route::get('/informasi', [AdminArticleController::class, 'index'])->name('articles.index');
        Route::get('/informasi/tambah', [AdminArticleController::class, 'create'])->name('articles.create');
        Route::post('/informasi', [AdminArticleController::class, 'store'])->name('articles.store');
        Route::post('/informasi/kategori', [AdminArticleController::class, 'storeCategory'])->name('articles.categories.store');
        Route::get('/informasi/{article:id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/informasi/{article:id}', [AdminArticleController::class, 'update'])->name('articles.update');
        Route::delete('/informasi/{article:id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');

        // Laporan Keuangan PDF
        Route::get('/laporan-keuangan', [AdminFinancialReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan-keuangan/tambah', [AdminFinancialReportController::class, 'create'])->name('reports.create');
        Route::post('/laporan-keuangan', [AdminFinancialReportController::class, 'store'])->name('reports.store');
        Route::get('/laporan-keuangan/{report}/edit', [AdminFinancialReportController::class, 'edit'])->name('reports.edit');
        Route::put('/laporan-keuangan/{report}', [AdminFinancialReportController::class, 'update'])->name('reports.update');
        Route::delete('/laporan-keuangan/{report}', [AdminFinancialReportController::class, 'destroy'])->name('reports.destroy');

        // Profil Perusahaan, Pengurus, Kantor, Testimoni, & Media Banner
        Route::get('/profil', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::post('/profil/pengurus', [AdminProfileController::class, 'storeStructure'])->name('profile.structures.store');
        Route::delete('/profil/pengurus/{structure}', [AdminProfileController::class, 'destroyStructure'])->name('profile.structures.destroy');
        Route::post('/profil/kantor', [AdminProfileController::class, 'storeBranch'])->name('profile.branches.store');
        Route::delete('/profil/kantor/{branch}', [AdminProfileController::class, 'destroyBranch'])->name('profile.branches.destroy');
        Route::post('/profil/testimoni', [AdminProfileController::class, 'storeTestimonial'])->name('profile.testimonials.store');
        Route::delete('/profil/testimoni/{testimonial}', [AdminProfileController::class, 'destroyTestimonial'])->name('profile.testimonials.destroy');
        Route::post('/profil/media', [AdminProfileController::class, 'storeMedia'])->name('profile.media.store');
        Route::delete('/profil/media/{media}', [AdminProfileController::class, 'destroyMedia'])->name('profile.media.destroy');

        // Pesan Kontak Masuk
        Route::get('/pesan', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/pesan/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('/pesan/{message}/status', [AdminContactMessageController::class, 'updateStatus'])->name('messages.status');
        Route::delete('/pesan/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    });
});
