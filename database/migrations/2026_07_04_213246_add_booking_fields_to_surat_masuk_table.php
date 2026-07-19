<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('surat_masuks', 'tempat')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->string('tempat')->nullable();
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'tanggal_kegiatan')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->date('tanggal_kegiatan')->nullable();
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'jam_mulai')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->time('jam_mulai')->nullable();
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'jam_selesai')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->time('jam_selesai')->nullable();
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'materi')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->string('materi')->nullable();
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'jumlah_peserta')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('jumlah_peserta')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'kursi')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('kursi')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'meja')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('meja')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'proyektor')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('proyektor')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'mic')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('mic')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'sound_system')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('sound_system')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'kabel_roll')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->integer('kabel_roll')->default(0);
            });
        }
        if (!Schema::hasColumn('surat_masuks', 'lainnya')) {
            Schema::table('surat_masuks', function (Blueprint $table) {
                $table->string('lainnya')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Down method dibiarkan kosong agar rollback aman
    }
};