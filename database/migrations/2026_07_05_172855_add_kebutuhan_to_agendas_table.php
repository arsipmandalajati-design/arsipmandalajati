<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom 'kebutuhan' sudah ada di tabel agendas
        if (Schema::hasColumn('agendas', 'kebutuhan')) {
            // Jika sudah ada, biarkan saja atau modifikasi jika perlu
        } else {
            // Jika belum ada, buat langsung tanpa peduli posisi 'after' kolom 'materi'
            Schema::table('agendas', function (Blueprint $table) {
                $table->text('kebutuhan')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            if (Schema::hasColumn('agendas', 'kebutuhan')) {
                $table->dropColumn('kebutuhan');
            }
        });
    }
};