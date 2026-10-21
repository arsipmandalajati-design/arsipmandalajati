<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {

            // Nomor urut otomatis
            $table->integer('nomor_urut')
                  ->nullable()
                  ->after('kode_arsip_id');

            // Nomor registrasi
            $table->string('nomor_registrasi')
                  ->nullable()
                  ->after('nomor_urut');

            // Status surat
            $table->string('status')
                  ->default('Belum ACC')
                  ->after('file_surat');

            // Pegawai penerima disposisi
            $table->foreignId('user_disposisi_id')
                  ->nullable()
                  ->after('status')
                  ->constrained('users')
                  ->nullOnDelete();

            // Catatan Admin
            $table->text('catatan_admin')
                  ->nullable()
                  ->after('user_disposisi_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_keluars', function (Blueprint $table) {

            $table->dropForeign(['user_disposisi_id']);

            $table->dropColumn([

                'nomor_urut',

                'nomor_registrasi',

                'status',

                'user_disposisi_id',

                'catatan_admin'

            ]);

        });
    }
};