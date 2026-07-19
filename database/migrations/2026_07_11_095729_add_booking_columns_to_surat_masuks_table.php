<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            // Kebutuhan
            $table->integer('jumlah_peserta')->default(0);

            $table->integer('kursi')->default(0);
            $table->integer('meja')->default(0);
            $table->integer('proyektor')->default(0);
            $table->integer('mic')->default(0);
            $table->integer('sound_system')->default(0);
            $table->integer('kabel_roll')->default(0);

            $table->string('lainnya')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->dropColumn([
                'jumlah_peserta',
                'kursi',
                'meja',
                'proyektor',
                'mic',
                'sound_system',
                'kabel_roll',
                'lainnya'
            ]);

        });
    }
};