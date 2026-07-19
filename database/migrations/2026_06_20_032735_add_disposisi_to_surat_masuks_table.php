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
        // Cek apakah kolom 'status_disposisi' belum ada di tabel 'surat_masuks'
        if (!Schema::hasColumn('surat_masuks', 'status_disposisi')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                // Sesuaikan isi di bawah ini dengan tipe data asli bawaan file kamu
                $table->string('status_disposisi')->nullable(); 
            });
        }
    }

public function down(): void
{
    Schema::table('surat_masuks', function (Blueprint $table) {
        $table->dropColumn('disposisi');
    });
}
};
