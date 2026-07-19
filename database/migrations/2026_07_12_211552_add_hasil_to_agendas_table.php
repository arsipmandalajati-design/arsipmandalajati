<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Cek dulu apakah kolom hasil_kegiatan sudah ada atau belum
            if (!Schema::hasColumn('agendas', 'hasil_kegiatan')) {
                $table->text('hasil_kegiatan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            if (Schema::hasColumn('agendas', 'hasil_kegiatan')) {
                $table->dropColumn('hasil_kegiatan');
            }
        });
    }
};