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
            // Cek apakah kolom 'catatan_admin' sudah ada di tabel
            if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Jika sudah ada, ubah tipenya agar aman menerima nilai null
                    $table->text('catatan_admin')->nullable()->change();
                });
            } else {
                Schema::table('surat_masuks', function (Blueprint $table) {
                    // Jika belum ada, buat baru dan posisikan setelah pejabat_id agar rapi
                    $table->text('catatan_admin')->nullable()->after('pejabat_id');
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
            Schema::table('surat_masuks', function (Blueprint $table) {
                if (Schema::hasColumn('surat_masuks', 'catatan_admin')) {
                    /**
                     * CATATAN: 
                     * Jika tujuanmu adalah mengembalikan kolom ke status bawaan aslimu (NOT NULL), 
                     * gunakan ->change(). Tapi jika migrasi ini awalnya membuat kolom dari nol, 
                     * sebaiknya gunakan: $table->dropColumn('catatan_admin');
                     */
                    $table->text('catatan_admin')->nullable(false)->change();
                }
            });
        }
    }
};