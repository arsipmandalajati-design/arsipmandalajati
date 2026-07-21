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
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel users & kode_arsips
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('kode_arsip_id')
                  ->nullable()
                  ->constrained('kode_arsip') // Sesuaikan nama tabel kode_arsip kamu di DB
                  ->onDelete('set null');

            $table->string('nomor_surat');
            $table->string('judul')->nullable();
            $table->string('pengirim');
            $table->string('tujuan');
            $table->date('tanggal_surat');
            $table->text('perihal')->nullable();

            // Fitur Disposisi & Status
            $table->text('disposisi')->nullable()->default('Menunggu ACC'); 
            $table->string('status')->default('Menunggu ACC');

            $table->string('file_surat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};