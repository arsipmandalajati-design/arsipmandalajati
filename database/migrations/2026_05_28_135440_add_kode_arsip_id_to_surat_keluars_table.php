<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {

            $table->foreignId('kode_arsip_id')
                  ->nullable()
                  ->constrained('arsips')
                  ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {

            $table->dropForeign(['kode_arsip_id']);

            $table->dropColumn('kode_arsip_id');

        });
    }
};