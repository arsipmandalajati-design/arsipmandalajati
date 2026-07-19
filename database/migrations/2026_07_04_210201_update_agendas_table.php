<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu apakah kolom 'surat_masuk_id' belum ada di tabel 'agendas'
        if (!Schema::hasColumn('agendas', 'surat_masuk_id')) {
            Schema::table('agendas', function (Blueprint $table) {

                $table->foreignId('surat_masuk_id')
                      ->nullable()
                      ->after('id')
                      ->constrained('surat_masuks')
                      ->cascadeOnDelete();

                $table->time('jam_mulai')->nullable();

                $table->time('jam_selesai')->nullable();

                $table->text('materi')->nullable();

                $table->string('foto_kegiatan')->nullable();

            });
        }
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            if (Schema::hasColumn('agendas', 'surat_masuk_id')) {
                $table->dropForeign(['surat_masuk_id']);
            }

            $table->dropColumn([
                'surat_masuk_id',
                'jam_mulai',
                'jam_selesai',
                'materi',
                'foto_kegiatan'
            ]);
        });
    }
};