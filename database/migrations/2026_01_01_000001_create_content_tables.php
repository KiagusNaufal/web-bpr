<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->index(); // tabungan | kredit | deposito
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('summary', 300)->nullable();
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();
            $table->json('benefits')->nullable();
            $table->json('requirements')->nullable();
            $table->text('terms')->nullable();
            $table->string('rate_info')->nullable();
            $table->string('tenor_info')->nullable();
            $table->string('min_amount_info')->nullable();
            $table->text('fee_info')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status', 20)->default('draft')->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['type', 'status', 'sort_order']);
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 320)->nullable();
            $table->longText('body');
            $table->string('thumbnail_path')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });

        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type', 30)->index();
            $table->unsignedSmallInteger('year')->index();
            $table->string('period', 50); // mis. "Tahunan", "Triwulan I", "Desember"
            $table->date('published_at')->nullable();
            $table->string('status', 20)->default('draft');
            $table->string('file_path'); // disimpan di disk privat, disajikan lewat controller
            $table->unsignedBigInteger('file_size')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'year', 'type']);
        });

        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('about')->nullable();
            $table->longText('history')->nullable();
            $table->text('vision')->nullable();
            $table->json('missions')->nullable();
            $table->json('values')->nullable();
            $table->string('license_info')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->string('operating_hours')->nullable();
            $table->text('maps_embed_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('organizational_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('organizational_structures')->nullOnDelete();
            $table->string('name');
            $table->string('position');
            $table->string('group', 30)->index(); // komisaris | direksi | pejabat
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 20)->default('cabang'); // pusat | cabang | kas
            $table->string('address');
            $table->string('phone', 40)->nullable();
            $table->string('operating_hours')->nullable();
            $table->string('maps_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('subject', 160);
            $table->text('message');
            $table->string('status', 20)->default('new')->index();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('collection', 30)->index(); // banner | office | activity | gallery
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_label', 60)->nullable();
            $table->string('path');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size')->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['media', 'contact_messages', 'branches', 'organizational_structures', 'company_profiles', 'financial_reports', 'articles', 'products', 'categories'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};

