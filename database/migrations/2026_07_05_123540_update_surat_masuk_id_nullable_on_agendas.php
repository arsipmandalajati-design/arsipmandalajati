<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('agendas')) {
            // 1. Lepas dulu foreign key yang lama agar kolom bisa dimodifikasi
            Schema::table('agendas', function (Blueprint $table) {
                // Gunakan konvensi standar Laravel: nama_tabel_nama_kolom_foreign
                // Atau pastikan sesuai dengan nama yang tertera di migrasi awal agendas
                $table->dropForeign(['surat_masuk_id']);
            });

            // 2. Ubah kolom menjadi nullable
            Schema::table('agendas', function (Blueprint $table) {
                $table->unsignedBigInteger('surat_masuk_id')->nullable()->change();
            });

            // 3. Pasang kembali foreign key dengan pengaman onDelete('set null') atau 'cascade'
            Schema::table('agendas', function (Blueprint $table) {
                $table->foreign('surat_masuk_id')
                      ->references('id')
                      ->on('surat_masuks')
                      ->nullOnDelete(); // Jika surat dihapus, agenda tidak ikut hilang tapi kolom ini jadi null
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('agendas')) {
            // 1. Lepas kembali foreign key nullOnDelete
            Schema::table('agendas', function (Blueprint $table) {
                $table->dropForeign(['surat_masuk_id']);
            });

            // 2. Kembalikan kolom menjadi NOT NULL (nullable false)
            Schema::table('agendas', function (Blueprint $table) {
                $table->unsignedBigInteger('surat_masuk_id')->nullable(false)->change();
            });

            // 3. Pasang kembali foreign key standar bawaan awal
            Schema::table('agendas', function (Blueprint $table) {
                $table->foreign('surat_masuk_id')
                      ->references('id')
                      ->on('surat_masuks')
                      ->cascadeOnDelete(); // Sesuaikan dengan behavior awalmu (misal cascade)
            });
        }
    }
};