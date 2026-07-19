<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama tabelnya 'surat_keluars'
        if (!Schema::hasColumn('surat_keluars', 'kode_arsip_id')) {
            Schema::table('surat_keluars', function (Blueprint $table) {
                $table->foreignId('kode_arsip_id')->nullable()->constrained('kode_arsips')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {

            $table->dropForeign(['kode_arsip_id']);

            $table->dropColumn('kode_arsip_id');

        });
    }
};