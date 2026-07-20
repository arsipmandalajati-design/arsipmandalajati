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
        if (Schema::hasTable('surat_masuks')) {
            // Cek dulu, kalau kolom 'user_id' BELUM ADA, baru ditambahkan
            if (!Schema::hasColumn('surat_masuks', 'user_id')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Ditempatkan di awal setelah 'id' agar struktur relasi user penginput terlihat rapi
                    $table->foreignId('user_id')
                          ->nullable()
                          ->after('id')
                          ->constrained('users')
                          ->cascadeOnDelete(); 
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('surat_masuks')) {
            
            // 1. Lepas dulu foreign key constraint-nya secara mandiri
            if (Schema::hasColumn('surat_masuks', 'user_id')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                });
            }

            // 2. Baru drop kolom user_id setelah bebas dari constraint
            if (Schema::hasColumn('surat_masuks', 'user_id')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }
            
        }
    }
};