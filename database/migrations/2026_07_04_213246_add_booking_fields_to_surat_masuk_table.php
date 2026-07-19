<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_masuks', 'tempat')) {
                $table->string('tempat')->nullable();
            }
            if (!Schema::hasColumn('surat_masuks', 'tanggal_kegiatan')) {
                $table->date('tanggal_kegiatan')->nullable();
            }
            if (!Schema::hasColumn('surat_masuks', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable();
            }
            if (!Schema::hasColumn('surat_masuks', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable();
            }
            if (!Schema::hasColumn('surat_masuks', 'materi')) {
                $table->string('materi')->nullable();
            }
            if (!Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
                $table->integer('jumlah_peserta')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'kursi')) {
                $table->integer('kursi')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'meja')) {
                $table->integer('meja')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'proyektor')) {
                $table->integer('proyektor')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'mic')) {
                $table->integer('mic')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'sound_system')) {
                $table->integer('sound_system')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'kabel_roll')) {
                $table->integer('kabel_roll')->default(0);
            }
            if (!Schema::hasColumn('surat_masuks', 'lainnya')) {
                $table->string('lainnya')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Down method dibiarkan opsional atau disesuaikan jika ingin rollback aman
        });
    }
};