<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained()
                  ->nullOnDelete();

            $table->integer('nomor_urut')
                  ->default(1)
                  ->after('kode_arsip_id');

            $table->string('nomor_registrasi')
                  ->nullable()
                  ->after('nomor_urut');

            $table->text('catatan_admin')
                  ->nullable()
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuks', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'nomor_urut',
                'nomor_registrasi',
                'catatan_admin'
            ]);

        });
    }
};