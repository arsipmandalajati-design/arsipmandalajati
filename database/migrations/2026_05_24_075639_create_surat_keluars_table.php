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
            $table->foreignId('user_id');
            $table->foreignId('kode_arsip_id')->nullable();
            $table->string('nomor_surat');
            $table->string('judul')->nullable();
            $table->string('tujuan');
            $table->date('tanggal_surat');
            $table->text('perihal')->nullable();
            $table->string('file_surat')->nullable();
            
            // Tambahkan kolom status di bawah ini dengan nilai default
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