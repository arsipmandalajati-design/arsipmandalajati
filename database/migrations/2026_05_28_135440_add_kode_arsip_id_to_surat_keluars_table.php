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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Relasi ke tabel kode_arsips dengan foreign key constraint
            $table->foreignId('kode_arsip_id')->nullable()->constrained('kode_arsips')->nullOnDelete();
            
            $table->string('nomor_surat');
            $table->string('judul')->nullable();
            $table->string('pengirim');
            $table->string('tujuan');
            $table->date('tanggal_surat');
            $table->text('perihal')->nullable();
            $table->text('disposisi')->nullable(); // Ditambahkan untuk menyamakan fitur disposisi seperti pada surat masuk
            $table->string('file_surat')->nullable();
            $table->string('status')->default('Menunggu ACC');
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