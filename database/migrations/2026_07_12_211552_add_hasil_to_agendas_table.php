<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {

            $table->text('hasil_kegiatan')->nullable();

            $table->text('hasil_materi')->nullable();

            $table->text('catatan')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {

            $table->dropColumn([
                'hasil_kegiatan',
                'hasil_materi',
                'catatan'
            ]);

        });
    }
};