<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\FinancialReport;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_renders_successfully(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('PT BPR Arta Gandhita')
            ->assertSee('Simulasi angsuran kredit')
            ->assertSee('Simulasi deposito')
            ->assertSee('Testimonials');
    }

    public function test_products_index_and_detail_pages_render(): void
    {
        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Tabungan Umum')
            ->assertSee('Kredit Modal Kerja')
            ->assertSee('Deposito Berjangka');

        $this->get(route('products.index', ['jenis' => 'kredit']))
            ->assertOk()
            ->assertSee('Kredit Modal Kerja');

        $product = Product::firstOrFail();
        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee($product->name);
    }

    public function test_about_page_renders_successfully(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Visi')
            ->assertSee('Misi Kami')
            ->assertSee('Struktur Organisasi');
    }

    public function test_articles_index_search_and_detail_render(): void
    {
        $this->get(route('articles.index'))
            ->assertOk()
            ->assertSee('Kabar, pengumuman, dan edukasi keuangan.');

        $this->get(route('articles.index', ['cari' => 'anggaran']))
            ->assertOk()
            ->assertSee('Menyusun anggaran usaha kecil');

        $article = Article::firstOrFail();
        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_financial_reports_index_preview_and_download_work(): void
    {
        $this->get(route('reports.index'))
            ->assertOk()
            ->assertSee('Laporan Keuangan Publikasi');

        $report = FinancialReport::firstOrFail();
        $this->get(route('reports.preview', $report))->assertOk();
        $this->get(route('reports.download', $report))->assertOk();
    }

    public function test_contact_page_and_form_submission_work(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Kirim Pesan atau Permintaan Konsultasi');

        $this->post(route('contact.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Konsultasi Kredit Modal Kerja',
            'message' => 'Saya ingin menanyakan persyaratan pengajuan kredit modal kerja untuk usaha toko kelontong.',
        ])->assertRedirect(route('contact'));

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'subject' => 'Konsultasi Kredit Modal Kerja',
        ]);
    }

    public function test_admin_auth_dashboard_and_crud_operations_work(): void
    {
        Storage::fake('public');

        // Guest redirected to admin login
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.login'))->assertOk()->assertSee('Masuk ke Dashboard');

        $admin = User::firstOrFail();

        // Login
        $this->post(route('admin.login.submit'), [
            'email' => $admin->email,
            'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
        ])->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin);

        // Dashboard
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Ringkasan Dashboard');

        // Products CRUD
        $this->get(route('admin.products.index'))->assertOk();
        $this->get(route('admin.products.create'))->assertOk();
        $this->post(route('admin.products.store'), [
            'name' => 'Tabungan Sejahtera',
            'type' => 'tabungan',
            'summary' => 'Simpanan masa depan keluarga.',
            'benefits_text' => "Aman\nMudah",
            'requirements_text' => "KTP\nNPWP",
            'status' => 'published',
        ])->assertRedirect(route('admin.products.index'));

        $newProduct = Product::where('name', 'Tabungan Sejahtera')->firstOrFail();
        $this->get(route('admin.products.edit', $newProduct))->assertOk();

        // Articles CRUD
        $this->get(route('admin.articles.index'))->assertOk();
        $this->get(route('admin.articles.create'))->assertOk();
        $this->post(route('admin.articles.store'), [
            'title' => 'Artikel Uji Coba Admin',
            'excerpt' => 'Ringkasan artikel uji coba.',
            'body' => '<p>Isi artikel lengkap.</p>',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d'),
        ])->assertRedirect(route('admin.articles.index'));

        // Financial Reports CRUD (PDF upload)
        $this->get(route('admin.reports.index'))->assertOk();
        $this->get(route('admin.reports.create'))->assertOk();
        $this->post(route('admin.reports.store'), [
            'title' => 'Laporan Publikasi Triwulan I 2026',
            'type' => 'publikasi',
            'year' => 2026,
            'period' => 'Triwulan I',
            'status' => 'published',
            'published_at' => '2026-04-15',
            'file' => UploadedFile::fake()->create('laporan.pdf', 120, 'application/pdf'),
        ])->assertRedirect(route('admin.reports.index'));

        // Profile, Testimonials, Structures, Branches
        $this->get(route('admin.profile.edit'))->assertOk();
        $this->get(route('admin.profile.edit', ['tab' => 'media']))->assertOk();
        $this->get(route('admin.products.index', ['type' => 'tabungan']))->assertOk();
        $this->get(route('admin.articles.index', ['status' => 'published']))->assertOk();
        $this->get(route('admin.reports.index', ['type' => 'publikasi']))->assertOk();
        $this->post(route('admin.profile.testimonials.store'), [
            'name' => 'Pak Hendra',
            'role' => 'Pengusaha Konveksi',
            'quote' => 'Pelayanan cepat dan sangat membantu modal usaha.',
            'status' => 'published',
        ])->assertRedirect(route('admin.profile.edit', ['tab' => 'testimoni']));

        // Contact Messages Admin
        $msg = ContactMessage::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'subject' => 'Tanya Deposito',
            'message' => 'Mohon informasi bunga deposito terbaru.',
            'status' => 'new',
        ]);
        $this->get(route('admin.messages.index'))->assertOk()->assertSee('Siti Aminah');
        $this->get(route('admin.messages.show', $msg))->assertOk()->assertSee('Mohon informasi bunga deposito terbaru.');
    }
}
