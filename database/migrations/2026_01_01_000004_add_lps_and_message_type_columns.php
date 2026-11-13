<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('lps_rate', 30)->nullable()->default('6,75%')->after('license_info');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('category', 30)->default('umum')->index()->after('id'); // umum | pengajuan | pengaduan
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('lps_rate');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
