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
        // PENGAMAN: Hanya buat tabel jika tabel 'surat_masuks' BELUM ada di database
        if (!Schema::hasTable('surat_masuks')) {
            Schema::create('surat_masuks', function (Blueprint $table) {

                $table->id();
            
                // =============================
                // INFORMASI ARSIP
                // =============================
                $table->foreignId('kode_arsip_id')
                      ->nullable()
                      ->constrained('kode_arsips')
                      ->nullOnDelete();
            
                $table->string('nomor_surat')->unique();
            
                $table->string('jenis_surat');
            
                $table->string('sumber_arsip');
            
                // =============================
                // INFORMASI SURAT
                // =============================
            
                $table->string('judul');
            
                $table->string('pengirim');
            
                $table->date('tanggal_surat');
            
                $table->text('perihal');
            
                $table->string('file_surat');
            
                // =============================
                // DATA BOOKING
                // =============================
            
                $table->string('tempat')->nullable();
            
                $table->date('tanggal_kegiatan')->nullable();
            
                $table->time('jam_mulai')->nullable();
            
                $table->time('jam_selesai')->nullable();
            
                $table->string('materi')->nullable();
            
                // =============================
                // KEBUTUHAN
                // =============================
            
                $table->integer('jumlah_peserta')->default(0);
            
                $table->integer('kursi')->default(0);
            
                $table->integer('meja')->default(0);
            
                $table->integer('proyektor')->default(0);
            
                $table->integer('mic')->default(0);
            
                $table->integer('sound_system')->default(0);
            
                $table->integer('kabel_roll')->default(0);
            
                $table->string('lainnya')->nullable();
            
                // =============================
                // STATUS
                // =============================
            
                $table->enum('status',[
                    'Belum Disposisi',
                    'Sudah Disposisi',
                    'Sudah Dijadikan Agenda'
                ])->default('Belum Disposisi');
            
                $table->foreignId('user_disposisi_id')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete();
            
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};