<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Surat Masuk
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            // Relasi ke User penginput & Kode Arsip
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kode_arsip_id')->constrained('kode_arsips')->onDelete('cascade');
            
            // Relasi opsional ke Pejabat (nullable jika belum diisi di awal)
            $table->foreignId('pejabat_id')->nullable()->constrained('pejabats')->onDelete('set null');
            
            // Kolom tracking penomoran otomatis
            $table->integer('nomor_urut');
            $table->string('nomor_registrasi')->unique();
            
            // Metadata Utama Surat
            $table->string('nomor_surat');
            $table->enum('jenis_surat', ['Internal', 'Eksternal']);
            $table->string('sumber_arsip');
            $table->string('judul');
            $table->string('pengirim');
            $table->date('tanggal_surat');
            $table->text('perihal');
            $table->string('file_surat');
            
            // Kolom Alur Kerja Disposisi
            $table->string('status')->default('Belum Disposisi');
            $table->foreignId('user_disposisi_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan_admin')->nullable();

            // Kolom Opsional Booking / Logistik Internal (Disamakan dengan Fillable Model)
            $table->string('tempat')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('materi')->nullable();
            $table->integer('jumlah_peserta')->default(0);
            $table->integer('kursi')->default(0);
            $table->integer('meja')->default(0);
            $table->integer('proyektor')->default(0);
            $table->integer('mic')->default(0);
            $table->integer('sound_system')->default(0);
            $table->integer('kabel_roll')->default(0);
            $table->string('lainnya')->nullable();
            
            $table->timestamps();
        });

        // 2. Tabel Agenda / Booking Fasilitas Kecamatan
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            // Relasi Cascading: Jika data surat dihapus, agenda otomatis terhapus
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->string('tempat');
            $table->date('tanggal_kegiatan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('materi')->nullable();
            
            // Kolom kebutuhan Logistik Internal
            $table->integer('jumlah_peserta')->default(0);
            $table->integer('kursi')->default(0);
            $table->integer('meja')->default(0);
            $table->integer('proyektor')->default(0);
            $table->integer('mic')->default(0);
            $table->integer('sound_system')->default(0);
            $table->integer('kabel_roll')->default(0);
            $table->string('lainnya')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
        Schema::dropIfExists('surat_masuk');
    }
};