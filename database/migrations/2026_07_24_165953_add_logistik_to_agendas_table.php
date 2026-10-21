<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Kolom waktu & materi (jika belum ada)
            if (!Schema::hasColumn('agendas', 'jam_mulai')) $table->time('jam_mulai')->nullable();
            if (!Schema::hasColumn('agendas', 'jam_selesai')) $table->time('jam_selesai')->nullable();
            if (!Schema::hasColumn('agendas', 'materi')) $table->string('materi')->nullable();

            // Kolom Kebutuhan Logistik (Sifatnya Nullable / Opsional)
            if (!Schema::hasColumn('agendas', 'jumlah_peserta')) $table->integer('jumlah_peserta')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'kursi')) $table->integer('kursi')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'meja')) $table->integer('meja')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'proyektor')) $table->integer('proyektor')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'mic')) $table->integer('mic')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'sound_system')) $table->integer('sound_system')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'kabel_roll')) $table->integer('kabel_roll')->nullable()->default(0);
            if (!Schema::hasColumn('agendas', 'lainnya')) $table->string('lainnya')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn([
                'jam_mulai', 'jam_selesai', 'materi',
                'jumlah_peserta', 'kursi', 'meja', 'proyektor',
                'mic', 'sound_system', 'kabel_roll', 'lainnya'
            ]);
        });
    }
};